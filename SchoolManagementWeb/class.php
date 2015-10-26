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
    <title>Class</title>
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
              <th  id="th" class="col1">ID</th>
              <th  class="col2" id="th">Class name</th>
          </tr>';

    $query = "select * from class";
    $result = mysqli_query($conn,$query);
    while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
        echo '
          <tr>
              <td class="col1">'.$row['class_id'].'</td>
              <td class="col2">'.$row['classname'].'</td>
          </tr>';
    }
    ?>
    </div>

    <div id="tab2">
    <a id="csa">Class name :</a><br>
    <input id="cstf" type="text"/><br>
        <button id="csis">Insert</button>
        <div id="tab2tablecontent"></div>
    </div>

    <div id="tab3">
        <div id="tab3tablecontent"></div>
   </div>


<script type="text/javascript">
    $("#csis").click(function() {
        var c = $('#cstf').val();
        var o = "insert";
        $.post('classview.php', {operation:o,classname:c},
            function (data) {
                $('#tab2tablecontent').html(data);
            });
    });
    $(document).ready(function() {
       var o = "edview";
        $.post('classview.php',{operation:o},function(data) {
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