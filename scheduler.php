<?php

include('config/config.php');

if (isset($_POST['delete'])) {
    $schedule_id     = filter($_POST['schedule_id']);

    $delete = $conn->prepare("DELETE FROM schedules WHERE schedule_id = ?");
    $delete->bind_param("i", $schedule_id);
    $delete->execute();

    exit(json_encode('success'));
}

if(isset($_POST['save'])) {
    $subject_id     = filter($_GET['id']);
    $day_of_the_week = filter($_POST['day_of_the_week']);
    $start_time = filter($_POST['start_time']);
    $end_time = filter($_POST['end_time']);
    $room_details = filter($_POST['room_details']);
    $semester_id = filter($_POST['semester_id']);

    $schedule_id = filter($_POST['schedule_id']);

    if(strtotime($end_time) < strtotime($start_time)) {
        echo '<script>alert("Invalid time range."); location.href="scheduler.php?id='.$subject_id.'";</script>';
        exit;
    }

    $select = $conn->prepare("SELECT * FROM schedules 
                                    WHERE subject_id = ? 
                                    AND day_of_the_week = ? 
                                    AND start_time = ? 
                                    AND end_time = ?
                                    AND semester_id = ?");
    $select->bind_param('isssi',$subject_id,$day_of_the_week,$start_time,$end_time,$semester_id);
    $select->execute();
    $r_select = $select->get_result();
    if(mysqli_num_rows($r_select) > 0) {
        echo '<script>alert("Submitted record already exists"); location.href="scheduler.php?id='.$subject_id.'";</script>';
        exit;
    }

    if(!empty($schedule_id)) {
        $save = $conn->prepare("UPDATE schedules SET 
                                    subject_id = ?,
                                    day_of_the_week = ?,
                                    start_time = ?,
                                    end_time = ?,
                                    room_details = ?,
                                    semester_id = ? WHERE schedule_id = ?");
                $save->bind_param('issssii', $subject_id, $day_of_the_week, $start_time, $end_time, $room_details, $semester_id, $schedule_id);
    } else {
        $save = $conn->prepare("INSERT INTO schedules(subject_id, day_of_the_week, start_time, end_time, room_details, semester_id)
                            VALUES(?,?,?,?,?,?)");
        $save->bind_param('issssi', $subject_id, $day_of_the_week, $start_time, $end_time, $room_details, $semester_id);
    }
    
    $save->execute();

    header('Location: scheduler.php?id='.$subject_id);
}


if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM tblsubject WHERE id = ? AND is_deleted = false");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if(mysqli_num_rows($result) < 1) {
        header("Location: subject.php");
        exit;
    }
    
} else {
    header("Location: subject.php");
    exit;
}

$data = mysqli_fetch_array($result);

if(isset($_POST['semester_id'])){
    $semester_id = filter($_POST['semester_id']);
    $query  = $conn->prepare("SELECT * FROM schedules INNER JOIN tblsemester 
                                ON (schedules.semester_id = tblsemester.id) WHERE subject_id = ?
                                AND schedules.semester_id = ?
                                ORDER BY schedules.schedule_id DESC");
    $query->bind_param('is',$id, $semester_id);
} else {
    $query  = $conn->prepare("SELECT * FROM schedules INNER JOIN tblsemester 
                                ON (schedules.semester_id = tblsemester.id) WHERE subject_id = ?
                                ORDER BY schedules.schedule_id DESC");
    $query->bind_param('i', $id);
}

$query->execute();
$r = $query->get_result();

$semester  = $conn->prepare("SELECT * FROM tblsemester /* WHERE is_active = true */");
$semester->execute();
$r_semester = $semester->get_result();

include('header.php');
?>
<div class="container-fluid p-0">
<div class="sidebar">
    <div class="logo-details">
      <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
    </div>
    <?php navItems("Scheduler") ?>
  </div>
  <section class="home-section">
    <div class="header">
      <h5>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNLOGY</h5>
    </div>
    <nav>
        <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">Scheduler </span>
        </div>

        <div class="search-box" style="padding-top:0 !important;">
            <form action="" method="POST" id="search">
                <?php if(mysqli_num_rows($r_semester) > 0):?>
                    <select name="semester_id" id="sem_id" class="form-control mt-0" style="height:50px !important;">
                        <?php foreach($r_semester as $r1):?>
                            <option value="<?=$r1['id']?>"><?=$r1['semester_code']?> - <?=$r1['semester_year']?></option>
                        <?php endforeach;?>
                    </select>
                <?php else:?>
                    <input type="text" placeholder="Search..." />
                <?php endif;?>
                <small><button type="submit" name="search" class="btn"><i class="bx bx-search"></i></button></small>
            </form>
        </div>
    </nav>

<div class="home-content">
</div>
    <section class="attendance">
      <div class="attendance-list">
        <div class="container">
            <h6 class="mt-3 p-2">Subject : <b><?=$data['subject_code']?> - <?=strtoupper($data['subject_description'])?></b></h6>
        </div>
        <a href="subject_add_record.php" class="btn" data-toggle="modal" data-target="#modal" onclick="$('#form')[0].reset()"> Add New Schedule</a>
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Day</th>
              <th>Time</th>
              <th>Room</th>
              <th>Semester</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(mysqli_num_rows($r) > 0):?>
                <?php foreach($r as $key => $r2):?>
                    <tr>
                        <td> <?=$key + 1?></td>
                        <td><?=$r2['day_of_the_week']?></td>
                        <td style="text-transform:none;"><?=date('h:i a', strtotime($r2['start_time']))?> to <?=date('h:i a', strtotime($r2['end_time']))?></td>
                        <td><?=$r2['room_details']?></td>
                        <td><?=$r2['semester_code']?> - <?=$r2['semester_year']?></td>
                        <td>
                            <a href="#" class="edit" data-toggle="modal" data-target="#modal"
                             data-schedule_id="<?=$r2['schedule_id']?>"
                             data-day_of_the_week="<?=$r2['day_of_the_week']?>"
                             data-start_time="<?=$r2['start_time']?>"
                             data-end_time="<?=$r2['end_time']?>"
                             data-room_details="<?=$r2['room_details']?>"
                             data-semester_id="<?=$r2['semester_id']?>">
                                <i class="far fa-edit text-info h4"></i>
                            </a>
                            <a href="#" class="delete"
                             data-schedule_id="<?=$r2['schedule_id']?>"
                             data-id="<?=$id?>">
                                <i class="far fa-trash-alt text-danger h4"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr>
                    <td colspan="7">
                        <center>No record found.</center>
                    </td>
                </tr>
            <?php endif;?>
          </tbody>
        </table>
      </div>
    </section>
</section>
</div>
<!--- MODAL -->

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal"><b><?=$data['subject_code']?> - <?=strtoupper($data['subject_description'])?></b></h6></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#form')[0].reset()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST" id="form">
        <input type="hidden" name="schedule_id" id="schedule_id" readonly>
      <div class="modal-body">
        <div class="form-group p-4">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="day_of_the_week">Day </label>
                <div class="col-sm-9">
                    <select name="day_of_the_week" class="form-control" id="day_of_the_week" required>
                        <option value="">SELECT</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="start_time" class="col-sm-3 col-form-label">Start Time</label>
                <div class="col-sm-9">
                    <input type="time" id="start_time" class="form-control" name="start_time" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="end_time" class="col-sm-3 col-form-label">To</label>
                <div class="col-sm-9">
                    <input type="time" id="end_time" class="form-control" name="end_time" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="semester_id" class="col-sm-3 col-form-label">Semester</label>
                <div class="col-sm-9">
                    <select name="semester_id" id="semester_id" class="form-control" required>
                        <option value="">SELECT</option>
                        <?php if(mysqli_num_rows($r_semester) > 0):?>
                            <?php foreach($r_semester as $r1):?>
                                <option value="<?=$r1['id']?>"><?=$r1['semester_code']?> - <?=$r1['semester_year']?></option>
                            <?php endforeach;?>
                        <?php else:?>
                        <?php endif;?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="room_details" class="col-sm-3 col-form-label">Room Details</label>
                <div class="col-sm-9">
                    <input type="text" id="room_details" placeholder="Room (optional)" class="form-control" name="room_details">
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="$('#form')[0].reset()" data-dismiss="modal">Close</button>
        <button type="submit" name="save" class="btn btn-primary">
            Save 
        </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!--- MODAL -->
<?php if(isset($_POST['semester_id'])):?>
    <script>
        $('#sem_id').val(<?=$_POST['semester_id']?>);
    </script>
<?php endif;?>
<script>
    $(function(){

        $('#sem_id').on('change', function(){
            $('#search').trigger('submit');
        });

        $(document).on('click','.delete', function(){
            var schedule_id = $(this).data('schedule_id');
            var id = $(this).data('id');
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
                        url:'scheduler.php',
                        method:'POST',
                        data:{
                            schedule_id:schedule_id,
                            delete:`delete`
                        },
                        dataType:'json',
                        success:function(response){
                            if(response == 'success') {
                                Swal.fire('DELETED!','Record has been deleted', 'success');
                                setInterval(
                                    function () {
                                        location.href = 'scheduler.php?id='+id;
                                    },2000
                                );
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click','.edit', function(){
            var schedule_id = $(this).data('schedule_id');
            var semester_id = $(this).data('semester_id');
            var day_of_the_week = $(this).data('day_of_the_week');
            var start_time = $(this).data('start_time');
            var end_time = $(this).data('end_time');
            var room_details = $(this).data('room_details');

            $('#schedule_id').val(schedule_id);
            $('#semester_id').val(semester_id);
            $('#day_of_the_week').val(day_of_the_week);
            $('#start_time').val(start_time);
            $('#end_time').val(end_time);
            $('#room_details').val(room_details);
        });
    });
</script>
<?php include('footer.php');?>