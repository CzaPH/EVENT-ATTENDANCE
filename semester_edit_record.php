<?php
require("config/db_connect.php");

if (isset($_POST["btnsave"])) {
  $id = $_POST["id"];
  $semester_code = $_POST["txtsemester_code"];
  $semester_description = $_POST["txtsemester_description"];
  $semester_year = $_POST["txtsemester_year"];

  if ($semester_code == "") {
    echo "Please input valid code!";
  } elseif ($semester_description == "") {
    echo "Please input valid description!";
  } elseif ($semester_year == "") {
    echo "Please input valid Year!";
  } else {


    $sql = "UPDATE tblsemester SET semester_code=:semester_code, semester_description=:semester_description, semester_year=:semester_year WHERE id = :recordid";

    $result = $conn->prepare($sql);
    $values = array(":semester_code" => $semester_code, ":semester_description" => $semester_description, ":semester_year" => $semester_year, ":recordid" => $id);

    $result->execute($values);

    if ($result->rowCount() > 0) {
      echo "<script>alert('Record has been saved'); window.location = 'semester.php';</script>";
    } else {
      echo "<script>alert('No record has been saved'); window.location = 'semester.php';  </script>";
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
  <title>Edit & Update Student Record</title>
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

        $sql = "SELECT id,semester_code, semester_description,semester_year FROM tblsemester WHERE id = :recordid";

        $id = "";
        $semester_code = "";
        $semester_description = "";
        $semester_year = "";

        try {
          $res = $conn->prepare($sql);
          $value = array(":recordid" => $_REQUEST["id"]);

          try {
            $res->execute($value);
            if ($res->rowCount() > 0) {

              $row = $res->fetch(PDO::FETCH_ASSOC);
              $id = $row["id"];
              $semester_code  = $row["semester_code"];
              $semester_description = $row["semester_description"];
              $semester_year = $row["semester_year"];
            }
          } catch (PDOException $e) {
            die("An Error has been occured!");
          }
        } catch (PDOException $e) {
          die("An Error has been occured!");
        }
        ?>
        <form action="semester_edit_record.php" method="post">
          <input type="hidden" name="id" value="<?php echo "$id" ?>">
          <h3>Edit & Update Course Record</h3>
          <input type="text" value="<?php echo "$semester_code" ?>" name="txtsemester_code" required placeholder="Enter course code">
          <input type="text" value="<?php echo "$semester_description" ?>" name="txtsemester_description" required placeholder="Enter course description">
          <input type="text" value="<?php echo "$semester_year" ?>" name="txtsemester_year" required placeholder="Enter course code">


          <input type="submit" name="btnsave" value="Save" class="form-btn">
          <li>
            <a href="semester.php">
              <i class='bx bx-arrow-back'></i>
              <span class="links_name"> Back</span>
            </a>
          </li>
        </form>
      </div>
</body>

</html>