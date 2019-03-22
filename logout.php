<?php
   //session_start();
   include('config.php');
   unset($_SESSION['email']);
    unset($_SESSION['username']);
     unset($_SESSION['uid']);
   session_destroy();
   session_write_close();

   echo 'You have cleaned session';
   header('Refresh: 2; URL = login.php');
   exit;
?>
