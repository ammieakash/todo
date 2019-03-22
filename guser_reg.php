<?php
  include('config.php');

  $email = $_REQUEST['email'];
  $username = $_REQUEST['username'];
  if(!empty($email) && !empty($username))
  {

    $user_check_query = "SELECT * FROM user WHERE type ='2' AND email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    $uid1 = $user['uid'];
    if($user)
     {
        if ($user['email'] === $email)
         {
           /*<script>
           window.alert("email already exist");
           </script>*/


           echo("email already exists");
           $_SESSION['email'] = $email;
           $_SESSION['username'] = $username;
           $_SESSION['uid'] = $uid1;
           //header('Refresh: 2; index.php');
           die();
         }

     }
     else
     {
         $query = "INSERT INTO user (username, email,type)
                   VALUES('$username', '$email','2')";
          mysqli_query($db, $query);
          $uid = mysqli_insert_id($db);
          $_SESSION['email'] = $email;
          $_SESSION['username'] = $username;
          $_SESSION['uid'] = $uid;
          $res = "success";
          //echo $res;
      }

  }


 ?>
