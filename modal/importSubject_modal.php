<div class="modal fade" id="import-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Subjects Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="span3 hidden-phone"></div>
                <div class="span6" id="form-login">
                    <form class="form-horizontal well" action="import-excel/importsubjects.php" method="post"
                        name="upload_excel" enctype="multipart/form-data">
                        <fieldset>
                            <?php
						
							// if (isset($_SESSION["error"])) {
								
							// 	echo '<span class="error-msg">' . $_SESSION["error"] . '</span>';
							// 	$_SESSION["error"] = null;
								
							// 	};
						?>
                            <div class="control-group">
                                <div class="control-label">
                                    <label>CSV FILE:</label>
                                </div>
                                <div class="controls">
                                    <input type="file" name="file" id="file" class="input-large">
                                </div>
                            </div>

                </div>
                </fieldset>
                <div class="modal-footer">
                    <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading"
                        data-loading-text="Loading...">Import</button>
                </div>
                </form>

            </div>

        </div>
    </div>
</div>