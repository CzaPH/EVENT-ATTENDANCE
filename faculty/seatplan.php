<?php
@require("../config/config.php");
@include "../shared_faculty/nav-items.php";

date_default_timezone_set("Asia/Manila");

session_start();
$_SESSION["user_id"];

$today = date("Y-m-d");

if(isset($_GET['id'])) {
    $class_id = $_GET['id'];
    $query     = $conn->prepare("SELECT *
                                FROM
                                    class_list
                                    INNER JOIN classes 
                                        ON (class_list.class_id = classes.class_id)
                                    INNER JOIN tblstudentinfo 
                                        ON (class_list.student_id = tblstudentinfo.id)
                                        WHERE tblstudentinfo.is_deleted = false AND classes.class_id = ?");
    $query->bind_param('i', $class_id);
    $query->execute();
    $result     = $query->get_result();

    $querys2     = $conn->prepare("SELECT *
                                    FROM
                                        classes
                                        INNER JOIN tblsubject 
                                            ON (classes.subject_id = tblsubject.id)
                                            WHERE classes.class_id = ?");
    $querys2->bind_param('i', $class_id);
    $querys2->execute();
    $results2 = $querys2->get_result();
    $rows2 = mysqli_fetch_array($results2);
} else {
    header('Location:subjects.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Seat Plan</title>
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
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <span class="logo_name"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Faculty</span>
        </div>
        <?php navItems("Seat Plan") ?>
    </div>
    <section class="home-section">
        <!-- <div class="header">
      <h5>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNLOGY</h5>
    </div> -->
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard"></span><?php echo $_SESSION['USER_NAME'] ?>
            </div>
            <!-- <div class="search-box pt-1 m-0">
                
            </div> -->
        </nav>
        <!-- END OF THE SIDE BAR -->
        <div class="home-content">
            <center>
                <h5 class="bg-white mx-3 p-3 border rounded shadow">
                    <b><?=strtoupper($rows2['subject_code'])?> - <?=strtoupper($rows2['subject_description'])?></b>
                </h5>
            </center>
            <!-- Content Row -->
            <!-- Begin Page Content -->
            <div class="container-fluid">
            <center>
                <p>
                    <button type="button" class="btn btn-primary assign-automatically" 
                        data-class_id="<?=$class_id?>"
                        data-order_by="DESC">
                        Assign seats in Descending Order
                    </button>
                    <button type="button" class="btn btn-primary assign-automatically" 
                        data-class_id="<?=$class_id?>"
                        data-order_by="ASC">
                        Assign seats in Ascending Order
                    </button>
                </p>
            </center>
                <!-- Page Heading -->
                <div class="row justify-content-center">
                    <?php if(mysqli_num_rows($result) > 0):?>
                    <?php foreach($result as $key => $row):?>
                    <?php
                            $seat_number = $key + 1;
                            $query = $conn->prepare("SELECT tblseatplan.id AS pk, tblstudentinfo.* FROM tblseatplan 
                                                    INNER JOIN tblstudentinfo ON 
                                                    (tblstudentinfo.id = tblseatplan.fk_student_id)
                                                    WHERE seat_number = ? AND fk_subject_id = ?");
                            $query->bind_param('ii', $seat_number, $class_id);
                            $query->execute();
                            $result2 = $query->get_result();
                                
                        ?>
                    <div class="col-xl-2 col-md-6 mb-4 px-0 mx-1">
                        <div class="card border-left-primary shadow h-100">
                            <div class="card-header p-0 py-2">
                                <center><b>Seat # <?=$key + 1?></b></center>
                            </div>
                            <div class="card-body assign" style="cursor:pointer;" data-toggle="modal"
                                data-target="#modal" data-seat_number="<?=$key + 1?>">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            <?php if(mysqli_num_rows($result2) > 0):?>
                                            <?php
                                            $row2   = mysqli_fetch_array($result2);
                                            //$today = '2023-01-07';
                                            $querys = $conn->prepare("SELECT *
                                                                        FROM
                                                                            tblattendance
                                                                                WHERE fk_student_id = ? AND logdate = ?
                                                                                AND fk_subject_id = ?");
                                            $querys->bind_param('isi', $row2['id'], $today, $class_id);
                                            $querys->execute();
                                            $results = $querys->get_result();
                                            $class = "";
                                            if(mysqli_num_rows($results) > 0) {
                                                $rows = mysqli_fetch_array($results);
                                                if($rows['is_late']) {
                                                    $class .= 'text-warning';
                                                } else {
                                                    $class .= 'text-success';
                                                }
                                            } else {
                                                $class .= 'text-danger';
                                            }
                                        ?>
                                            <center>
                                                <section class="<?=$class?>">
                                                    <p>
                                                    <h5>(<?=$row2['stud_id']?>)</h5>
                                                    <small>
                                                        <?=strtoupper($row2['lname'].', '.$row2['fname'].' '.$row2['mname'])?>
                                                    </small>
                                                    </p>
                                                </section>
                                            </center>
                                            <?php else:?>
                                        </div>
                                        <div class="row no-gutters align-items-center justify-content-center">
                                            <div class="col-auto">
                                                <div class="h1 m-0 font-weight-bold text-gray-800">
                                                    <i class='bx bxs-user-plus align-items-center'></i>
                                                </div>
                                            </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(mysqli_num_rows($result2) > 0):?>
                            <div class="card-footer">
                                <?php if(mysqli_num_rows($results) > 0 && $rows['is_late']):?>
                                <p class="m-0 p-0">
                                    <a href="#"
                                        class="text-white update-status small border px-2 bg-primary rounded rounded-5"
                                        data-student_id="<?=$row2['id']?>" data-class_id="<?=$class_id?>">
                                        Change Status
                                    </a>
                                </p>
                                <?php else:?>
                                <p class="py-1"></p>
                                <?php endif;?>
                                <p class="m-0 p-0">
                                    <a href="#" class="text-white vacate small border px-2 bg-danger rounded rounded-5"
                                        data-seat_id="<?=$row2['pk']?>">
                                        Vacate
                                    </a>
                                </p>
                            </div>
                            <?php else:?>
                            <div class="card-footer">
                                <p class="text-center m-0 p-0">
                                    Vacant. Click <i class='bx bxs-user-plus align-items-center'></i> to assign
                                </p>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                    <?php endforeach;?>
                    <?php else:?>

                    <?php endif;?>
                </div>
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Assign Seat</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="seat_number" name="seat_number" readonly>
                                <div id="student-container"></div>
                            </div>
                        </div>
                    </div>
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

                $(function() {
                    $('.assign').on('click', function() {
                        var seat_number = $(this).data('seat_number');
                        var class_id = '<?=$class_id?>';
                        $('#seat_number').val(seat_number);
                        $.ajax({
                            url: 'seatplan_actions.php',
                            method: 'POST',
                            data: {
                                class_id: class_id
                            },
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                $('#student-container').html(response);
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });
                    });

                    $(document).on('click', '.assign-student', function() {
                        var student_id = $(this).data('student_id');
                        var class_id = '<?=$class_id?>';
                        var seat_number = $('#seat_number').val();

                        $.ajax({
                            url: 'seatplan_actions.php',
                            method: 'POST',
                            data: {
                                student_id: student_id,
                                class_id: class_id,
                                seat_number: seat_number
                            },
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                if (response == 'success') {
                                    location.reload();
                                } else {
                                    Swal.fire('ERROR!', response, 'error');
                                }
                            }
                        });
                    });

                    $(document).on('click', '.vacate', function() {
                        var seat_id = $(this).data('seat_id');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Once submitted, this cannot be undone. Proceed anyway?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, proceed.'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: 'seatplan_actions.php',
                                    method: 'POST',
                                    data: {
                                        seat_id: seat_id
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        console.log(response);
                                        if (response == 'success') {
                                            location.reload();
                                        } else {
                                            Swal.fire('ERROR!', response, 'error');
                                        }
                                    }
                                });
                            }
                        });

                    });

                    $(document).on('click', '.update-status', function() {
                        var student_id = $(this).data('student_id');
                        var class_id = $(this).data('class_id');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Once submitted, this cannot be undone. Proceed anyway?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, proceed.'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: 'seatplan_actions.php',
                                    method: 'POST',
                                    data: {
                                        student_id: student_id,
                                        class_id: class_id,
                                        update_status: 'true'
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        console.log(response);
                                        if (response == 'success') {
                                            location.reload();
                                        } else {
                                            Swal.fire('ERROR!', response, 'error');
                                        }
                                    }
                                });
                            }
                        });

                    });

                    $(document).on('click', '.assign-automatically', function() {
                        var class_id = $(this).data('class_id');
                        var order_by = $(this).data('order_by');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This will delete previously assigned seats then will assign seats in alphabetical order based from student's last name.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, proceed.'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: 'seatplan_actions.php',
                                    method: 'POST',
                                    data: {
                                        class_id: class_id,
                                        order_by:order_by,
                                        assign_automatically: 'true'
                                    },
                                    dataType: 'json',
                                    beforeSend: function() {
                                        $('.container-fluid').html(
                                            '<center>Processing, please wait... The page will reload automatically.</center>'
                                            );
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        if (response == 'success') {
                                            location.reload();
                                        } else {
                                            Swal.fire('ERROR!', response, 'error');
                                        }
                                    }
                                });
                            }
                        });

                    });
                });
                </script>
</body>

</html>