<?php
require("config/db_connect.php");
if(isset($_REQUEST["delete_id"])){


    $id = $_REQUEST["delete_id"];

    echo $sql = "DELETE FROM tbl_faculty_add_subject WHERE id = :recordid";

    $result = $conn->prepare($sql);
    $values = array(":recordid" => $id);

    $result -> execute($values);

    if($result->rowCount()>0){
        //Transfer of parameters. Kapag nadelete yung isang record babalik duon na kasama yung id.
        // window.location='student_assigning.php (ETO YUNG FUNCTION SA PHP) 
        // ? (close and open parenthesis)
        // id (Parameter or variable name)
        // 'return_id' (The value of the id is the return Id)
        // & sign (ETO YUNG COMA SA HTML. SEPERATION SA HTML)
        echo "<script>alert('Record has been deleted!'); window.location='instructor_subject_assign.php?id=". $_GET['return_id'] ."';</script>";

    }else{
        echo "<script>alert('No record has been deleted!'); window.location='instructor_subject_assign.php?id=".$_GET['return_id'] ."';</script>";
    }

}
?>

