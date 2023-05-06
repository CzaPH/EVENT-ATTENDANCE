<div class="modal fade" id="modal-semester" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Semester Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <div class="span3 hidden-phone"></div>
                      <form action = "semester_add_record.php" method = "post">
                      <div class = "form-group">
                      <label>Semester Code:</label>
                      <input type="text" name="txtsemester_code" required placeholder="Enter Semester Code" class = "form-control">
                      </div>
                      <div class = "form-group">
                        <label>Semester Year:</label>
       <input type="text" name="txtsemester_year" required placeholder="Enter Semester Year" class = "form-control">
       </div>
       <div class = "form-group">
        <label>Semester Description:</label>
      <input type="text" name="txtsemester_description" required placeholder="Enter Semester Description" class = "form-control">
      </div>
      <!-- <div class = "form-group d-none">
        <label>Semester Status</label>
      <input type="text" name="txtsemester_status" value="1" required placeholder="Enter Semester Status" class = "form-control">
      </div> -->
          <div class="modal-footer">
                      <button type="submit" id="submit" name="btnsave" class="btn btn-primary button-loading" data-loading-text="Loading...">Save</button>
                      </div>
				</form>

                      </div>
                    
                    </div>
                  </div>
                </div>