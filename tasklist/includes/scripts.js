$(document).ready(function () {

    $('#taskModal').hide();


    //Datepicker
    $('#target-complete').datepicker({
        dateFormat: 'mm/dd/yyyy'
    }).on('changeDate', function(e){
        $(this).datepicker('hide');
    });


    /*
    Modal form validation and submission via ajax call
     */
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }else{
                        //Form validated and can now submit
                        var operation = $('#modal-submit-button').data('operation'),
                            taskName = $('#name').val(),
                            taskDescription = $('#description').val(),
                            taskTargetComplete = $('#target-complete').val(),
                            result = null,
                            errorMessage = null,
                            jsonData = {};

                        if (operation == 'add'){
                            var errorMessage = 'Could not add your task at this time. Please try again';

                            jsonData = {
                                    'operation': operation,
                                    'name': taskName,
                                    'description': taskDescription,
                                    'target_completion_date': taskTargetComplete
                                };

                        }else if (operation == 'edit'){
                            var taskId = $('#modal-submit-button').data('task_id'),
                                errorMessage = 'Could not edit your task at this time. Please try again';

                            jsonData = {
                                    'operation': operation,
                                    'id': taskId,
                                    'name': taskName,
                                    'description': taskDescription,
                                    'target_completion_date': taskTargetComplete
                                };
                        }

                        //Call router via ajax call and appropriate json payload
                        result = callRouter(jsonData);

                        if (result.success){
                            //Reload page to refresh task table
                            location.reload();
                        }else{
                            showMessage(errorMessage);
                        }

                        $('#taskModal').modal('hide');
                        emptyFormFields();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();


    /*
    Show the modal to add or edit task.

    If operation is 'add', show blank form
    If operation is 'edit', retrieve content to load onto form
     */
    $('#taskModal').on('shown.bs.modal', function (event) {
        emptyFormFields();

        $('#name').trigger('focus');

        var source = $(event.relatedTarget),
            operation = source.data('operation');

        if (operation == 'add'){
            var date = new Date(),
                month = date.getMonth()+1,
                day = date.getDate(),
                year = date.getFullYear(),
                targetDate = month + "/" + day + "/" + year;

            //Set default target date to today
            $('#target-complete').val(targetDate);
            $('.modal-title').html('Add a new task');

            //Assign operation type to the modal's submit button
            $('#modal-submit-button').data('operation', 'add');

        }else if (operation == 'edit'){
            var taskId  = source.data('task_id');
                result = null,
                errorMessage = null,
                jsonData = {
                    'operation': 'retrieve',
                    'task_id': taskId
                };

            $('.modal-title').html('Edit your task');
            //Assign data attributes to the modal's submit button.
            $('#modal-submit-button').data('operation', 'edit');
            $('#modal-submit-button').data('task_id', taskId);

            result = callRouter(jsonData);

            if (result.success){
                var targetDate = null;
                if (result.data.target_date){
                    var date = new Date(result.data.target_date),
                        month = date.getMonth()+1,
                        day = date.getDate(),
                        year = date.getFullYear();

                    targetDate = month + "/" + day + "/" + year;
                }
                //Load modal form data
                $('#name').val(result.data.task_name);
                $('#description').val(result.data.task_description);
                $('#target-complete').val(targetDate);
            }else{
                showMessage("Could not get the task you were looking for.  Please try again");
                emptyFormFields();
                $('#taskModal').modal('hide');
            }
        }

    });


    /*
    Sets tasks as complete or incomplete based on checkbox status.
    If checked, sets the completion date
    If unchecked, unsets the completion date
     */
    $('.completed-task').on('click', function(){
        var taskId = $(this).parent().closest('tr').attr('id'),
            jsonData = {
                'operation': 'completion',
                'task_id': taskId
            },
            result = null;

        result = callRouter(jsonData);

        if (result.success){
            //Reload page to refresh task table
            location.reload();
        }else{
            showMessage('Could not complete your task at this time. Please try again');
        }

        
    });


    /*
    Delete selected task
     */
    $('.delete-task').on('click', function(){

        var taskId = $(this).parent().closest('tr').attr('id'),
            jsonData = {
                'operation': 'delete',
                'task_id': taskId
            },
            result = null;

        //Call router via ajax call and appropriate json payload
        result = callRouter(jsonData);
        if (result.success){
            //Reload page to refresh task table
            location.reload();
        }else{
            showMessage('Could not delete your task at this time. Please try again');
        }
    });

});


/*
Ajax call to call router.php
with json payload
 */
function callRouter(jsonData) {
    var result = null;

    $.ajax({
        type: "POST",
        url: "includes/router.php",
        data: jsonData,
        dataType: 'json',
        async: false,
        success: function (r) {
            result = r;
        },
        error: function (e) {
            result = {'success':false};
        }
    });

    return result;
}

/*
Clear of the modal's form fields
 */
function emptyFormFields(){
    $('#name, #description,#target-complete').val('');
}

/*
 Display message onto page below header
 */
function showMessage(incomingMessage) {
    $('#message-container')
        .html(incomingMessage)
        .fadeIn(100)
        .delay(3000)
        .fadeOut(1000);
}
