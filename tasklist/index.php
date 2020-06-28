<!doctype html>

<?php
require_once('includes/taskClass.php');
require_once('includes/modal.php');

$taskClass = new TaskClass();
$taskRecords = $taskClass->getRows();
?>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Online Med Ed</title>
    
    <!-- CSS -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
          crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="includes/styles.css" media="all">

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js' type='text/javascript'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
    <script src="includes/scripts.js"></script>


</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><i class="fa fa-tasks fa-2x" aria-hidden="true"></i><span class="navbar-title">My To-Do Task List</span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<div id="message-container" style="display: none;"></div>

<div id="container">
    
    <button type="button"
            class="btn btn-primary add-button"
            data-toggle="modal"
            data-target="#taskModal"
            data-operation="add"
    >
        <i class="fa fa-plus" aria-hidden="true"></i>
        Add New Task
    </button>
    
    
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Completed</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Target Completion Date</th>
            <th scope="col">Completion Date</th>
            <th scope="col">Edit</th>
            <th scope="col">Remove</th>
        </tr>
        </thead>
        <tbody>
    
        <?php
        foreach ($taskRecords as $task){
            $taskCheck = $style = null;

            if ($task->completion_date){
                $taskCheck = ' checked ';
                $style = ' style="text-decoration: line-through;" ';
            }

            ?>
            <tr id="<?php echo $task->id;?>" <?php echo $style;?> >
                <th scope="row">
                    <div class="form-check">
                        <input type="checkbox"  class="form-check-input completed-task" <?php echo $taskCheck;?> >
                    </div>
                </th>
                <th scope="row">
                    <?php echo $task->task_name;?>
                </th>
                <th scope="row">
                    <?php echo $task->task_description;?>
                </th>
                <th scope="row">
                    <?php echo $task->target_date;?>
                </th>
                <th scope="row">
                    <?php echo $task->completion_date;?>
                </th>
                <th scope="row">
                    <div class="form-group col-sm-1 edit-task"
                         data-toggle="modal"
                         data-target="#taskModal"
                         data-operation="edit"
                         data-task_id="<?php echo $task->id;?>" >
                        <i class="far fa-pencil-alt"></i>
                    </div>
                </th>
                <th>
                    <div class="form-group col-sm-1 delete-task" >
                        <i class="far fa-trash-alt"></i>
                    </div>
                </th>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

</div>

</body>
</html>