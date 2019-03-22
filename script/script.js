
var script = <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
function onSignIn(googleUser){

    var profile = googleUser.getBasicProfile();
    var email  = profile.U3;
    var username = profile.ofa;

    $.ajax({

          type : "POST",
          url  : "index.php",
          //datatype:'JSON',
          data : { email: email, username:username},
          success : function(response){
            window.location.href = "index.php";


          }
          });

    //console.log(username);
    //console.log(profile);


}
