<?php
if(isset($_REQUEST["id"])){
    require("config/db_connect.php");

    $id = $_REQUEST["id"];

    $sql = "UPDATE tblinstructor set is_deleted = 1 where id = :recordid";

    $result = $conn->prepare($sql);
    $values = array(":recordid" => $id);

    $result -> execute($values);

    if($result->rowCount()>0){
        echo "<script>alert('Record has been deleted!'); window.location='user.php';</script>";

    }else{
        echo "<script>alert('No record has been deleted!'); window.location='user.php';</script>";
    }

}
?>