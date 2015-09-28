<?php
	session_start();
?>
<html >
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login</title>
        <link rel="stylesheet" href="css/login-style.css">
      <script src="js/jquery-2.1.4.min.js"></script>
  </head>
  <body>
<div id="login">
  <h1 style="display:none">Нэвтрэх</h1>
  <form method="post" action="login.php" style="display:none">
      <?php
      include("includes/connect.php");
      if(isset($_POST['login'])){
          $user_name = mysqli_real_escape_string($conn,$_POST['user_name']);
          $user_pass = mysqli_real_escape_string($conn,$_POST['user_pass']);
          $admin_query = "select * from teacher where username = '$user_name' AND password = '$user_pass' ";
          $run = mysqli_query($conn,$admin_query);
          if(mysqli_num_rows($run)>0){
              $_SESSION['user_name'] = $user_name;
              echo "<script>window.open('teacher/index.php','_self')</script>";
          }
          else{
              echo "<p style='
  width:100%;
  margin-bottom:4%;
  text-align: center;
  font-size:95%;
  color:red;
;'>Хэрэглэгчийн нэр эсвэл нууц үг буруу байна!</p>";
          }
      }
      ?>
    <input type="text" placeholder="Хэрэглэгчийн нэр" name="user_name"/>
    <input type="password" placeholder="Хэрэглэгчийн нууц үг" name="user_pass"/>
    <input type="submit" name="login" value="Нэвтрэх" id ="button"/>
<?php 

?>
  </form>
  </div>
<script>
    $(document).ready(function() {
        $("form").fadeIn(2000);
        $("h1").slideDown(1000);
    });
</script>
  </body>
</html>
