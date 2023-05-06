<?php
include('config/config.php');
include('functions.php');

$active = semester(1, $conn);
$semester = semester(0, $conn);

session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:user-login.php');
    exit;
}

include('header.php');

if(isset($_POST['semester_id'])) {
    $semester_id = $_POST['semester_id'];
} else {
    $semester_id = $active['id'];
}
$stmt   = $conn->prepare("SELECT * FROM classes WHERE is_deleted = false AND is_archived = false AND semester_id = ?");
    $stmt->bind_param('i', $semester_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<style>
.btn {
    padding: 4px !important;
    font-size: 13px !important;
    height: 30px;
    background: #081D45 !important;
    text-transform: uppercase !important;
    font-weight: bold;
    color: #FFF;
}
</style>
<div class="container-fluid p-0">
    <div class="sidebar">
        <div class="logo-details">
            <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
        </div>
        <?php navItems("Class Management") ?>
    </div>
    <section class="home-section">
        <!-- <div class="header">
      <h3>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h3>
    </div> -->
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard">Class Management </span>
                <button type="button" class="btn instructor-modal d-none" data-toggle="modal" data-target="#modal">
                    Hidden Button
                </button>
                <!-- <input type="text" id="set-class-id" readonly/> -->
            </div>

            <form action="" id="form" method="POST">
                <div class="search-box">
                    <?=$semester?>
                    <i class="bx bx-search"></i>
                </div>
            </form>
        </nav>

        <div class="home-content mt-0 attendance">
            <div class="container attendance-list">
                <label for="semester_id">SEMESTER :</label>
                <?php 
            $query1 = $conn->prepare("SELECT * FROM tblsemester
                                     WHERE is_deleted = false AND is_active = true");
            $query1->execute();
            $result1 = $query1->get_result(); 
        ?>
                <select name="semester_id" id="sem_id">
                    <option value="" selected>SELECT</option>
                    <?php if(mysqli_num_rows($result1) > 0):?>
                    <?php foreach($result1 as $row1):?>
                    <option value="<?=$row1['id']?>"><?=$row1['semester_code']?> - <?=$row1['semester_year']?></option>
                    <?php endforeach;?>
                    <?php else:?>
                    <option value="" disabled>NO RECORD FOUND</option>
                    <?php endif;?>
                </select>

                <span id="subjects-container"></span>
                <input type="hidden" id="instructor_id" name="instructor_id" readonly>
                <section id="schedules-container"></section>
                <section>
                    <span id="instructor-container">

                    </span>
                </section>
            </div>
        </div>
        <section class="attendance">
            <div class="">
                <!-- <a href="subject_add_record.php" class="btn" data-toggle="modal" data-target="#modal"> Add New Schedule</a> -->
                <table class="table table-sm table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Semester</th>
                            <th>Subject</th>
                            <th>Schedule</th>
                            <th>Instructor</th>
                            <th>Course</th>
                            <th>Yr &amp; Section</th>
                            <th>Manage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($result) > 0):?>
                        <?php foreach($result as $key => $row):
                    $semester = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tblsemester WHERE id = '".$row['semester_id']."'"));
                    $subject = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tblsubject WHERE id = '".$row['subject_id']."'"));
                    $instructor_r = mysqli_query($conn, "SELECT * FROM tblinstructor WHERE id = '".$row['instructor_id']."'");
                    $instructor = mysqli_fetch_array($instructor_r);
                    $course_r = mysqli_query($conn, "SELECT * FROM tblcourse WHERE id = '".$row['course_id']."'");
                    $course = mysqli_fetch_array($course_r);
                ?>
                        <tr style="font-size:13px;">
                            <td><?=$key + 1?></td>
                            <td><?=$semester['semester_code']?> - <?=$semester['semester_year']?></td>
                            <td><?=$subject['subject_code']?> - <?=$subject['subject_description']?></td>
                            <td>
                                <ul class="small">
                                    <?php
                                $schedule = json_decode($row['schedules']);
                                
                                if($row['schedules'] !== 'null') {
                                    foreach($schedule as $sched){
                                        $sch = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM schedules WHERE schedule_id = '".$sched."'"));

                                        ?>
                                    <li style="text-transform:none;">
                                        <?=$sch['day_of_the_week'] ?? ''?> |
                                        <?= (isset($sch['start_time'])) ? $sch['start_time'].' to ' : '';?>
                                        <?= (isset($sch['end_time'])) ? $sch['end_time'].' to ' : '';?>
                                        |
                                        <?=strtoupper($sch['room_details'] ?? '')?>
                                    </li>
                                    <?php
                                    }
                                }
                            ?>
                                </ul>
                            </td>
                            <td>
                                <?php if(mysqli_num_rows($instructor_r) > 0):?>
                                <a role="button" href="#" class="edit-instructor" data-class_id="<?=$row['class_id']?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?=strtoupper($instructor['lname'].', '.$instructor['fname'].' '.$instructor['mname'])?>
                                <?php else:?>
                                No Instuctor
                                <?php endif;?>
                            </td>
                            <td>
                                <?php if(mysqli_num_rows($course_r) > 0):?>
                                <?=strtoupper($course['coursecode'].'- '.$course['coursedescription'])?>
                                <?php else:?>
                                No Course
                                <?php endif;?>
                            </td>
                            <td><?=$row['yr_and_section']?></td>
                            <td>
                                <a href="enroll_class_list.php?id=<?=$row['class_id']?>" class="btn" role="button">
                                    ClassList
                                </a>
                            </td>
                            <td>
                                <a href="#" class="delete" data-class_id="<?=$row['class_id']?>">
                                    <i class="far fa-trash-alt text-danger h4"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        <?php else:?>
                        <tr>
                            <td colspan="9">
                                <center>
                                    No record found.
                                </center>
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
                <h5 class="modal-title" id="modal"><b>
                        SELECT INSTRUCTOR
                    </b></h6>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php 
            $query2 = $conn->prepare("SELECT * FROM tblinstructor WHERE is_deleted = false AND user_type = 'Faculty'");
            $query2->execute();
            $result2 = $query2->get_result(); 
        ?>
                <?php if(mysqli_num_rows($result2) > 0):?>
                <table class="table table-sm table-condensed table-bordered table-hover" id="dt">
                    <thead class="d-none">
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($result2 as $row2):?>
                        <tr class="pointer instructor" data-instructor_id="<?=$row2['id']?>"
                            data-name="<?=strtoupper($row2['lname'].', '.$row2['fname'].' '.$row2['mname'])?>">
                            <td><?=strtoupper($row2['lname'].', '.$row2['fname'].' '.$row2['mname'])?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <?php else:?>
                <center>NO RECORD FOUND</center>
                <?php endif;?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--- MODAL -->
<?php if(isset($_POST['semester_id'])):?>
<script>
$('#semester_id').val(<?=$_POST['semester_id']?>);
</script>
<?php endif;?>
<script>
$(function() {
    $('#dt').DataTable({
        paging: false,
        ordering: false,
        info: false
    });

    $('#semester_id').addClass('form-control h-100');

    $('#semester_id').on('change', function() {
        $('#form').trigger('submit');
    });

    $(document).on('focus', '#sem_id', function() {
        $('#subjects-container').html('');
        $('#schedules-container').html('');
        $('#instructor').val('');
        $('#instructor_id').val('');
    });

    $(document).on('click', '#instructor', function() {
        $('#instructor').val('');
        $('#instructor_id').val('');
    });

    $(document).on('change', '#sem_id', function() {
        var semester_id = $(this).val();
        $.ajax({
            url: 'enrollment_actions.php',
            method: 'POST',
            data: {
                semester_id: semester_id
            },
            dataType: 'json',
            success: function(html) {
                $('#subjects-container').html(html);
            }
        });
    });

    $(document).on('change', '#subject_id', function() {
        var subject_id = $(this).val();
        var sem_id = $('#sem_id').val();
        $.ajax({
            url: 'enrollment_actions.php',
            method: 'POST',
            data: {
                subject_id: subject_id,
                sem_id: sem_id
            },
            dataType: 'json',
            success: function(html) {
                $('#schedules-container').html(html);
            }
        });
    });

    // $(document).on('change','#subject_id', function(){
    //     var subject_id = $(this).val();
    //     $.ajax({
    //         url:'enrollment_actions.php',
    //         method:'POST',
    //         data:{
    //             subject_id:subject_id
    //         },
    //         dataType:'json',
    //         success:function(html){
    //             $('#schedules-container').html(html);
    //         }
    //     });
    // });

    $(document).on('click', '.edit-instructor', function() {
        $('.instructor-modal').trigger('click');
        var class_id = $(this).data('class_id');
        $('#dt .pointer').removeClass('instructor').addClass('update-instructor');
        $('#set-class-id').val(class_id);
    });

    $(document).on('click', '.update-instructor', function() {
        var class_id = $('#set-class-id').val();
        var instructor_id = $(this).data('instructor_id');
        Swal.fire({
            title: 'Update instructor?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'enrollment_actions.php',
                    method: 'POST',
                    data: {
                        class_id: class_id,
                        instructor_id: instructor_id,
                        update_instructor: 'true',
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#modal .modal-body').html(
                            '<center>Processing, please wait...</center>');
                        $('#modal .modal-footer').addClass('d-none');
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == 'success') {
                            location.href = 'enroll.php';
                        }
                    }
                });
            }
        });
    });

    $(document).on('click', '.instructor', function() {
        var instructor_id = $(this).data('instructor_id');
        var name = $(this).data('name');
        $('#instructor').val(name);
        $('#instructor_id').val(instructor_id);
        $('.close').trigger('click');
    });

    $(document).on('click', '.save', function() {
        var schedules = [];
        $('input[name="schedules"]:checked').each(function() {
            schedules.push(this.value);
        });
        var semester_id = $('#sem_id').val();
        var subject_id = $('#subject_id').val();
        var instructor_id = $('#instructor_id').val();
        var course_id = $('#course_id').val();
        var yr_and_section = $('#yr_and_section').val();

        $.ajax({
            url: 'enrollment_actions.php',
            method: 'POST',
            data: {
                semester_id: semester_id,
                subject_id: subject_id,
                schedules: schedules,
                instructor_id: instructor_id,
                course_id: course_id,
                yr_and_section: yr_and_section,
                action: 'save',
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response == 'success') {
                    location.href = 'enroll.php';
                }
            }
        });
    });

    $(document).on('click', '.delete', function() {
        var class_id = $(this).data('class_id');
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
                    url: 'enrollment_actions.php',
                    method: 'POST',
                    data: {
                        class_id: class_id,
                        delete: `delete`
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response == 'success') {
                            location.href = 'enroll.php';
                        }
                    }
                });
            }
        });
    });
});
</script>
<?php include('footer.php');?>