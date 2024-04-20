<?php
    include('../config/config.php');

    if(isset($_POST['student_id'])) {
        print_r($_POST);
    }
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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


    <script>
    $(document).ready(function() {
        $('#dataTable_1').DataTable();
    });
    </script>

    <title>CCSICT Attendance System</title>
</head>
<nav class="navbar navbar-expand-lg" style="background-color: coral">
    <a class="navbar-brand" href="#"><strong style="color: #fff"><i class='fa fa-user-clock'></i> 13th ICT ROADSHOW
            ATTENDANCE SYSTEM</strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <!-- <a class="nav-link" href="user-login.php" style="color: #fff"><b><i class="fa fa-user"></i> LOGIN -->
                </b></a>
            </li>

        </ul>

    </div>
</nav><br>

<body onload="startTime()"><br>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <center>
                    <p style="border: 1px solid coral;background-color:coral;color: #fff"><i class="fas fa-qrcode"></i>
                        TAP HERE</p>
                </center>
                <video id="preview" width="100%"></video>
                <!-- Getting the process of attendance -->
                <?php
                include '../attendance/attendance_process.php'; ?>
                <hr>
                </hr>
            </div>
            <div class="col-md-8">
                <center>
                    <div id="clockdate" style="border: 1px solid coral;background-color: coral">
                        <div class="clockdate-wrapper">
                            <div id="clock" style="font-weight: bold; color: #fff;font-size: 40px"></div>
                            <div id="date" style="color: #fff"><i class="fas fa-calendar"></i>
                                <?php echo date('l, F j, Y'); ?></div>
                        </div>
                    </div>
                </center>
                <form action="" method="POST" class="form-harizontal">

                    <label><b>SCAN QR CODE</b></label>
                    <input type="text" name="student_id" id="student_id" readonly="" placeholder="Scan Qr Code"
                        class="form-control">
                </form>
                <hr>
                </hr>
                <div class="table-responsive">
                    <table id="dataTable_1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>STUDENT-ID NO.</th>
                                <th>TIME IN</th>
                                <th>LOGDATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--PHP CODE HERE -->
                            <?php
              if(isset($_POST['student_id'])){
                $emp = trim($_POST['student_id']);
             $sql = "SELECT A.fk_student_id, A.time_in, A.logdate, B.subject_code
                FROM tblattendance  AS A
                INNER JOIN tblsubject AS B ON A.fk_subject_id = B.id
                WHERE A.fk_student_id = '$emp'
                ORDER BY A.id DESC";

              $res = $conn->prepare($sql);
              $res->execute();

              $i = 1;
              if ($res->rowCount() > 0) {
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>
                
                <td>" . $row['fk_student_id'] . "</td>
                <td>" . $row['time_in'] . "</td>
                <td>" . $row['logdate'] . "</td>
                <td>" . $row['subject_code'] . "</td>"
              ?>

                            <?php
                }
              } else {
                echo "<tr> <td colspan = '9'> NO RECORDS FOUND</td> </tr>";
              }
              }

              ?>
                        </tbody>
                    </table>
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
        document.getElementById('student_id').value = c;
        //console.log(c);
        document.forms[0].submit();
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script src="javascript/script.js"></script>
</body>

</html>