<?php
require("../config/db_connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manage Student Profile</title>
  <link rel="stylesheet" href="../css/sidebar.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Faculty</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="../faculty/subjects.php" class="active">
          <i class="bx bx-arrow-back"></i>
          <span class="links_name">Back</span>
        </a>
      </li>
     
    </ul>
  </div>
  <section class="home-section">
    <div class="header">
      <h1>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h1>
    </div>
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard"></span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search..." />
        <i class="bx bx-search"></i>
      </div>
    </nav>

    <div class="home-content">
    <section class="attendance">
        <div class="attendance-list">
          <table class="table">
            <thead>
              <tr>
              <th>#</th>
                <th>Student ID No.</th>
                <th>Name</th>
                <th>Course Year & Section</th>
                
              </tr>
            </thead>
            <tbody>
              <!--PHP CODE HERE -->
              <?php
              $numid = $_REQUEST['id'];
              $sql = "SELECT B.stud_id, B.fname, B.mname, B.lname, C.coursecode, D.section_code, E.year_code
              FROM tbl_student_add_subject AS A
              INNER JOIN tblstudentinfo AS B ON A.fk_student_id = B.id
              INNER JOIN tblcourse AS C ON B.fk_course_id = C.id
              INNER JOIN tblsection AS D ON B.fk_section_id = D.id
              INNER JOIN tblyear AS E ON B.fk_year_id = E.id
              WHERE fk_subject_id = $numid";

                $res = $conn->prepare($sql);
                $res->execute();

                $i = 1;
                if ($res->rowCount() > 0) {
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                <td>" . $i . "</td>
                <td>" . $row['stud_id'] . "</td>
                <td>" . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</td>
                <td>" . $row['coursecode'] . " " . $row['year_code'] . " - " . $row['section_code'] . "</td>";
              
                    $i++;
                }
                } else {
                echo "<tr> <td colspan = '9'> NO RECORDS FOUND</td> </tr>";
                }

                ?>

            </tbody>
          </table>
    </div>



    <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      };
    </script>
</body>

</html>