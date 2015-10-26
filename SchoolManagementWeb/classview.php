<?php
include("includes/connect.php");
$operation = $_POST['operation'];
if($operation=="insert") {
    $a = $_POST['classname'];
    $insert_query = "insert into class (classname) values('$a');";
    if(mysqli_query($conn,$insert_query)) {
    }
    echo '<script>alert("Success!");</script>';
}
if($operation=="edview") {
    echo '<table id="att_table">
          <tr>
              <th  id="th" class="col1">ID</th>
              <th  class="col2" id="th">Class name</th>
          </tr>';
    $query = "select * from class";
    $result = mysqli_query($conn,$query);
    $rowCount=mysqli_num_rows($result);
    $a = 0;
    while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
        $a++;
        $classname = "classname".$a."";
        $classid="classid".$a."";
        echo '
          <tr>
              <td class="col1"><input type="text" value="'.$row['class_id'].'" readonly="readonly" style="text-align:center;border:none"  name="'.$classid.'"/></td>
              <td class="col2"><input type="text" value="'.$row['classname'].'" style="text-align:center" name="'.$classname.'"</td>
              </tr>
          ';
    }
    echo '<tr>
<td class="col3"><button id="csedit">Edit</button></td>
</tr>';
    echo '
    <script>
    $("#csedit").click(function(){ ';
    echo 'var o = "edit";';
    for($i=1;$i<=$rowCount;$i++) {
        $iii = 0;
        echo 'var a'.$i.' = document.getElementsByName("classid'.$i.'")['.$iii.'].value;';
        echo 'var b'.$i.' = document.getElementsByName("classname'.$i.'")['.$iii.'].value;';
    }
    echo '
    $.post("classview.php", {operation:"edit",';
    echo 'operation:o , ';
    for($ii=1;$ii<=$rowCount;$ii++) {
        echo 'classid'.$ii.':a'.$ii.' ,';
        echo 'classname'.$ii.':b'.$ii.' ,';
    }
    echo 'rowCount:'.$rowCount.'';

    echo ' },function (data) {
                $("#tab3tablecontent").html(data);
            });
        });
         </script>';
}
if($operation=="edit") {
$rowcount = $_POST['rowCount'];
    for($i=1;$i<=$rowcount;$i++) {
        $a = $_POST['classid'.$i.''];
        $b = $_POST['classname'.$i.''];
        $editquery = "update class set classname='$b' where class_id = '$a'";
        if(mysqli_query($conn,$editquery)) {

        }
    }
    echo '<script>alert("Success!");</script>';
}
?>