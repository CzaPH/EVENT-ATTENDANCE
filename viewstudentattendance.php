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
        <a href="report.php">
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
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Student ID</th>
                <th>Subject</th>
                <th>Time In</th>
                <th>Logdate</th>
                <th>Status</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
              <!--PHP CODE HERE -->
              <?php
              $numid = $_REQUEST['id'];
              $sql = "SELECT * FROM tblattendance WHERE fk_subject_id = 'IT 411'";

              $res = $conn->prepare($sql);
              $res->execute();

              $i = 1;
              if ($res->rowCount() > 0) {
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>
                <td>" . $i . "</td>
                <td>" . $row['fk_student_id'] . " </td>
                <td>" . $row['fk_subject_id'] . "</td>
                <td>" . $row['time_in'] . "</td>
                <td>" . $row['logdate'] . "</td>
                <td>" . $row['status'] . "</td>
                <td><a href = 'view.php?id=" . $row['fk_student_id'] . "'>Edit Status</a> </td>
                ";
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