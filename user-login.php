<?php

include("config/config.php");

session_start();

if (isset($_POST['submit'])) {


   $employee_number = mysqli_real_escape_string($conn, $_POST['employee_number']);
   $password = md5($_POST['password']);

   $select = " SELECT * FROM tblinstructor WHERE employee_number = '$employee_number' && password = '$password' ";

   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {

      $row = mysqli_fetch_array($result);

      if ($row['user_type'] == 'Admin') {

         $_SESSION['user_id'] = $row['id'];
         $_SESSION['user_type'] = $row['user_type'];
         $_SESSION['USER_NAME'] = $row['lname'].", ".$row['fname'];
         $_SESSION['admin_name'] = $row['fname'];
         header('location:dashboard.php');
      } elseif ($row['user_type'] == 'Faculty') {

         $_SESSION['USER_NAME'] = $row['lname'].", ".$row['fname'];
         $_SESSION['user_type'] = $row['user_type'];
         $_SESSION['user_id'] = $row['id'];
         header('location:faculty/faculty_page.php');
      }
   } else {
      $error[] = 'incorrect email or password!';
   }
//    $sql = "UPDATE tblinstructor SET time_loged = now() WHERE employee_number = $employee_number";
//        $result = mysqli_query($conn, $sql);  
};
?>
<!-- <!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <-- custom css file link  -->
<!-- <link rel="stylesheet" href="css/index.css">

</head>

<body>
   <div class="bg-img">
      <form action="" method="post" class="container">
         <h1 style="text-align: center;">Login now</h1>
         
         <label for="email"><b>Employee ID:</b></label>
         <input type="number" required placeholder="Employee ID" name="employee_number">

         <label for="psw"><b>Password:</b></label>
         <input type="password" required placeholder="Password" name="password">

         <button type="submit" name="submit" value="login now" class="btn">Login</button>

         <p>don't have an account? <a href="register_form.php">register now</a></p>
      </form>
   </div>
</body> -->
<!-- 
</html> -->

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style-login.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <img class="wave" src="img/wave.png">
    <div class="container">
        <div class="img">
            <div class="text-1"><span class="typing"></span></div>
            <img src="img/bg.png">
        </div>

        <div class="login-content">
            <form action="" method="post">
                <!-- <form action="index.html"> -->
                <img src="img/avatar.jpg">
                <h2 class="title">Welcome</h2>
                <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            };
         };
         ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">

                        <input type="text" name="employee_number" class="input" placeholder="Employee ID No.">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <input type="password" id="txtPassword" name="password" class="input" placeholder="Password">
                        <!-- <button type="button" id="btnToggle" class="toggle">
                            <i id="eyeIcon" class="fa-solid fa-eye"></i></button> -->
                    </div>
                </div>
                <a href="register_form.php">register now</a>
                <input type="submit" class="btn" value="Login" name="submit">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>

</html>

<!-- <script>
let passwordInput = document.getElementById('txtPassword'),
    toggle = document.getElementById('btnToogle'),
    icon = document.getElementById('eyeIcon');

funtion togglePassword() {
    if (passwordInput.type == 'password') {
        passwordInput.type = 'text';
        icon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = 'password';
        icon.classList.remove("fa-eye-slash");
    }
}
funtion checkInput() {

}

toggle.addEventListener('click', togglePassword, false);
passwordInput.addEventListener('key', togglePassword, false);
</script> -->