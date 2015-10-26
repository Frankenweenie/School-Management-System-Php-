<?php
session_start();
if(!isset($_SESSION['user_name'])){
    header("location:login.php");
} else {

}
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Teacher</title>
    <link rel="stylesheet" href="css/index-style.css" >
    <script type= "text/javascript" src="js/jquery-2.1.4.min.js"></script>
</head>
<body>
<?php include('includes/header.php')?>
<?php include('includes/sidebar.php')?>
<?php include("includes/connect.php")?>

<div id="main">
    <div id="event_frame">
        <div id="event_title1" class="event_title_text" onclick="tab1()"><a>View</a></div>
        <div id="event_title2" class="event_title_text" onclick="tab2()"><a>Insert</a></div>
        <div id="event_title3" class="event_title_text" onclick="tab3()"><a>Edit</a></div>
    </div>
    <div id="zai"></div>
    <div id="event_content">
        <div id="tab1">
            <?php
            echo          '<table id="att_table">
          <tr>
              <th  id="th" class="col1">Last name</th>
              <th  class="col2" id="th">First name</th>
              <th  class="col3" id="th">Username</th>
              <th  class="col4" id="th">Password</th>
              <th  class="col5" id="th">Subject</th>
          </tr>';

            $query = "select * from teacher";
            $result = mysqli_query($conn,$query);
            while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
                echo '
          <tr>
              <td class="col1">'.$row['lastname'].'</td>
              <td class="col2">'.$row['firstname'].'</td>
              <td class="col3">'.$row['username'].'</td>
              <td class="col4">'.$row['password'].'</td>
              <td class="col4">'.$row['subject_type'].'</td>
          </tr>';
            }
            ?>
        </div>

        <div id="tab2">

        <div id="tchregister">
            <a>Last name</a><br>
            <input type="text" id="tchlastname" /><br>
            <a>First name</a><br>
            <input type="text" id = "tchfirstname"/><br>
            <a>Username</a><br>
            <input type="text" id="username"/><br>
            <a>Password</a><br>
            <input type="text" id="password" /><br>
            <a>Subject type</a><br>
            <input type="text" id="tchsubject"/><br>
            <button id="tchinsert">Insert</button>
            </div>

        </div>

        <div id="tab3">
            <div id="tab3tablecontent"></div>
        </div>


        <script type="text/javascript">
            $("#tchinsert").click(function() {
                var o = "insert";
                var a=$('#tchlastname').val();
                var b=$('#tchfirstname').val();
                var c=$('#username').val();
                var d=$('#password').val();
                var e=$('#tchsubject').val();
                $.post('teacherview.php', {operation:o,lastname:a,firstname:b,username:c,password: d,subject:e},
                    function (data) {
                        $('#tchregister').html(data);
                    });
            });
            $(document).ready(function() {
                var o = "edview";
                $.post('teacherview.php',{operation:o},function(data) {
                    $('#tab3tablecontent').html(data);
                });
            });
        </script>
</body>
<script>
    function tab1(){

        var x1 = document.getElementById('event_title1');
        var x2 = document.getElementById('event_title2');
        var x3 = document.getElementById('event_title3');

        var x11 = document.getElementById('tab1');
        var x22 = document.getElementById('tab2');
        var x33 = document.getElementById('tab3');
        x11.style.visibility ="visible";
        x22.style.visibility ="hidden";
        x33.style.visibility ="hidden";

        x2.style.color = "white";
        x2.style.left = "170px";
        x2.style.background = "#cfcfcf";
        x2.style.transition = "0.3s";
        x2.style.height = "30px";

        x1.style.color = "black";
        x1.style.left = "30px";
        x1.style.background = "white";
        x1.style.transition = "0.3s";
        x1.style.height = "40px";

        x3.style.color = "white";
        x3.style.left = "310px";
        x3.style.background = "#cfcfcf";
        x3.style.transition = "0.3s";
        x3.style.height = "30px"

    }

    function tab2(){

        var x11 = document.getElementById('tab1');
        var x22 = document.getElementById('tab2');
        var x33 = document.getElementById('tab3');
        x11.style.visibility ="hidden";
        x22.style.visibility ="visible";
        x33.style.visibility ="hidden";



        var x1 = document.getElementById('event_title1');
        var x2 = document.getElementById('event_title2');
        var x3 = document.getElementById('event_title3');

        x1.style.color = "white";
        x1.style.left = "170px";
        x1.style.background = "#cfcfcf";
        x1.style.transition = "0.3s";
        x1.style.height = "30px";

        x2.style.color = "black";
        x2.style.left = "30px";
        x2.style.background = "white";
        x2.style.transition = "0.3s";
        x2.style.height = "40px";

        x3.style.color = "white";
        x3.style.left = "310px";
        x3.style.background = "#cfcfcf";
        x3.style.transition = "0.3s";
        x3.style.height = "30px"

    }

    function tab3(){

        var x11 = document.getElementById('tab1');
        var x22 = document.getElementById('tab2');
        var x33 = document.getElementById('tab3');
        x11.style.visibility ="hidden";
        x22.style.visibility ="hidden";
        x33.style.visibility ="visible";

        var x1 = document.getElementById('event_title1');
        var x2 = document.getElementById('event_title2');
        var x3 = document.getElementById('event_title3');

        x11.style.zIndex = "0";
        x22.style.zInedx = "0";
        x33.style.zIndex = "999";

        x2.style.color = "white";
        x2.style.left = "310px";
        x2.style.background = "#cfcfcf";
        x2.style.transition = "0.3s";
        x2.style.height = "30px";

        x1.style.color = "white";
        x1.style.left = "170px";
        x1.style.background = "#cfcfcf";
        x1.style.transition = "0.3s";
        x1.style.height = "30px";

        x3.style.color = "black";
        x3.style.left = "30px";
        x3.style.background = "white";
        x3.style.transition = "0.3s";
        x3.style.height = "40px"

    }
</script>
</html>