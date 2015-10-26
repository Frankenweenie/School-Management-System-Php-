<?php
include("includes/connect.php");
$operation = $_POST['operation'];
if($operation=="view") {
    $class = $_POST['classname'];
    echo '
         <table id="att_table">
          <tr>
              <th  id="th" class="col1">Lastname</th>
              <th  class="col2" id="th">Firstname</th>
              <th class="col3"  id="th">Code</th>
              <th  id="th">Class</th>
          </tr>';

$classquery = "select class_id from class where classname='$class'";
$classresult = mysqli_query($conn,$classquery);
$classrow = mysqli_fetch_assoc($classresult);
$classid = $classrow["class_id"];

$teacherclassquery = "select teacherclass_id from teacherclass where class_id = '$classid'";
$teacherclassresult = mysqli_query($conn,$teacherclassquery);
$teacherclassrow = mysqli_fetch_assoc($teacherclassresult);
$teacherclassid = $teacherclassrow["teacherclass_id"];


$query = "select * from student where teacherclass_id = '$teacherclassid'";
$result = mysqli_query($conn,$query);
while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
    $classquery = "select classname from class where class_id='$classid'";
    $classresult = mysqli_query($conn,$classquery);
    $classrow = mysqli_fetch_assoc($classresult);
    $classname = $classrow["classname"];
    echo '
          <tr>
              <td class="col1">'.$row["lastname"].'</td>
              <td class="col2">'.$row["firstname"].'</td>
              <td class="col3">'.$row["code"].'</td>
              <td class="col4">'.$classname.'</td>
          </tr>' ;
}
} else if($operation=="insert") {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $code = $_POST['code'];
    $class = $_POST['class'];

    $classquery = "select class_id from class where classname='$class'";
    $classresult = mysqli_query($conn,$classquery);
    $classrow = mysqli_fetch_assoc($classresult);
    $classid = $classrow["class_id"];

    $teacherclassquery = "select teacherclass_id from teacherclass where class_id = '$classid'";
    $teacherclassresult = mysqli_query($conn,$teacherclassquery);
    $teacherclassrow = mysqli_fetch_assoc($teacherclassresult);
    $teacherclassid = $teacherclassrow["teacherclass_id"];

    $insert_query = "insert into student(lastname,firstname,teacherclass_id,code) values('$lastname','$firstname','$teacherclassid','$code');";
    if(mysqli_query($conn,$insert_query)) {
    }
    echo '<script>alert("Success!")</script>';
} else if($operation=="editview") {
$class = $_POST['classname'];
    echo '
         <table id="att_table">
          <tr>
              <th  id="th" class="col1">Lastname</th>
              <th  class="col2" id="th">Firstname</th>
              <th class="col3"  id="th">Code</th>
              <th  id="th">Class</th>
          </tr>';

    $classquery = "select class_id from class where classname='$class'";
    $classresult = mysqli_query($conn,$classquery);
    $classrow = mysqli_fetch_assoc($classresult);
    $classid = $classrow["class_id"];

    $teacherclassquery = "select teacherclass_id from teacherclass where class_id = '$classid'";
    $teacherclassresult = mysqli_query($conn,$teacherclassquery);
    $teacherclassrow = mysqli_fetch_assoc($teacherclassresult);
    $teacherclassid = $teacherclassrow["teacherclass_id"];


    $query = "select * from student where teacherclass_id = '$teacherclassid'";
    $result = mysqli_query($conn,$query);
    $rowCount=mysqli_num_rows($result);
    $aa = 0;
    $oldcode = array();
    while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {

        $aa++;
        $lastnamei = "lastname" . $aa . "";
        $firstnamei = "firstname" . $aa . "";
        $codei = "code" . $aa . "";

        $classquery = "select classname from class where class_id='$classid'";
        $classresult = mysqli_query($conn, $classquery);
        $classrow = mysqli_fetch_assoc($classresult);
        $classname = $classrow["classname"];
        echo '
          <tr>
              <td class="col1"><input type="text" name ="' . $lastnamei . '" value="' . $row["lastname"] . '" style="text-align:center;"/> </td>
              <td class="col2"><input type="text" name ="' . $firstnamei . '" value="' . $row["firstname"] . '" style="text-align:center;"/> </td>
              <td class="col3"><input type="text" name ="' . $codei . '" value="' . $row["code"] . '" style="text-align:center;"/> </td>
              <td class="col4">' . $classname . '</td>
          </tr>';
        array_push($oldcode, $row["code"]);
    }

        echo ' <tr>
              <td><button id="stedit">Edit</button></td>
          </tr>
      </table>';

      echo '  <script>
        $("#stedit").click(function() { ';
    echo ' var rc = '.$rowCount.';';
    for($i=1;$i<=$rowCount;$i++) {
        $iii=0;
        $is = $i-1;
        echo 'var oldcode'.$i.' = "'.$oldcode[$is].'";';
        echo 'var a'.$i.' = document.getElementsByName("lastname'.$i.'")['.$iii.'].value;';
        echo 'var b'.$i.' = document.getElementsByName("firstname'.$i.'")['.$iii.'].value;';
        echo 'var c'.$i.' = document.getElementsByName("code'.$i.'")['.$iii.'].value;';
    }

    echo '
        $.post("studentview.php", {operation:"edit", ';
    for($ii=1;$ii<=$rowCount;$ii++) {
        echo 'lastname'.$ii.':a'.$ii.' ,';
        echo 'firstname'.$ii.':b'.$ii.' ,';
        echo 'code'.$ii.':c'.$ii.' ,';
        echo 'oldcode'.$ii.':oldcode'.$ii.',';
    }
    echo 'rowCount:'.$rowCount.'';


    echo ' },function (data) {
                $("#tab3tablecontent").html(data);
            });
        });
        </script>';



} else if($operation=="edit") {

    $a1 = $_POST['operation'];

    $rowCount = $_POST['rowCount'];
    for($i=1;$i<=$rowCount;$i++) {
        $a = $_POST['lastname'.$i.''];
        $b = $_POST['firstname'.$i.''];
        $c = $_POST['code'.$i.''];
        $oldcode = $_POST['oldcode'.$i.''];

        $editquery = "update student set lastname='$a',firstname='$b',code='$c' where code = '$oldcode';";
        if(mysqli_query($conn,$editquery)) {
        }
    }
    echo '<script>alert("Success!")</script>';
}
?>