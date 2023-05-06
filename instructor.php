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
@include './instructorhandler/instructor_eventhandler.php';
@include './config/db_connection.php';
            
$_conn = new ConnectionHandler();
$_instructor = new Instructor($_conn);
$result = $_instructor->getInstructor();
$number_daw_sabi_ni_czarina = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Instructor Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
 
  <link rel="stylesheet" href="css/sidebar.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
    </div>
    <?php navItems("Instructor") ?>
  </div>
  <section class="home-section">
    <!-- <div class="header">
      <h3>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h3>
    </div> -->
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">Instructor Management</span>
      </div>
     
    </nav>

    <div class="home-content">
    </div>
    <section class="attendance">
      <div class="attendance-list">
      <button type="button" class="btn " data-toggle="modal" data-target="#modal-instructor">
              Add Instructor Profile </button>        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Employee ID</th>
              <th>Instructor Name</th>
              <!-- <th>View</th> -->
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!--PHP CODE HERE -->
            <!--PHP CODE HERE -->
            
            <?php foreach ($result as $key => $item) { ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $item["employee_number"] ?></td>
                <td><?= $item["fname"] ?> <?= $item["mname"] ?> <?= $item["lname"] ?></td>
                <!-- <td><a href="instructor_subject_assign.php?id=<?= $item["id"] ?>">Assign Subjects</a> </td> -->
                <td>
                  <!-- <a href="instructor_edit_record.php?id=<?= $item["id"] ?>">
                  <i class='far fa-edit text-info h4'></i>
                  </a> -->
                  <a href="#" class="delete"
                             data-instructor_id ="<?=$item['id']?>">    
                                <i class="far fa-trash-alt text-danger h4"></i>
                            </a>
                </td>
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

      $(function(){
        $(document).on('click','.delete', function(){
            var instructor_id  = $(this).data('instructor_id');
           
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
                        url:'instructor_delete_record.php',
                        method:'POST',
                        data:{
                          instructor_id:instructor_id,
                            delete:`delete`
                        },
                        dataType:'json',
                        success:function(response){
                          console.log (response);
                            if(response == 'success') {
                                 location.href = 'instructor.php';
                            }
                        }
                    });
                }
            });
        });

        
    });
    </script>
     <?php include 'modal/instructor_modal.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="javascript/script.js"></script>
</body>

</html>