<?php
include("includes/connect.php");
$operation = $_POST['operation'];
if($operation=="insert") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $subject = $_POST['subject'];

    $insert_query = "insert into teacher (lastname,firstname,username,password,subject_type) values('$lastname','$firstname','$username','$password','$subject');";
    if(mysqli_query($conn,$insert_query)) {
    }
    echo '<script>alert("Success!");</script>';
}
else if($operation=="edview") {
    echo '<table id="att_table">
          <tr>
              <th  id="th" class="col1">ID</th>
              <th  class="col2" id="th">Last name</th>
              <th  class="col3" id="th">First name</th>
              <th  class="col4" id="th">Username</th>
              <th  class="col5" id="th">Password</th>
              <th  class="col6" id="th">Subject</th>
          </tr>';
    $query = "select * from teacher";
    $result = mysqli_query($conn,$query);
    $rowCount=mysqli_num_rows($result);
    $a = 0;
    while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
        $a++;
        $id = "id".$a."";
        $lastname = "lastname".$a."";
        $firstname="firstname".$a."";
        $username="username".$a."";
        $password="password".$a."";
        $subject="subject".$a."";
        echo '
          <tr>
              <td class="col1"><input type="text" value="'.$row['teacher_id'].'" readonly="readonly" style="text-align:center;border:none"  name="'.$id.'"/></td>
              <td class="col2"><input type="text" value="'.$row['lastname'].'" style="text-align:center" name="'.$lastname.'"</td>
                <td class="col3"><input type="text" value="'.$row['firstname'].'" style="text-align:center" name="'.$firstname.'"</td>
                <td class="col4"><input type="text" value="'.$row['username'].'" style="text-align:center" name="'.$username.'"</td>
                <td class="col5"><input type="text" value="'.$row['password'].'" style="text-align:center" name="'.$password.'"</td>
                <td class="col6"><input type="text" value="'.$row['subject_type'].'" style="text-align:center" name="'.$subject.'"</td>
              </tr>
          ';
    }
    echo '<tr>
<td class="col3"><button id="tchedit">Edit</button></td>
</tr>';
    echo '
    <script>
    $("#tchedit").click(function(){ ';
    echo 'var o = "edit";';
    for($i=1;$i<=$rowCount;$i++) {
        $iii = 0;
        echo 'var a'.$i.' = document.getElementsByName("id'.$i.'")['.$iii.'].value;';
        echo 'var b'.$i.' = document.getElementsByName("lastname'.$i.'")['.$iii.'].value;';
        echo 'var c'.$i.' = document.getElementsByName("firstname'.$i.'")['.$iii.'].value;';
        echo 'var d'.$i.' = document.getElementsByName("username'.$i.'")['.$iii.'].value;';
        echo 'var e'.$i.' = document.getElementsByName("password'.$i.'")['.$iii.'].value;';
        echo 'var f'.$i.' = document.getElementsByName("subject'.$i.'")['.$iii.'].value;';
    }
    echo '
    $.post("teacherview.php", {operation:"edit",';
    echo 'operation:o , ';
    for($ii=1;$ii<=$rowCount;$ii++) {
        echo 'id'.$ii.':a'.$ii.' ,';
        echo 'lastname'.$ii.':b'.$ii.' ,';
        echo 'firstname'.$ii.':c'.$ii.' ,';
        echo 'username'.$ii.':d'.$ii.' ,';
        echo 'password'.$ii.':e'.$ii.' ,';
        echo 'subject'.$ii.':f'.$ii.' ,';
    }
    echo 'rowCount:'.$rowCount.'';

    echo ' },function (data) {
                $("#tab3tablecontent").html(data);
            });
        });
         </script>';
} else if($operation=="edit") {
    $rowcount = $_POST['rowCount'];
    for($i=1;$i<=$rowcount;$i++) {
        $a = $_POST['id'.$i.''];
        $b = $_POST['lastname'.$i.''];
        $c = $_POST['firstname'.$i.''];
        $d = $_POST['username'.$i.''];
        $e = $_POST['password'.$i.''];
        $f = $_POST['subject'.$i.''];
        $editquery = "update teacher set lastname='$b',firstname='$c',username='$d',password='$e',subject_type='$f' where teacher_id = '$a'";
        if(mysqli_query($conn,$editquery)) {

        }
    }
    echo '<script>alert("Success!");</script>';
}
?>