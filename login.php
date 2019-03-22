<?php

include('config.php');
if(isset($_SESSION['email']))
{//die();
  header('Location: index.php ');
  die();
}
include('login_server.php');

?>
<!DOCTYPE html>
<html>
<head>
   <title></title>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://apis.google.com/js/platform.js" async defer></script>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <meta name="google-signin-client_id" content="192196934733-rdjrin41bp61mnca10k218c42c10l9nv.apps.googleusercontent.com">
   <link rel = "stylesheet" type = "text/css" href = "css/style.css" />
   <script>
   function onSignIn(googleUser){

       var profile = googleUser.getBasicProfile();
       var email  = profile.U3;
       var username = profile.ofa;

       $.ajax({

             type : "POST",
             url  : "guser_reg.php",
             datatype:'JSON',
             data : { email: email, username : username},
             success : function(response){
                //alert(response);
                  window.location = "index.php";
               //window.location.href("index.php");
               //window.location.reload(false);


          }

     });

       //console.log(username);
       //console.log(profile);
//window.location.href("index.php");

   }
   </script>
   <!--<script src="script/script.js"></script>-->
</head>
<body>


    <div class="container">
      <h1 class="text-center text-success">User Login</h1><br>
      <div class="col-lg-8 m-auto d-block">
           <form action="login.php" method="post"  class="bg-light" id="form_id">


            <div class="form-group">

              <label>Email:</label>
              <input type="email" name="email" class="form-control" id="email" autocomplete="off"/>
              <span id="mail" class="text-danger font-weight-bold"> </span>
              <?php echo  "<span id=\"mail\" class=\"text-danger font-weight-bold\">"; if(!empty($error)){echo $error;}
              echo "</span>"; ?>
            </div>

            <div class="form-group">
              <label>Password:</label>
              <input type="password" name="pass" class="form-control" id="pass" autocomplete="off"/>
              <span id="password" class="text-danger font-weight-bold"> </span>
            </div>

            <input type="submit" id="submit_button" name="login" value="login"  class="btn btn-outline-primary" onclick="return validateForm()">

        </form><br>
        <div class="text-center text-danger">
          <p>Not a member yet?  <a href="register.php">Register</a></p>
        </div>
        <p class="text-center text-primary">or</p>
        <div class="g-signin2" data-onsuccess="onSignIn"></div>
  </body>
        <script>
            function validateForm()
            {
              var email       = document.getElementById("email").value;
             var password    = document.getElementById("pass").value;

             document.getElementById("mail").innerHTML = "";
             document.getElementById("pass").innerHTML = "";

             if(email == "")
             {
               document.getElementById("mail").innerHTML = " Please enter email";
               return false;
             }
            else if(password == "")
            {
             document.getElementById("password").innerHTML = " Please enter passowrd";
             return false;
            }
            else{

                return true;
            }

            }

        </script>

</html>
