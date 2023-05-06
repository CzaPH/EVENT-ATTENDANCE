<?php

session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:user-login.php');
    exit;
}

require("config/db_connect.php");
include "./shared/nav-items.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Manage Semester Information</title>
    <link rel="stylesheet" href="css/sidebar.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
        </div>
        <?php navItems("QR Generator") ?>
    </div>
    <section class="home-section">
    <div class="header">
      <h1>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNLOGY</h1>
    </div>
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard">QR Generator</span>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Search..." />
                <i class="bx bx-search"></i>
            </div>
        </nav>

        <div class="home-content">
            <div align="center" class="wrapper" id="box">
                <h3>QR Code Generator</h3>
                <div><input style="color: black;" id="qr-text" type="text" placeholder="Enter student ID" /></div>
                <br />
                <div>
                    <button class="qr-btn" onclick="generateQRCode()">Create QR Code</button>
                </div>
                <br />
                <p id="qrresult"></p>
                <canvas id="qrcode"></canvas>
                <br />
                <button class="qr-btn" onclick="downloadQR()">Download Qr Code</button>
            </div>

            <script>
                var qr;
                var qrresult;

                (function() {
                    qr = new QRious({
                        element: document.getElementById('qrcode'),
                        size: 300,
                        value: 'Smart Student Class Attendance Monitoring System'
                    });
                })();

                function generateQRCode() {
                    var qrtext = document.getElementById("qr-text").value;
                    document.getElementById("qrresult").innerHTML = "QR code for " + qrtext + ":";
                    qr.set({
                        foreground: 'black',
                        size: 300,
                        value: qrtext
                    });
                }

                function downloadQR(generateQRCode) {
                    var naming = document.getElementById('qr-text').value;
                    var link = document.createElement('a');
                    link.href = document.getElementById('qrcode').toDataURL()
                    //file naming here
                    link.download = naming;
                    document.body.appendChild(link)
                    link.click()
                    document.body.removeChild(link)
                }
            </script>

            <script>
                let sidebar = document.querySelector(".sidebar");
                let sidebarBtn = document.querySelector(".sidebarBtn");
                sidebarBtn.onclick = function() {
                    sidebar.classList.toggle("active");
                    if (sidebar.classList.contains("active")) {
                        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
                    } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
                };
            </script>
</body>

</html>