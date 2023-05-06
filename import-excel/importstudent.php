<?php
include ("../config/config.php");
include("../functions.php");
include ("../phpqrcode/qrlib.php");

if (isset($_POST["Import"])) {

    $active = semester(1, $conn);
    $semester_id = $active['id'];
	$filename = $_FILES["file"]["tmp_name"];


	if ($_FILES["file"]["size"] > 0) {

		$file = fopen($filename, "r");
		while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {

			$codeContents = $emapData[1];

            // QRcode::png($codeContents, '../qrcode_images/'.$emapData[1].'.png', QR_ECLEVEL_L, 5);

            $query  = $conn->prepare("SELECT * FROM tblstudentinfo WHERE stud_id = ? AND semester_id = ?");
            $query->bind_param('si',$codeContents, $semester_id);
            $query->execute();
            $result = $query->get_result();

            if(mysqli_num_rows($result) < 1) {
                $sql = "INSERT INTO tblstudentinfo (stud_id, fname, sex, qrname, cys, semester_id) 
                        VALUES('$emapData[1]','$emapData[2]','$emapData[3]','$codeContents','$emapData[4]', '$semester_id')";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    echo "<script type=\"text/javascript\">
                                alert(\"Invalid File:Please Upload CSV File.\");
                                window.location = \"../student.php\"
                            </script>";
                }else{
                    echo "<script type=\"text/javascript\">
                        alert(\"CSV File has been successfully Imported.\");
                        window.location = \"../student.php\"
                    </script>";
                }
            } else {
                echo "<p><a href='../student.php'>Click to go back</a> Student with $codeContents already exist. This was not imported. This is a filter. Please ignore.</p>"; 
            }
	}
		fclose($file);
		mysqli_close($conn);
	}
}