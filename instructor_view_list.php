<?php
require("config/db_connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manage Semester Information</title>
  <link rel="stylesheet" href="css/sidebar.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="instructor_subject_assign.php?id=<?php echo $_GET['id']?>">
        <i class='bx bx-arrow-back'></i>
          <span class="links_name">Back</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">Student Profile</span>
      </div>
      <form onsubmit="return ajsearch();">
        <h1>SEARCH FOR USERS</h1>
        <input type="text" id="search" required />
        <input type="submit" value="Search" />
      </form>

      <!-- (B) SEARCH RESULTS -->
      <div id="results"></div>
    </nav>

    <div class="home-content">
      <section class="attendance">
        <div class="attendance-list">
          <a href="student_add_record.php" class="btn"> <i class='bx bx-plus'></i>Add Student Information</a>
          <a href="import-excel/indexstudent.php" class="btn">Import Student</a>
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
                
                echo "<br><br><tr  colspan = '9'> NO RECORDS FOUND </tr>";
              }

              ?>

            </tbody>
          </table>
        </div>
      </section>

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
      <script>
        function ajsearch() {
          // (A) GET SEARCH TERM
          var data = new FormData();
          data.append("search", document.getElementById("search").value);
          data.append("ajax", 1);

          // (B) AJAX SEARCH REQUEST
          fetch("2-search.php", {
              method: "POST",
              body: data
            })
            .then(res => res.json()).then((results) => {
              var wrapper = document.getElementById("results");
              if (results.length > 0) {
                wrapper.innerHTML = "";
                for (let res of results) {
                  let line = document.createElement("div");
                  line.innerHTML = `${res["name"]} - ${res["email"]}`;
                  wrapper.appendChild(line);
                }
              } else {
                wrapper.innerHTML = "No results found";
              }
            });
          return false;
        }
      </script>
</body>

</html>