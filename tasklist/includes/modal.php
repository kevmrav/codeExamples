<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" novalidate id="modal-form">

            <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="name" required>
                        <div class="invalid-feedback">
                            Please add a task name
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Description:</label>
                        <textarea class="form-control" id="description" required></textarea>
                        <div class="invalid-feedback">
                            Please add a task description
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="target-complete" class="col-form-label">Target Completion Date:</label>
                        <input type="text" class="form-control" id="target-complete" readonly="readonly" required>
                        <div class="invalid-feedback">
                            Please add a task target completion date
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit" id="modal-submit-button">Submit test</button>
            </div>
            </form>

        </div>
    </div>
</div>

