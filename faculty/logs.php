<?php
    include('../config/config.php');
    session_start();
    if($_SESSION['user_id'] == "")
    {
        $_SESSION['user_id'];
        header('location:../index.php');
        exit;
    }

    if(isset($_GET['id'])) {
        $id = filter($_GET['id']);
        $class_id = filter($_GET['class']);

        $query  = $conn->prepare("SELECT * FROM tblstudentinfo WHERE id = ?");
        $query->bind_param('i', $id);
        $query->execute();

        $result = $query->get_result();
        $row = mysqli_fetch_array($result);
        

        $query2  = $conn->prepare("SELECT *
                                    FROM
                                        tblattendance
                                        INNER JOIN schedules 
                                            ON (tblattendance.schedule_id = schedules.schedule_id)
                                    WHERE fk_subject_id = ?
                                    GROUP BY logdate");
        $query2->bind_param('i', $class_id);
        $query2->execute();
        $result2 = $query2->get_result();

    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manage Student Profile</title>
  <link rel="stylesheet" href="../css/dashboard.css" />
  <link rel="stylesheet" href="../css/sidebar.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Faculty</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="reports.php?id=<?=$class_id?>">
            <i class='bx bx-arrow-back'></i>
            <span class="links_name">Back</span>
            </a>
        </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="header">
      <h5>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNLOGY</h5>
    </div>
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard"></span><?php echo $_SESSION['USER_NAME'] ?>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search..." />
        <i class="bx bx-search"></i>
      </div>
    </nav>
    <!-- END OF THE SIDE BAR -->
    
    <div class="home-content">
    <center>
        <h5 class="bg-white mx-3 p-3 border rounded shadow">
            <b><?=strtoupper($row['stud_id'])?> - <?=strtoupper($row['lname'].', '.$row['fname'].' '.$row['mname'])?></b>
        </h5>
    </center>
    <section class="attendance">
        <div class="attendance-list p-3">
            <table class="table" id="dt">
                <thead>
                    <tr>
                        <th>SCHEDULE</th>
                        <th>DATE</th>
                        <th>TIME IN</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result2 as $row2):?>
                        <tr>
                            <td><?=$row2['day_of_the_week']?> (<?=date('h:i a' , strtotime($row2['start_time']))?> <?=date('h:i a' , strtotime($row2['end_time']))?>)</td>
                            <td><?=date('F j, Y', strtotime($row2['logdate']))?></td>
                            <?php
                                $select = $conn->prepare("SELECT * FROM tblattendance 
                                    WHERE fk_student_id = ? AND logdate = ? AND fk_subject_id = ?");
                                
                                $select->bind_param('isi', $id, $row2['logdate'], $class_id);
                                $select->execute();
                                $r_select = $select->get_result();
                                $r_row = mysqli_fetch_array($r_select);
                            ?>
                            <?php if(mysqli_num_rows($r_select) > 0):?>
                                <td>
                                    <?=date('h:i a', strtotime($r_row['time_in']))?>
                                </td>
                                <td>
                                    <?php if($r_row['is_late'] == true):?>
                                        Late
                                    <?php else:?>
                                        On Time
                                    <?php endif;?>
                                </td>
                            <?php else:?>
                                <td>n/a</td>
                                <td>Absent</td>
                            <?php endif;?>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        $('#dt').DataTable({
            ordering:false
        });
      });
    </script>
</body>

</html>