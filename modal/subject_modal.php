<div class="modal fade" id="modal-subject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Subject Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <div class="span3 hidden-phone"></div>
                      <form action = "subject_add_record.php" method = "post">
                      <div class = "form-group">
                        <label>Subject Code:</label>
                        <input type="text" name="txtsubject_code" required placeholder="Enter Subject Code" class = "form-control">
                        </div>
                        <div class = "form-group">
                            <label>Subject Description:</label>
                            <input type="text" name="txtsubject_description" required placeholder="Enter Subject Description" class = "form-control">
                        </div>
          <div class="modal-footer">
                      <button type="submit" id="submit" name="btnsave" class="btn btn-primary button-loading" data-loading-text="Loading...">Save</button>
                      </div>
				</form>

                      </div>
                    
                    </div>
                  </div>
                </div>