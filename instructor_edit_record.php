<?php
require("config/db_connect.php");

if (isset($_POST["btnsave"])) {
  $id = $_POST["id"];
  $employee_number = $_POST["txtemployee_number"];
  $fname = $_POST["txtfname"];
  $mname = $_POST["txtmname"];
  $lname = $_POST["txtlname"];

  if ($employee_number == "") {
    echo "Please input Employee Number!";
  } elseif ($fname == "") {
    echo "Please input valid First Name!";
  } elseif ($mname == "") {
    echo "Please input valid Middle Name!";
  } elseif ($lname == "") {
    echo "Please input valid Last Name!";
  } else {


    $sql = "UPDATE tblinstructor SET employee_number=:employee_number, fname=:fname, mname=:mname, lname=:lname, employee_password=:employee_password WHERE id = :recordid";

    $result = $conn->prepare($sql);
    $values = array(":employee_number" => $employee_number, ":fname" => $fname, ":mname" => $mname, ":lname" => $lname, ":employee_password" => $employee_password, ":recordid" => $id);

    $result->execute($values);

    if ($result->rowCount() > 0) {
      echo "<script>alert('Record has been saved'); window.location = 'instructor.php';</script>";
    } else {
      echo "<script>alert('No record has been saved'); window.location = 'instructor.php';  </script>";
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
  <title>Edit & Update Instructor Record</title>
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

        $sql = "SELECT id,employee_number, fname,mname,lname FROM tblinstructor WHERE id = :recordid";

        $id = "";
        $employee_number = "";
        $fname = "";
        $mname = "";
        $lname = "";
        $employee_password = "";

        try {
          $res = $conn->prepare($sql);
          $value = array(":recordid" => $_REQUEST["id"]);

          try {
            $res->execute($value);
            if ($res->rowCount() > 0) {

              $row = $res->fetch(PDO::FETCH_ASSOC);
              $id = $row["id"];
              $employee_number  = $row["employee_number"];
              $fname = $row["fname"];
              $mname = $row["mname"];
              $lname = $row["lname"];
            }
          } catch (PDOException $e) {
            die("An Error has been occured!");
          }
        } catch (PDOException $e) {
          die("An Error has been occured!");
        }
        ?>
        <form action="instructor_edit_record.php" method="post">
          <input type="hidden" name="id" value="<?php echo "$id" ?>">
          <h3>Edit & Update Course Record</h3>
          <label>Employee Number:<br>
            <input type="text" value="<?php echo "$employee_number" ?>" name="txtemployee_number" required placeholder="Employee Number"></label>
          <label>First Name:<br>
            <input type="text" value="<?php echo "$fname" ?>" name="txtfname" required placeholder="First Name"></label>
          <label>Middle Name:<br>
            <input type="text" value="<?php echo "$mname" ?>" name="txtmname" required placeholder="Middle Name Name"></label>
          <label>Last Name:<br>
            <input type="text" value="<?php echo "$lname" ?>" name="txtlname" required placeholder="Last Name"> </label>


          <input type="submit" name="btnsave" value="Save" class="form-btn">
          <li>
            <a href="instructor.php">
              <i class='bx bx-arrow-back'></i>
              <span class="links_name"> Back</span>
            </a>
          </li>
        </form>
      </div>
</body>

</html>