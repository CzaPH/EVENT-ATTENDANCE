<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />





    <title>CCSICT Attendance System</title>
</head>
<nav class="navbar navbar-expand-lg" style="background-color: #461E7F">
    <a class="navbar-brand" href="#"><strong style="color: #fff"><i class='fa fa-user-clock'></i> Smart Student
            Attendance Monitoring System </strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- 
    <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
    <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="user-login.php" style="color: #fff"><b><i class="fa fa-user"></i> LOGIN
                </b></a>
        </li>

    </ul>

    </div>
</nav><br>


<body onload="startTime()"><br>


    <div class="container">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-8">

                <center>
                    <div id="clockdate" style="border: 1px solid coral;background-color: #461E7F">
                        <div class="clockdate-wrapper">
                            <div id="clock" style="font-weight: bold; color: #fff;font-size: 40px"></div>
                            <div id="date" style="color: #fff"><i class="fas fa-calendar"></i>
                                <?php echo date('l, F j, Y'); ?>
                            </div>
                        </div>
                    </div><br></br>
                </center>
                <h2><b>College of Computing Studies, Information and Communication Technology</b></h2><br></br><br>
                <h5><b>About:</b></h5>
                <p>This is Students' Class Attendance Monitoring System developed for the Isabela State University -
                    Echague Campus (SU-E), particularly
                    at the College of Computing Studies, Information and Communication Technology (CCSICT). <br></br>
                    This system aims to check and monitor students attendance using the quick
                    response tool or the QR code. <br></br>
                    In partial fulfillment of the requirement for the subject Capstone Project and research 2.

                </p>
                <img class="wave" src="img/ROADSHOWB4.png" alt="wave bg" style="position: fixed;
                                            bottom: 0;
                                            left: 0;
                                            height: 100%;
                                            z-index: -1;">
                <img src="img/ROADSHOWB1.png" alt="phone with qr code" style="position: fixed;
                                                        bottom: 0;
                                                        left: 0;
                                                        height: 100%;
                                                        z-index: -1;
                                                        width: 850px;">
            </div>

        </div>
    </div>


    <script src="javascript/script.js"></script>
</body>

</html>