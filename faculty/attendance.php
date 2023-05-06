<?php
    include('../config/config.php');

    session_start();
    $_SESSION['user_id'];

    date_default_timezone_set("Asia/Manila");
    if(isset($_GET['id']) && isset($_SESSION['user_id'])) {
        $class_id   = filter($_GET['id']);

        $query = $conn->prepare("SELECT *
                                    FROM
                                        classes
                                        INNER JOIN tblsubject 
                                            ON (classes.subject_id = tblsubject.id) 
                                            WHERE class_id = ? AND instructor_id = ?");
        $query->bind_param('ii', $class_id,$_SESSION['user_id']);
        $query->execute();
        $result = $query->get_result();

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $day = date('l');
            $schedule = str_replace(array('[',']',"\"") ,'', $row['schedules']);
            $time = date('H:i:s'); 

            $query3 = $conn->prepare("SELECT * FROM schedules WHERE day_of_the_week = ? AND end_time > ? AND schedule_id IN ($schedule)");
            $query3->bind_param('ss',$day, $time);
            $query3->execute();
            
            $result3 = $query3->get_result();

            if(mysqli_num_rows($result3) > 0) {
                $row3 = mysqli_fetch_array($result3);
            } else {
                ?>
<script>
alert("No scheduled class for today in this subject. You can't access attendance window.");
location.href = 'subjects.php';
</script>
<?php
                exit;
            }

        } else {
            header('Location: subjects.php');    
            exit;
        }
    } else {
        header('Location: subjects.php');
        exit;
    }
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
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

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>CCSICT Attendance System</title>
</head>

<body onload="startTime()">
    <nav class="navbar navbar-expand-lg mb-1" style="background-color: #461E7F">
        <a class="navbar-brand" href="subjects.php"><strong style="color: #fff"><i class='fa fa-user-clock'></i> Smart
                Student Class Attendance Monitoring System </strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <center>
                    <p style="border: 1px solid #461E7F;background-color:#461E7F;color: #fff"><i
                            class="fas fa-qrcode"></i>
                        TAP HERE</p>
                </center>
                <video id="preview" width="100%"></video>
                <section id="message"></section>
                <!-- Getting the process of attendance -->
                <hr>
                </hr>
            </div>
            <div class="col-md-8">
                <center>
                    <div id="clockdate" style="border: 1px solid #461E7F;background-color: #461E7F">
                        <div class="clockdate-wrapper">
                            <div id="clock" style="font-weight: bold; color: #fff;font-size: 40px"></div>
                            <div id="date" style="color: #fff"><i class="fas fa-calendar"></i>
                                <?php echo date('l, F j, Y'); ?></div>
                        </div>
                    </div>
                    <h5>
                        SUBJECT:
                        <b>
                            <?=strtoupper($row['subject_code'].' - '.$row['subject_description'])?>
                        </b>
                        <p>Schedule: <?=date('h:i a', strtotime($row3['start_time']))?> to
                            <?=date('h:i a', strtotime($row3['end_time']))?></p>
                    </h5>
                </center>
                <form action="" method="POST" class="form-harizontal">
                    <label><b>SCAN QR CODE</b></label>
                    <input type="hidden" name="schedule_id" id="schedule_id" value="<?=$row3['schedule_id']?>" readonly>
                    <input type="text" name="student_id" id="student_id" placeholder="Scan Qr Code"
                        class="form-control">
                    <button type="submit" id="submit" class="d-none">
                        SUBMIT
                    </button>
                </form>
                <hr>
                </hr>
                <div class="table-responsive">
                </div>
            </div>

        </div>
    </div>

    <script>
    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview')
    });
    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert('No cameras found');
        }

    }).catch(function(e) {
        console.error(e);
    });

    scanner.addListener('scan', function(c) {
        $('#message').html("");
        document.getElementById('student_id').value = c;
        $('.form-harizontal').trigger('submit');
        //document.forms[0].submit();
    });

    function load(class_id) {
        $.ajax({
            url: 'attendance_actions.php',
            method: 'POST',
            data: {
                action: 'load',
                class_id: class_id,
            },
            dataType: 'json',
            success: function(html) {
                $('#html').html(html);
            }
        });
    }
    $(function() {
        var class_id = <?=$class_id?>;

        //load(class_id);
        $('#student_id').trigger('focus');
        $('.form-harizontal').on('submit', function(e) {
            e.preventDefault();
            var student_id = $('#student_id').val();
            var schedule_id = $('#schedule_id').val();
            $.ajax({
                url: 'attendance_actions.php',
                method: 'POST',
                data: {
                    student_id: student_id,
                    class_id: class_id,
                    schedule_id: schedule_id,
                },
                dataType: 'json',
                success: function(response) {
                    $('.form-harizontal')[0].reset();
                    var html = "";
                    if (response.status == 'error') {
                        html += '<div class="alert alert-danger"><center>' + response
                            .message + '</center></div>';
                        $('#message').html(html);
                    } else {

                        html +=
                            '<div class="alert alert-success"><center>Saved!</center></div>';
                        $('#message').html(html);
                        //load(class_id);  

                        $('.table-responsive').html(response.html);
                        $('#student_id').trigger('focus');
                    }
                }
            });
        });
        $(document).on('click', '.alert', function() {
            $('.alert').hide();
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script src="../javascript/script.js"></script>
</body>

</html>