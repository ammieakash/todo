<?php

include('config.php');

if (isset($_POST['login'])) {

     $email        = $_POST['email'];
     $password     = md5($_POST['pass']);
    $query        = "SELECT * FROM user WHERE email='$email' AND password='$password'";
     $result       = mysqli_query($db, $query);
     $data    = mysqli_fetch_assoc($result);
     $rows_Count = mysqli_num_rows($result);


    if ($rows_Count == 1) {
         //session_start();
         $username = $data['username'];
         $uid      = $data['uid'];
         $_SESSION['email'] = $email;
         $_SESSION['username'] = $username;
         $_SESSION['uid'] = $uid;

         header('location: index.php');
         exit;
    }else {

        $error = "credential didn't match";
       //echo("credential didn't match");
       //header('Refresh: 2; login.php');

    }
  }















 ?>
