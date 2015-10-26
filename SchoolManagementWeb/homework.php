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
    <title>Homework Mark</title>
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
        <form method="post">
        <div id="currentDate" class="input">
            <a>Homework name</a><br>
            <input type="text" name="search" value="" id = "hwname">
        </div>

        <div id="selectClass" class="input">

            <a>Select Date</a><br>
            <input type="text" id="select" name="cbox" placeholder="ex:2015-10-01"/>

        </div>
            <div id="selectCB" class="input">
            <a>Select Class</a><br>
            <select id = "selectc" name = "cbbox">
                                <?php
                                $cboxquery = "select * from class";
                                $cboxresult = mysqli_query($conn,$cboxquery);
                                while($row=mysqli_fetch_array($cboxresult,MYSQL_ASSOC)) {
                                    echo '<option value ="'.$row['classname'].'">'.$row['classname'].'</option>';
                                }
                                ?>

            </select>
            </div>
        <button  id="xbtn1" type="button" value="Submit">Search homework</button>
        </form>
        <div id="tablecontent">

        </div>
        </div>

        <div id="tab2">

                <div id="tab2CB" class="input">
                    <a>Select Class</a><br>
                    <select name="tab2cb" id ="classcb">
                                        <?php
                                        $query = "select * from class";
                                        $result = mysqli_query($conn,$query);
                                        while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
                                            echo '<option value ="'.$row["classname"].'">'.$row["classname"].'</option>';
                                        }
                                        ?>

                    </select>
                </div>
                <button  id="tab2btn" type="submit" value="Submit">Search</button>

            <div id = "tab2tablecontent">
            </div>
        </div>
        <div id="tab3">
            <div id="tab3CB" class="input">
                <a>Select Class</a><br>
                <select name="tab3cb" id ="tab3classcb">
                    <?php
                    $query = "select * from class";
                    $result = mysqli_query($conn,$query);
                    while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
                        echo '<option value ="'.$row["classname"].'">'.$row["classname"].'</option>';
                    }
                    ?>
                </select>
            </div>
            <button  id="tab3btn" type="submit" value="Submit">Search</button>

            <div id = "tab3tablecontent">
            </div>
        </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#xbtn1").click(function() {
        var s = "<?php echo $_SESSION['user_name'] ?>";
        var a = $('#hwname').val();
        var b = $('#select').val();
        var c = $('#selectc').val();
        var o = "view";
        $.post('homeworkview.php', {operation:o,posthwname: a, postdate: b, postclass: c,postsession:s},
            function (data) {
                $('#tablecontent').html(data);
            });
    });

    $("#tab2btn").click(function() {
        var a =$('#classcb').val();
        var s = "<?php echo $_SESSION['user_name'] ?>";
        var o = "isview";
        $.post('homeworkview.php',{operation:o,class:a,session:s},
            function(data) {
                $('#tab2tablecontent').html(data);
            });
    });
    $("#tab3btn").click(function() {
        var a = $('#tab3classcb').val();
        var s = "<?php echo $_SESSION['user_name'] ?>";
        var o = "edview";
        $.post('homeworkview.php',{operation:o,class:a,session:s},
        function(data) {
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