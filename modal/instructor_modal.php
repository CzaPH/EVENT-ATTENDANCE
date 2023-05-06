<div class="modal fade" id="modal-instructor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Instructor Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="span3 hidden-phone"></div>

                <form action="instructor_add_record.php" method="post">
                    <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            };
         };
         ?>
                    <div class="form-group">
                        <label>Employee ID #:</label>
                        <input type="text" name="txtemployee_number" required placeholder="Enter Employee ID Number"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label>First Name:</label>
                        <input type="text" name="txtfname" required placeholder="Enter  First name"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Middle Name:</label>
                        <input type="text" name="txtmname" required placeholder="Enter  Middle name"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Last Name:</label>
                        <input type="text" name="txtlname" required placeholder="Enter Last name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" name="password" required placeholder="Password" class="form-control">
                    </div>
                    </fieldset>
                    <div class="modal-footer">
                        <button type="submit" id="submit" name="btnsave" class="btn btn-primary button-loading"
                            data-loading-text="Loading...">Save</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>