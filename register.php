<?php
include('config.php');
if(isset($_SESSION['email']))
{
  header('Location: index.php ');
  die();
}
 ?>
<!doctype HTML>
<html>
<head>
 <title>User Registration</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>


    <div class="container">
      <h1 class="text-center text-success">User Registration</h1><br>
      <div class="col-lg-8 m-auto d-block">

         <form method="post" action="register_server.php"  class="bg-light" id="form_id">


            <div class="form-group">
              <label>Username:</label>
              <input type="text" name="user" class="form-control" id="user" autocomplete="off">
              <span id="username" class="text-danger text-italic font-weight-bold"> </span>
            </div>

            <div class="form-group">
              <label>Email:</label>
              <input type="text" name="email" class="form-control" id="email" autocomplete="off">
              <span id="mail" class="text-danger font-weight-bold"> </span>
            </div>
            <div class="form-group">
              <label>Password:</label>
              <input type="password" name="password" class="form-control" id="pass" autocomplete="off">
              <span id="password" class="text-danger font-weight-bold"> </span>
            </div>
            <div class="form-group">
              <label>Confirm passowrd:</label>
              <input type="password" name="confirm_pass" class="form-control" id="confirm_pass" autocomplete="off">
              <span id="conpass" class="text-danger font-weight-bold"> </span>
            </div>

            <input type="submit"  name="registered" value="submit"  class="btn btn-outline-primary" onclick="return validate()">

        </form><br>
        <div class="text-center text-danger">
          <p>Already registered?  <a href="login.php">Login</a></p>
        </div>
      </div>
  </div>
  <script>
    function validate() {
             var username    = document.getElementById("user").value;
              var email       = document.getElementById("email").value;
             var password    = document.getElementById("pass").value;
            var conpassword = document.getElementById("confirm_pass").value;

            //range validation vaiables
            var letters = /^\w+$/;
            var mailformat = /^([A-Za-z0-9_\-\.]{3,})+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var passformat = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/;


        document.getElementById("username").innerHTML = "";
        document.getElementById("mail").innerHTML = "";
        document.getElementById("password").innerHTML = "";
        document.getElementById("conpass").innerHTML = "";
       if(username == "") {
          document.getElementById("username").innerHTML = "Please enter username";
          return false;
      }
      else if(username.match(letters)== null)
      {
         document.getElementById("username").innerHTML = "username can only be combination of numbers and alphabets";
         return false;
      }
     else if(email == "")
     {
       document.getElementById("mail").innerHTML = " Please enter email";
       return false;
     }
     else if(email.match(mailformat)== null)
     {
        document.getElementById("mail").innerHTML = "email should be in proper format";
        return false;
     }
    else if(password == "")
    {
     document.getElementById("password").innerHTML = " Please enter passowrd";
     return false;
    }
    else if(password.match(passformat)== null )
    {
     document.getElementById("password").innerHTML = " the passowrd should be combination of uppercase,lowercase,number and special character(min length = 8)";
     return false;
    }
    else if(password == (username || email))
    {
     document.getElementById("password").innerHTML = " password cant be same as username or email";
     return false;
    }
    else if(password != conpassword)
    {
      document.getElementById("conpass").innerHTML = " Confirm Password should match with the Password";
      return false;
    }
    else{

        return true;
    }
 }
</script>
  </body>
  </html>
