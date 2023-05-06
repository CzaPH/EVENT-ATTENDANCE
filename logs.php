<?php
require("config/db_connect.php");
session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:user-login.php');
    exit;
}

include "./shared/nav-items.php";
@include './userhandler/user_eventhandler.php';
@include './config/db_connection.php';

$_conn = new ConnectionHandler();
$_user = new User($_conn);
$result = $_user->getUser();
$number_daw_sabi_ni_czarina = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>User Management</title>
    <link rel="stylesheet" href="css/sidebar.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
        </div>
        <?php navItems("User Logs") ?>
    </div>
    <section class="home-section">
        <div class="header">
            <h1>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNLOGY</h1>
        </div>
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard">User Management</span>
            </div>

        </nav>

        <div class="home-content">
        </div>
        <section class="attendance">
            <div class="attendance-list">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <!-- <th>Password</th> -->
                            <th>Date Created</th>

                        </tr>
                    </thead>
                    <tbody>
                        <!--PHP CODE HERE -->

                        <?php foreach ($result as $key => $item) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $item["employee_number"] ?></td>
                            <td><?= $item["fname"] ?> <?= $item["mname"] ?> <?= $item["lname"] ?></td>
                            <!-- <td><?= $item["password"] ?></td> -->
                            <td><?= $item["date_created"] ?></td>
                        </tr>
                        <?php } ?>

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
</body>

</html>