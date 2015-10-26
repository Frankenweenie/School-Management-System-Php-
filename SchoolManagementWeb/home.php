<?php
session_start();
if(!isset($_SESSION['user_name'])){
    header("location: ../login.php");
} else {
}
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/index-style.css" >
</head>
<body>
  <?php include('includes/header.php')?>
  <?php include('includes/sidebar.php')?>


<div id="main">
    <div id="att_frame">
        <div id="att_title"><a>Home</a></div>
        <div id="att_content"></div>
    </div>

    <div id="currentDate" class="input">
        <a>Current Date</a><br>
        <input type="textfield"></input>
    </div>

    


</div>

</body>
</html>