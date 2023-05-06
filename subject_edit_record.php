<?php
require("config/db_connect.php");

if (isset($_POST["btnsave"])) {
    $id = $_POST["id"];
    $subject_code = $_POST["txtsubject_code"];
    $subject_description = $_POST["txtsubject_description"];

    if ($subject_code == "") {
        echo "Please input valid Student ID!";
    } elseif ($subject_description == "") {
        echo "Please input valid Name!";
    } else {


        $sql = "UPDATE tblsubject SET subject_code=:subject_code, subject_description=:subject_description WHERE id = :recordid";

        $result = $conn->prepare($sql);
        $values = array(":subject_code" => $subject_code, ":subject_description" => $subject_description, ":recordid" => $id);

        $result->execute($values);

        if ($result->rowCount() > 0) {
            echo "<script>alert('Record has been saved'); window.location = 'subject.php';</script>";
        } else {
            echo "<script>alert('No record has been saved');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit & Update subject Record</title>
    <link rel="stylesheet" href="css/add_record.css" />
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <div class="container">

        <!--main page-->
        <section class="main">
            <div class="main-top">
                <h1>College of Computing Studies, Information and Communication Technology</h1>
            </div>

            <div class="form-container">
                <!--php code-->
                <?php

                $sql = "SELECT id,subject_code, subject_description FROM tblsubject WHERE id = :recordid";

                $id = "";
                $subject_code = "";
                $subject_description = "";

                try {
                    $res = $conn->prepare($sql);
                    $value = array(":recordid" => $_REQUEST["id"]);

                    try {
                        $res->execute($value);
                        if ($res->rowCount() > 0) {

                            $row = $res->fetch(PDO::FETCH_ASSOC);
                            $id = $row["id"];
                            $subject_code  = $row["subject_code"];
                            $subject_description = $row["subject_description"];
                        }
                    } catch (PDOException $e) {
                        die("An Error has been occured!");
                    }
                } catch (PDOException $e) {
                    die("An Error has been occured!");
                }
                ?>
                <form action="subject_edit_record.php" method="post">
                    <input type="hidden" name="id" value="<?php echo "$id" ?>">
                    <h3>Edit & Update Subject Record</h3>
                    <input type="text" value="<?php echo "$subject_code" ?>" name="txtsubject_code" required placeholder="Enter course code">
                    <input type="text" value="<?php echo "$subject_description" ?>" name="txtsubject_description" required placeholder="Enter course description">

                    <input type="submit" name="btnsave" value="Save" class="form-btn">
                    <li>
                        <a href="subject.php">
                            <i class='bx bx-arrow-back'></i>
                            <span class="links_name"> Back</span>
                        </a>
                    </li>
                </form>
            </div>
</body>

</html>