<?php

    include('config.php');

    if (isset($_POST['registered'])) {
      // receive all input values from the form
      $username = $_POST['user'];
      $email =  $_POST['email'];
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];

      $user_check_query = "SELECT * FROM user WHERE (type='1') AND (username='$username' OR email='$email') LIMIT 1";
      $result = mysqli_query($db, $user_check_query);
      $user = mysqli_fetch_assoc($result);
      if($user)
       {
         if ($user['username'] === $username)
          {
            //$uexist = "Username already exists";
            /*<script>
            window.alert("username already exist");
            </script>*/
            echo("username already exists");
            header('Refresh: 2; register.php');
            die();
          }

          if ($user['email'] === $email)
           {
             /*<script>
             window.alert("email already exist");
             </script>*/
             echo("email already exists");
             header('Refresh: 2; register.php');
             die();
           }

       }

       $password = md5($password);//encrypt the password before saving in the database
  	   $query = "INSERT INTO user (username, email, type, password)
  			         VALUES('$username', '$email', '1', '$password')";
  	   mysqli_query($db, $query);
       $uid = mysqli_insert_id($db);
  	   $_SESSION['email'] = $email;
       $_SESSION['username'] = $username;
       $_SESSION['uid'] = $uid;
       /*<script>
       window.alert(" sucessfully registered");
       </script>*/
       echo("registered successfuly");
       //die();
       header('Refresh: 2; login.php');

    }




 ?>
