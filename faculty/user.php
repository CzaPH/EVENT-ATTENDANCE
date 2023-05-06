<?php
@require("../config/config.php");
@include "../shared_faculty/nav-items.php";
session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:../index.php');
    exit;
}

$query  = $conn->prepare("SELECT * FROM tblinstructor WHERE id = ?");
$query->bind_param('i', $_SESSION['user_id']);
$query->execute();

$result = $query->get_result();
$row = mysqli_fetch_array($result);
$id = $_SESSION['user_id'];

    if(isset($_POST['save'])) {
        $old_password = filter($_POST['old_password']);
        $new_password = filter($_POST['new_password']);
        $confirm_password = filter($_POST['confirm_password']);

        $employee_number = filter($_POST['employee_number']);
        $fname = filter($_POST['fname']);
        $mname = filter($_POST['mname']);
        $lname = filter($_POST['lname']);

        if(md5($old_password) !== $row['password']) {
            ?>
<script>
alert("Old password is incorrect!");
</script>
<?php
        } else if($new_password !== $confirm_password) {
            ?>
<script>
alert("New passwords does not match!");
</script>
<?php
        } else {
            $hashed = md5($confirm_password);
            $update = $conn->prepare("UPDATE tblinstructor SET `password` = ? WHERE id = ?");
            $update->bind_param('si', $hashed,$id);
            if($update->execute()) {
                ?>
<script>
alert("Account has been updated!");
location.href = 'user.php';
</script>
<?php
            } else {
                ?>
<script>
alert("Server error. Reload page.");
</script>
<?php
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Account Settings</title>
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
            <span class="logo_name"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </div>
        <ul class="nav-links">
            <li>
                <?php if($_SESSION['user_type'] == 'Faculty'):?>
                <a href="faculty_page.php">
                    <?php else:?>
                    <a href="../user.php">
                        <?php endif;?>
                        <i class='bx bx-arrow-back'></i>
                        <span class="links_name">Back</span>
                    </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <!-- <div class="header">
      <h5>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNLOGY</h5>
    </div> -->
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard"></span>Account Information
            </div>
        </nav>

        <div class="home-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-sm-6 border rounded shadow bg-white p-3">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label>Employee ID #:</label>
                                <input type="text" name="employee_number" required value="<?=$row['employee_number']?>"
                                    placeholder="Enter Employee ID Number" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>First Name:</label>
                                <input type="text" name="fname" required value="<?=$row['fname']?>"
                                    placeholder="Enter  First name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Middle Name:</label>
                                <input type="text" name="mname" required value="<?=$row['mname']?>"
                                    placeholder="Enter  Middle name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Last Name:</label>
                                <input type="text" name="lname" required value="<?=$row['lname']?>"
                                    placeholder="Enter Last name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Old Password:</label>
                                <input type="password" name="old_password" required placeholder="Old Password"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>New Password:</label>
                                <input type="password" name="new_password" required placeholder="New Password"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password:</label>
                                <input type="password" name="confirm_password" required placeholder="Confirm Password"
                                    class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="save" class="btn btn-primary button-loading"
                                    data-loading-text="Loading...">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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