<!DOCTYPE html>
<?php 
	include ("db.php");
	
?>	
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Import Excel To MySQL Database Using PHP </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Import Excel File To MySql Database Using php">

		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
		<link rel="stylesheet" href="css/bootstrap-custom.css">


	</head>
	<body>    
		</div>
	</div>

	<div id="wrap">
	<div class="container">
		<div class="row">
			<div class="span3 hidden-phone"></div>
			<div class="span6" id="form-login">
				<form class="form-horizontal well" action="importsubjects.php" method="post" name="upload_excel" enctype="multipart/form-data">
					<fieldset>
						<legend>Import Subject Information</legend>
						<?php
						session_start();
							if (isset($_SESSION["error"])) {
								
								echo '<span class="error-msg">' . $_SESSION["error"] . '</span>';
								$_SESSION["error"] = null;
								
								};
						?>
						<div class="control-group">
							<div class="control-label">
								<label>CSV/Excel File:</label>
							</div>
							<div class="controls">
								<input type="file" name="file" id="file" class="input-large">
							</div>
						</div>
						
						<div class="control-group">
							<div class="controls">
							<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="span3 hidden-phone"></div>
		</div>

	</body>
</html>