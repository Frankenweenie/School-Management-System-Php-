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
    <link rel="stylesheet" href="../css/index-style.css" >
</head>
<body>
<div id = "header">
    <img id="logo" src="../img/logo3.png" width="60px"/>
    <a id="a1">School Management System</a>
    <div id="user">
        <img id="hangai" height="40px"  src="../img/userm.jpg" width="40px"/>
        <a id="a2">Joyce</a>
    </div>

</div>
<div class="container">
    <div id="sidebar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="">Events</a></li>
            <li><a href="attendance.php">Attendace</a></li>
            <li><a href="#">Student</a></li>
            <li><a href="#">Class Routine</a></li>
            <li><a href="#">Teachers</a></li>
            <li><a href="#">Attendance mark</a></li>
            <li><a href="#">Activity mark</a></li>
            <li><a href="#">Exam mark</a></li>
            <li><a href="#">Homework mark</a></li>
            <li><a href="logout.php">Sign Out</a></li>
        </ul>
    </div>
</div>

<div id="main">
    <div id="att_frame">
        <div id="att_title"><a>Attendance</a></div>
        <div id="att_content"></div>
    </div>

    <div id="currentDate" class="input">
        <a>Current Date</a><br>
        <input type="textfield"></input>
    </div>

    <div id="selectClass" class="input">
        <a>Select Class</a><br>
        <select value="">
            <option value="">Select Class</option>
        </select>
    </div>

    <button  id="btn1" type="submit">Take/View Attendance</button>


    <a id="att_table_title">Class:Suckers, Date: Sunday</a>

    <?php
    include("../includes/connect.php");
    $sql = "select lastname,firstname,code from student";
    $result = mysqli_query($conn,$sql);
    echo '<table id="att_table">

          <tr>
              <th  id="th" class="col1">No.</th><th  class="col2" id="th">Student ID</th><th class="col3"  id="th">Name</th><th  id="th">Attendance</th>
          </tr>';
    $i=0;
    while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
        $i++;
        echo '<tr>
              <td class="col1">'.$i.'</td>   <td class="col2">'.$row["code"].'</td>     <td class="col3">'.$row["firstname"].'</td>
                <td class="col4">       <input type="radio">Present</input><input type="radio">Absent</input><input type="radio">Leisured</input></td>
          </tr>';

    }
    echo ' <tr>
              <td><button id="btn2">Save Attendance</button></td>
          </tr>

      </table>';
    ?>



    <div id="footer">

    </div>

</div>

</body>
</html>