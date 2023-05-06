<?php

@include 'config/config.php';

if (isset($_POST['submit'])) {

   $fname = mysqli_real_escape_string($conn, $_POST['Fname']);
   $mname = mysqli_real_escape_string($conn, $_POST['Mname']);
   $lname = mysqli_real_escape_string($conn, $_POST['Lname']);
   $employee_number = mysqli_real_escape_string($conn, $_POST['userId']);
   $password = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $usertype = $_POST['user_type'];

  $select = " SELECT * FROM tblinstructor WHERE employee_number = '$employee_number' ";

   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {

      $error[] = 'Employee Number is Aleady Exist!';
   } else {

      if ($password != $cpass) {
         $error[] = 'password not matched!';
      } else {
         $insert = "INSERT INTO tblinstructor(employee_number, fname, mname, lname, password, user_type) VALUES('$employee_number','$fname', '$mname', '$lname','$password','$usertype')";
         mysqli_query($conn, $insert);
         header('location:index.php');
      }
   }
};


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login.css">

</head>

<body>

   <div class="form-container">

      <form action="" method="post">
         <h3>register now</h3>
         <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            };
         };
         ?>
         <input type="text" name="Fname" required placeholder="Enter First Name">
         <input type="text" name="Mname" required placeholder="Enter Middle Name">
         <input type="text" name="Lname" required placeholder="Enter Last Name">
         <input type="number" name="userId" required placeholder="Employee ID or Student ID">
         <input type="password" name="password" required placeholder="Password">
         <input type="password" name="cpassword" required placeholder="Confirm Password">
         <select name="user_type" required>
            <option value="">Select User Type</option>
            <option value="Admin">Admin</option>
            <option value="Faculty">Faculty</option>
         </select>
         <input type="submit" name="submit" value="register now" class="form-btn">
         <p>already have an account? <a href="user-login.php">login now</a></p>
      </form>

   </div>

</body>

</html>