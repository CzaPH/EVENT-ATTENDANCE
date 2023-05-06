<?php
include("config/config.php");


session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:user-login.php');
    exit;
}
if (isset($_POST['delete'])) {
  $course_id = filter($_POST['course_id']);

  $delete = $conn->prepare("DELETE FROM tblcourse WHERE id = ?");
  $delete->bind_param("i", $course_id);
  $delete->execute();

  exit(json_encode('success'));
}
include('header.php');
?>


<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
    </div>
    <?php navItems("Course") ?>
  </div>
  <section class="home-section">
  <!-- <div class="header">
      <h3>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h3>
    </div> -->
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">Course Record</span>
      </div>
      
    </nav>

    <div class="home-content">
    </div>
    <section class="attendance">
      <div class="attendance-list">
        <!-- MODAL -->
        <button type="button" class="btn " data-toggle="modal" data-target="#modal-course">
              Add Course Information </button><br></br>
        <!-- <a href="course_add_record.php" class="btn"> <i class='bx bx-plus'></i> Add Course Information</a> -->
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Course Code</th>
              <th>Course Description</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!--PHP CODE HERE -->
            <?php
            //echo "<tr> <td colspan = '9'>Total of records is $count</td> </tr>";

            @include './coursehandler/course_eventhandler.php';
            @include './config/db_connection.php';
            $_conn = new ConnectionHandler();
            $_course = new Course($_conn);
            $result = $_course->getCourse();
            $number_daw_sabi_ni_czarina = 1;

            array_map(function ($info) use (&$number_daw_sabi_ni_czarina) {
              echo "<tr>
          <td>" . $number_daw_sabi_ni_czarina . "</td>
          <td>" . $info['coursecode'] . "</td>
          <td>" . $info['coursedescription'] . "</td>

          <td><a href = 'course_edit_record.php?id=" . $info['id'] . "'><i class='far fa-edit text-info h4'></i></a> | ";
            ?>

<a href="#" class="delete"
                             data-course_id ="<?=$info['id']?>">
                                <i class="far fa-trash-alt text-danger h4"></i>
                            </a>
            <?php
              echo "</tr>";
              $number_daw_sabi_ni_czarina++;
            }, $result) ?>


          </tbody>
        </table>
      </div>
    </section>
    <?php @include 'modal/course_modal.php';?>

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
            var course_id  = $(this).data('course_id');
           
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
                        url:'course.php',
                        method:'POST',
                        data:{
                          course_id:course_id,
                            delete:`delete`
                        },
                        dataType:'json',
                        success:function(response){
                          console.log (response);
                            if(response == 'success') {
                                 location.href = 'course.php';
                            }
                        }
                    });
                }
            });
        });

        
    });
</script>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="javascript/script.js"></script>
   
</body>

</html>