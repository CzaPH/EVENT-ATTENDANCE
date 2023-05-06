<?php
require("../config/config.php");
session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:../index.php');
    exit;
}
if(isset($_GET['id'])) {
    $class_id = $_GET['id'];
    $query     = $conn->prepare("SELECT *
                                FROM
                                    class_list
                                    INNER JOIN tblstudentinfo 
                                        ON (class_list.student_id = tblstudentinfo.id)
                                    INNER JOIN classes 
                                        ON (class_list.class_id = classes.class_id)
                                        WHERE tblstudentinfo.is_deleted = false AND classes.class_id = ?
                                        GROUP BY tblstudentinfo.id
                                        ORDER BY tblstudentinfo.lname ASC");
    $query->bind_param('i', $class_id);
    $query->execute();
    $result     = $query->get_result();

    $query2     = $conn->prepare("SELECT *
                                    FROM
                                        classes
                                        INNER JOIN tblsubject 
                                            ON (classes.subject_id = tblsubject.id)
                                            WHERE classes.class_id = ?");
    $query2->bind_param('i', $class_id);
    $query2->execute();
    $result2 = $query2->get_result();
    $row2 = mysqli_fetch_array($result2);
} else {
    header('Location:subjects.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Class List</title>
    <link rel="stylesheet" href="../css/sidebar.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
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
        <!-- <div class="header">
      <h1>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h1>
    </div> -->
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard"></span>
                <h5 class="pt-2 ml-5">
                    <b><?=strtoupper($row2['subject_code'])?> - <?=strtoupper($row2['subject_description'])?></b>
                </h5>
            </div>

        </nav>

        <div class="home-content">
            <section class="attendance">
                <div class="attendance-list">
                    <table class="table" id="dt">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID No.</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--PHP CODE HERE -->
                            <?php
                if (mysqli_num_rows($result) > 0) {
                    foreach($result as $key => $row) {
                        echo "<tr>
                        <td>" . ($key + 1) . "</td>
                        <td>" . $row['stud_id'] . "</td>
                        <td style='text-transform:uppercase !important;'>" . $row['lname'] . ", " . $row['fname'] . " " . $row['mname'] . "</td>";
                    }
                } else {
                    echo "<tr> <td colspan = '3'> <center>NO RECORD FOUND</center></td> </tr>";
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
                $(function() {
                    $('#dt').DataTable();
                });
                </script>
</body>

</html>