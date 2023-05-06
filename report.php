<?php
require("config/config.php");
include('functions.php');

$active = semester(1, $conn);
$semester = semester(0, $conn);

session_start();
$_SESSION["user_id"];

$q = $conn->prepare("SELECT * FROM tblinstructor WHERE user_type = 'Faculty'");
$q->execute();
$res = $q->get_result();



if(isset($_POST['class_id']) && !empty($_POST['class_id'])) {
    $class_id = filter($_POST['class_id']);
    $semester_id = filter($_POST['semester_id']);
    $date_from = filter($_POST['date_from']);
    $date_to = filter($_POST['date_to']);

    $query1 = $conn->prepare("SELECT *
                                FROM
                                    classes
                                    INNER JOIN tblsubject 
                                        ON (classes.subject_id = tblsubject.id)
                                        WHERE class_id = ? AND semester_id = ?");
    $query1->bind_param('ii', $class_id, $semester_id);
    $query1->execute();
    $result1 = $query1->get_result();
    $row1 = mysqli_fetch_array($result1);

    $sch = str_replace(array('[',']',"\"") ,'', $row1['schedules']);

    $query5 = $conn->prepare("SELECT * FROM schedules WHERE schedule_id IN ($sch)");
    $query5->execute();
    
    $result5 = $query5->get_result();

    $query2 = $conn->prepare("SELECT *
                                FROM 
                                    class_list
                                    INNER JOIN tblstudentinfo 
                                        ON (class_list.student_id = tblstudentinfo.id)
                                        WHERE class_id = ? ORDER BY fname ASC");
    $query2->bind_param('i', $class_id);
    $query2->execute();
    $result2 = $query2->get_result();

    if(!empty($date_from) && !empty($date_to)) {
        $query3 = $conn->prepare("SELECT *
                                FROM 
                                    tblattendance
                                        WHERE fk_subject_id = ? AND
                                        logdate BETWEEN ? AND ?
                                        GROUP BY logdate");
        $query3->bind_param('iss', $class_id, $date_from, $date_to);
    } else {
        $query3 = $conn->prepare("SELECT *
                                FROM 
                                    tblattendance
                                        WHERE fk_subject_id = ?
                                        GROUP BY logdate");
        $query3->bind_param('i', $class_id);
    }
    
    $query3->execute();
    $result3 = $query3->get_result();
}

if(isset($_POST['faculty_id'])) {
    $faculty_id = $_POST['faculty_id'];
    $semester_id = $_POST['semester_id'];
    $query  = $conn->prepare("SELECT classes.*, tblsubject.*
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
                                WHERE classes.instructor_id = ? AND classes.semester_id = ?");
    $query->bind_param('ii', $faculty_id, $semester_id);
    $query->execute();

    $result = $query->get_result();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Attendance Report</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>
<style>
#dt_filter input {
    padding: 5px;
    margin: 0 0 0 15px;
    border-radius: 10px;
}
</style>

<body>
    <div class="container-fluid">
        <div class="row" style="background:#0A2558; color:#FFF">
            <div class="p-3">
                <a href="dashboard.php" class="text-white p-0">
                    <i class="fa fa-caret-left"></i> <i class="fa fa-home"></i>
                    GO BACK
                </a>
            </div>
            <div class="col-sm-12 small py-2">
                <form action="" method="POST" id="form">
                    <b>
                        SEMESTER:
                    </b>
                    <?=$semester?>
                    <b>
                        FACULTY :
                        <select name="faculty_id" id="faculty_id" class="p-2" style="width:100px;">
                            <option value="">SELECT</option>
                            <?php foreach($res as $faculty):?>
                            <option value="<?=$faculty['id']?>">
                                <?=strtoupper($faculty['lname'].', '.$faculty['fname'])?></option>
                            <?php endforeach;?>
                        </select>
                    </b>
                    SUBJECT :
                    <select name="class_id" id="class_id" class="p-2" style="width:100px;">
                        <option value="">SELECT</option>
                        <?php foreach($result as $row):?>
                        <?php
                            $schedule = str_replace(array('[',']',"\"") ,'', $row['schedules']);

                            $query3 = $conn->prepare("SELECT * FROM schedules WHERE schedule_id IN ($schedule)");
                            $query3->execute();
                            
                            $results = $query3->get_result();
                        ?>
                        <option value="<?=$row['class_id']?>">
                            <?=strtoupper($row['subject_code'])?> - <?=strtoupper($row['subject_description'])?>
                            <br />
                            (<?php foreach($results as $rows):?>
                            <?=$rows['day_of_the_week']?> (<?=date('h:i a' , strtotime($rows['start_time']))?> to
                            <?=date('h:i a' , strtotime($rows['end_time']))?>)
                            <?php endforeach;?>)
                        </option>
                        <?php endforeach;?>
                    </select>
                    <b>
                        FROM :
                        <input type="date" name="date_from" id="date_from" class="w-25 p-2">
                    </b>
                    <b>
                        TO :
                        <input type="date" name="date_to" id="date_to" class="w-25 p-2">
                    </b>
                    <button type="submit" class="btn bg-info">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 p-3 px-5">
            <?php if(isset($_POST['class_id']) && !empty($_POST['class_id'])):?>
            <center>
                <h5>
                    <b>
                        <?=strtoupper($row1['subject_code'])?> - <?=strtoupper($row1['subject_description'])?>
                    </b>
                </h5>

                <ul class="list-unstyled">
                    <?php foreach($result5 as $row5):?>
                    <li><?=$row5['day_of_the_week']?>s (<?=date('h:i a' , strtotime($row5['start_time']))?> to
                        <?=date('h:i a' , strtotime($row5['end_time']))?>) | <?=strtoupper($row5['room_details'])?></li>
                    <?php endforeach;?>
                </ul>
                <?php if(!empty($date_from) && !empty($date_to)):?>
                Attendance from <b><?=date('F j, Y' , strtotime($date_from))?></b> to
                <b><?=date('F j, Y' , strtotime($date_to))?></b>
                <?php endif;?>
            </center>

            <?php if(mysqli_num_rows($result2) > 0):?>
            <button type="button" class="btn btn-info pull-right" onclick="printDiv()">
                <i class="fa fa-print"></i>
            </button>
            <div id="printArea">
                <table class="table-bordered small my-4" id="dt">
                    <thead>
                        <tr>
                            <th style="width:100px;">
                                <center>ID #</center>
                            </th>
                            <th style="width:400px;">
                                <center>NAME</center>
                            </th>
                            <?php foreach($result3 as $row3):?>
                            <th class="p-0" style="width:100px;">
                                <center>
                                    <?=date('M j, Y', strtotime($row3['logdate']))?>
                                </center>
                            </th>
                            <?php endforeach;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($result2 as $row2):?>
                        <tr>
                            <td class="px-3"><?=$row2['stud_id']?></td>
                            <td class="px-3"><?=strtoupper($row2['lname'].', '.$row2['fname'].' '.$row2['mname'])?></td>
                            <?php foreach($result3 as $row3):
                                $query_3 = $conn->prepare("SELECT *
                                                        FROM 
                                                            tblattendance
                                                                WHERE fk_subject_id = ? AND fk_student_id = ? AND logdate = ?");
                                $query_3->bind_param('iis', $class_id, $row2['id'], $row3['logdate']);
                                $query_3->execute();

                                $result_3 = $query_3->get_result();
                                ?>
                                <td>
                                <center>
                                    <?php if(mysqli_num_rows($result_3) > 0):
                                    $row4 = mysqli_fetch_array($result_3);?>
                                    <?php if($row4['is_late']):?>
                                    <span class="text-warning">
                                        Late
                                    </span>
                                    <?php else:?>
                                    <span class="text-success">
                                        Present
                                    </span>
                                    <?php endif;?>
                                    <?php else:?>
                                    <span class="text-danger">
                                        Absent
                                    </span>
                                    <?php endif;?>
                                </center>
                                </td>
                            <?php endforeach;?>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="row justify-content-center">
                <div class="col-sm-6 alert alert-warning">
                    <center>
                        No record found.
                    </center>
                </div>
            </div>
            <?php endif;?>
            <?php else: ?>
            <div class="row justify-content-center">
                <div class="col-sm-6 alert alert-warning">
                    <center>
                        <h5>Attendance Report</h5>
                        Select class from dropdown.
                    </center>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
    <?php if(isset($_POST['class_id'])):?>
    <script>
    $('#faculty_id').val(<?=$_POST['faculty_id']?>);
    $('#semester_id').val(<?=$_POST['semester_id']?>);
    $('#class_id').val(<?=$_POST['class_id']?>);
    $('#date_from').val("<?=$_POST['date_from']?>");
    $('#date_to').val("<?=$_POST['date_to']?>");
    </script>
    <?php endif;?>
    <script>
    function printDiv() {
        var div = document.getElementById('printArea');
        var print = window.open('', 'Print Window');
        var img =
            '<center><img src="css/logo.png" alt="LOGO" height="130" class="m-0" style="margin-bottom:-50px !important;"></center><br />';
        var title = 'Isabela State University';
        var body = '';
        var prepared_by =
            'Prepared by: <br /><br /><b><?=strtoupper($_SESSION['USER_NAME'])?></b> <br /><?=date('F j, Y h:i a')?>';
        print.document.open();
        print.document.write(
            '<html><head><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"></head><style>.main{font-size:10px !important;}table{font-size:11px !important;}p{line-height:1.2 !important;padding:0;margin:0;}.uppercase{text-transform:uppercase !important;}.dataTables_info,.dataTables_length,.dataTables_filter,.dataTables_paginate{display:none !important;}</style><body onload="window.print()" class="p-5">' +
            img + '<br /><center><h4><b>' + title + '</b> <br /> San Fabian, Echague, Isabela</center> ' + body +
            '<br /><br /><main>' + div.innerHTML + '<br /><br /><br />' + prepared_by + '</main></body></html>');
        print.document.close();
    }
    $(function() {
        $('#dt').DataTable({
            ordering: false,
            paging: false
        });

        $('#faculty_id').on('change', function() {
            $('#form').trigger('submit');
        });

        $('#semester_id').removeClass('w-100').addClass('p-2');
        $('#semester_id').css('width', '100px');

        $('#semester_id').on('change', function() {
            $('#form').trigger('submit');
        });
    });
    </script>
</body>

</html>