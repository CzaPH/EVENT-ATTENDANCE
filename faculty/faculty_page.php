<?php
require("../config/config.php");
include "../shared_faculty/nav-items.php";
include('../functions.php');

session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:../index.php');
    exit;
}

if(isset($_SESSION['user_id'])) {
    $faculty_id = $_SESSION['user_id'];

    $query  = $conn->prepare("SELECT *
                                FROM
                                    classes
                                    WHERE 
                                    instructor_id = ?");
    $query->bind_param('i', $faculty_id);
    $query->execute();

    $result = $query->get_result();

    $students = 0;

    $querys  = $conn->prepare("SELECT classes.*, tblsubject.*
                                FROM
                                    classes
                                INNER JOIN tblinstructor 
                                    ON (classes.instructor_id = tblinstructor.id)
                                INNER JOIN tblsemester 
                                    ON (classes.semester_id = tblsemester.id)
                                INNER JOIN tblsubject 
                                    ON (classes.subject_id = tblsubject.id)
                                INNER JOIN tblcourse 
                                    ON (classes.course_id = tblcourse.id)
                                WHERE classes.instructor_id = ?");
    $querys->bind_param('i', $faculty_id);
    $querys->execute();

    $rs = $querys->get_result();
}

if(isset($_POST['search'])) {
    $date_from = filter($_POST['date_from']);
    $date_to = filter($_POST['date_to']);
    $fk_subject_id = filter($_POST['class_id']);
    $semester_id = filter($_POST['semester_id']);
    $group_by = filter($_POST['group_by']);

    $query2     = $conn->prepare("SELECT count(list_id) as num
                                        FROM
                                            class_list
                                            INNER JOIN classes 
                                                ON (class_list.class_id = classes.class_id)
                                                WHERE class_list.class_id = ? AND semester_id = ?
                                                GROUP BY student_id");
    $query2->bind_param('ii',$fk_subject_id, $semester_id);
    $query2->execute();

    $result2 = $query2->get_result();
    foreach($result2 as $row2) {
        $students += $row2['num']; 
    }


    

    if(!empty($date_from) && !empty($date_to)){
        
        if($group_by == 'daily') {
            $search = $conn->prepare("SELECT count(tblattendance.id) as count, logdate
                    FROM
                        tblattendance
                        RIGHT JOIN tblstudentinfo 
                            ON (tblattendance.fk_student_id = tblstudentinfo.id)
                            WHERE faculty_id = ? AND fk_subject_id = ? 
                            GROUP BY logdate");
        } else if($group_by == 'monthly') {
            $search = $conn->prepare("SELECT count(tblattendance.id) as count, logdate
                    FROM
                        tblattendance
                        RIGHT JOIN tblstudentinfo 
                            ON (tblattendance.fk_student_id = tblstudentinfo.id)
                            WHERE faculty_id = ? AND fk_subject_id = ? 
                            AND logdate BETWEEN ? AND ?
                            GROUP BY DATE(logdate)");
        }

        $search->bind_param('iiss', $faculty_id, $fk_subject_id, $date_from, $date_to);

    } else {
        if($group_by == 'daily') {
            $search = $conn->prepare("SELECT count(tblattendance.id) as count, logdate
                    FROM
                        tblattendance
                        RIGHT JOIN tblstudentinfo 
                            ON (tblattendance.fk_student_id = tblstudentinfo.id)
                            WHERE faculty_id = ? AND fk_subject_id = ? 
                            GROUP BY logdate");
        } else if($group_by == 'monthly') {
            $search = $conn->prepare("SELECT count(tblattendance.id) as count, logdate
                    FROM
                        tblattendance
                        RIGHT JOIN tblstudentinfo 
                            ON (tblattendance.fk_student_id = tblstudentinfo.id)
                            WHERE faculty_id = ? AND fk_subject_id = ? 
                            GROUP BY DATE(logdate)");
        }

        $search->bind_param('ii', $faculty_id, $fk_subject_id);
    }

    $search->execute();

    $dataPoints = array();
    $v = $search->get_result();

    $c = $conn->prepare("SELECT count(list_id) AS total_students FROM class_list WHERE class_id = ?");
    $c->bind_param('i', $fk_subject_id);
    $c->execute();
    $rc = $c->get_result();
    $s = mysqli_fetch_array($rc);

foreach($v as $a){
    $total_students = $s['total_students'];
    $count = $a['count'];

    $difference = ($total_students - $count);
    $percentage = ($difference / $total_students) * 100;
    $perc = ($count / $total_students) * 100;

    $label = date('M j, Y', strtotime($a['logdate'])) .' '.$count.'/'.$total_students.' (-'.$difference.') ('.$perc.'%)';
    array_push($dataPoints, array("y"=> $count,"label"=> $label));
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Dashboard</title>
<link rel="stylesheet" href="../css/dashboard.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <style>
    .canvasjs-chart-credit{
        display:none !important;
    }
  </style>
</head>
<script type="text/javascript">

window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        exportEnabled: false,
        theme: "light1", // "light1", "light2", "dark1", "dark2"
        title:{
            text: "Total Present over <?=$total_students?> Students per Date"
        },
        data: [{
            type: "column", //change type to bar, line, area, pie, etc  
            indexLabelPlacement: "outside",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
}
</script>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Faculty</span>
    </div>
    <?php navItems("Dashboard") ?>
  </div>
  <section class="home-section">
    <!-- <div class="header">
      <h5>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h5>
    </div> -->
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard"></span><?php echo $_SESSION['USER_NAME'] ?>
      </div>
    </nav>

    <div class="home-content">
       <!-- Content Row -->
               <!-- Content Row -->
        <!-- Subject Card Example -->
        <div class="row justify-content-center">
            <div class="col-sm-3">
                    <div class="card border-left-warning shadow mb-3">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                class="text-xs font-weight-bold text-info text-uppercase mb-1"
                                >
                                Subjects
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?=mysqli_num_rows($result)?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?php if(isset($_POST['search'])):?>
                    <!-- Student Card Example -->
                    <div class="card border-left-warning shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Students
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?=$students?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bx bxs-user-circle circle fa-2x text-gray-300"></i>
                            </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>

<div class="container">
<div class="row mt-2">
    <div class="col-sm-3" style="float:left;">
        <form action="" method="POST">
            <?=group()?>
            <b>Semester</b>
            <?=semester(0, $conn)?>
            <b>Subject</b>
            <select name="class_id" id="class_id" class="w-100" required>
                <option value="">SELECT</option>
                <?php foreach($rs as $rws):?>
                    <?php
                        $schedule = str_replace(array('[',']',"\"") ,'', $rws['schedules']);

                        $query3 = $conn->prepare("SELECT * FROM schedules WHERE schedule_id IN ($schedule)");
                        $query3->execute();
                        
                        $results = $query3->get_result();
                    ?>
                    <option value="<?=$rws['class_id']?>">
                        <?=strtoupper($rws['subject_code'])?> - <?=strtoupper($rws['subject_description'])?>
                        <br />
                        (<?php foreach($results as $rows):?>
                            <?=$rows['day_of_the_week']?> (<?=date('h:i a' , strtotime($rows['start_time']))?> to <?=date('h:i a' , strtotime($rows['end_time']))?>)
                        <?php endforeach;?>)
                    </option>
                <?php endforeach;?>
            </select>
            <b>From</b>
            <input type="date" name="date_from" id="date_from" class="w-100">
            <b>To</b>
            <input type="date" name="date_to" id="date_to" class="w-100">
            <button type="submit" class="btn btn-info mt-3 pull-right" name="search">
                <i class="fas fa-search"></i> SEARCH
            </button>
        </form>
    </div>
    <div class="col-sm-9" style="float:left;">
        <?php if(isset($_POST['search'])):?>
            <?php if(mysqli_num_rows($v) > 0):?>
                <div id="chartContainer"></div>
            <?php else:?>
                <center>
                    No result found. <br />
                    <i class="fas fa-chart-bar text-info border border-info rounded-circle p-5" style="font-size:200px;"></i>
                </center>
            <?php endif;?>
        <?php else:?>
            <center>
                Search to display graph. <br />
                <i class="fas fa-chart-bar text-info border border-info rounded-circle p-5" style="font-size:200px;"></i>
            </center>
        <?php endif;?>
    </div>
</div>
</div>