<?php
include('config/config.php');
include('functions.php');

$active = semester(1, $conn);
$semester = semester(0, $conn);

@include("config/db_connect.php");
include "./shared/nav-items.php";
session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:user-login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Student Management</title>
    <meta charset="utf-8">

  <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

    <link rel="stylesheet" href="css/sidebar.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        $('#dataTable_1').DataTable({
            columnDefs: [{
                    // The `data` parameter refers to the data for the cell (defined by the
                    // `data` option, which defaults to the column being worked with, in
                    // this case `data: 0`.
                    render: function(data, type, row) {
                        let element = document.getElementById(`qr${data}`);
                        if (element.childElementCount == 2) return "";

                        new QRCode(element, {
                            text: data,
                            width: 128,
                            height: 128,
                        });
                        element.addEventListener("click", function() {
                            const img = this.children[
                                1
                            ]; // check console.. element has children; first a canvas, second is an img tag

                            //create a virutal anchor tag that will simulate download
                            const link = document.createElement("a");
                            link.href = img.src; // contains only dataurl
                            link.download = `${data}.jpeg`; // attribute
                            link.click(); // click virtual anchor tag
                            delete link;
                        });
                        return "";
                    },
                    targets: 1,
                },
                {
                    visible: true,
                    targets: [1]
                },
            ],
        });
    });
    </script>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
        </div>
        <?php navItems("Student Profile") ?>
    </div>
    <section class="home-section">
        <!-- <div class="header">
      <h3>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h3>
    </div> -->
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard">Student Profile</span>
            </div>

            <form action="" id="form" method="POST">
                <div class="search-box">
                    <?=$semester?>
                    <i class="bx bx-search"></i>
                </div>
            </form>
        </nav>

        <div class="home-content">
            <section class="attendance">
                <div class="attendance-list">
                    <!-- <a href="student_add_record.php" class="btn"> <i class='bx bx-plus'></i>Add Student Information</a> -->

                    <!-- This is the import modal -->
                    <button type="button" class="btn " data-toggle="modal" data-target="#modal-studentinfo">
                        Add Student Information </button>
                    <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal">
                        Import Student </button><br></br>


                    <!-- <a href="import-excel/indexstudent.php" class="btn">Import Student</a><BR></BR> -->
                    <!-- start of the table -->
                    <?php
						
            if (isset($_SESSION["error"])) {
              
              echo '<span style="font-size:24px;color:red" class="error-msg">' . $_SESSION["error"] . '</span>';
              $_SESSION["error"] = null;
              
              };
          ?>
                    <table id="dataTable_1" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>QR Image</th>
                                <th>Student ID No.</th>
                                <th>Name</th>
                                <th>Sex</th>
                                <th>Course Year & Section</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--PHP CODE HERE LIST ALL THE DATA AVAILABLE IN DATABASE-->
                            <?php
                if(isset($_POST['semester_id'])) {
                    $semester_id = $_POST['semester_id'];
                    
                } else {
                    $semester_id = $active['id'];
                }

                $sql = "SELECT * FROM tblstudentinfo WHERE semester_id = $semester_id AND is_deleted = '0'";
              $res = $conn->prepare($sql);
              $res->execute();

              $i = 1;
              if ($res->rowCount() > 0) {
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>
                  <td>" . $i . "</td>
                <td id='qr". trim($row["stud_id"]) ."'> ". $row["stud_id"] ."</td>
                <td>" . $row['stud_id'] . "</td>
                <td>" . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</td>
                <td>" . $row['sex'] . "</td>
                
                <td>" . $row['cys'] ."</td>
                <td><a href = 'student_edit_record.php?id=" . $row['id'] . "'> <i class='far fa-edit text-info h4'></i></a> | ";
              ?>

                            <a href="#" class="delete" data-student_id="<?=$row['id']?>">
                                <i class="far fa-trash-alt text-danger h4"></i>
                            </a>
                            <?php

                  $i++;
                }
              } else {
                echo "<tr> <td colspan = '9'> NO RECORDS FOUND</td> </tr>";
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
            $(function() {
                $('#semester_id').addClass('form-control h-100');

                $('#semester_id').on('change', function() {
                    $('#form').trigger('submit');
                });
            });
            $(function() {
                $(document).on('click', '.delete', function() {
                    var student_id = $(this).data('student_id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Once deleted, it cannot be undone. Proceed anyway?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'student_delete_record.php',
                                method: 'POST',
                                data: {
                                    student_id: student_id,
                                    delete: `delete`
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response == 'success') {
                                        Swal.fire('DELETED!',
                                            'Record has been deleted', 'success'
                                        );
                                        setInterval(
                                            function() {
                                                location.href = 'student.php';
                                            }, 2000
                                        );
                                    }
                                }
                            });
                        }
                    });
                });
            });
            </script>
            <?php if(isset($_POST['semester_id'])):?>
            <script>
            $('#semester_id').val(<?=$_POST['semester_id']?>);
            </script>
            <?php endif;?>
            <?php include 'modal/exportStudent_modal.php';?>
            <?php include 'modal/studentInfo_modal.php';?>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
                crossorigin="anonymous"></script>
            <script src="javascript/script.js"></script>
            <script src="javascript/qrcode.min.js"></script>


</body>

</html>