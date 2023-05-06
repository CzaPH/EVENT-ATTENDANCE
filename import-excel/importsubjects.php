<?php
include '../config/config.php';
if (isset($_POST["Import"])) {


	 $filename = $_FILES["file"]["tmp_name"];


	if ($_FILES["file"]["size"] > 0) {

		$file = fopen($filename, "r");
		while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
			//Duplication trapping. If user import data with the same id number it wouldn't be imported
			$select = " SELECT * FROM tblsubject WHERE subject_code = '$emapData[0]' ";
			$result = mysqli_query($conn, $select);

			if (mysqli_num_rows($result) > 0) {
		 session_start();
			  $_SESSION["error"] = 'Coure Code is Aleady Exist!';
			echo "<script type=\"text/javascript\">
							window.location = \"../subject.php\"
					</script>";
			}else {

                $query  = $conn->prepare("SELECT * FROM tblsemester WHERE is_active = true");
                $query->execute();
                $results = $query->get_result();
                $rows = mysqli_fetch_array($results);
				//It wiil insert a row to our subject table from our csv file`
				$sql = "INSERT INTO tblsubject (subject_code, subject_description, fk_semester_id) VALUES('$emapData[0]', '$emapData[1]', ".$rows['id'].")";
				//we are using mysql_query function. it returns a resource on true else False on error
				$result = mysqli_query($conn, $sql);
				if (!$result) {
					echo "<script type=\"text/javascript\">
								alert(\"Invalid File:Please Upload CSV File.\");
								window.location = \"indexsubjects.php\"
							</script>";
							
				}else{
					echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"../subject.php\"
					</script>";
				}
			}
	}
		fclose($file);
		//throws a message if data successfully imported to mysql database from excel file
		// echo "<script type=\"text/javascript\">
		// 				alert(\"CSV File has been successfully Imported.\");
		// 				window.location = \"../student.php\"
		// 			</script>";



		//close of connection
		mysqli_close($conn);
	}
}
