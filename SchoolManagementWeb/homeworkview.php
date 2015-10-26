            <?php
            include("includes/connect.php");
            $operation = $_POST['operation'];
            if($operation=="view") {
            $sessionname= isset($_POST['postsession']) ? $_POST['postsession'] : "";
            $sessionquery = "select teacher_id from teacher where username = '$sessionname'";
            $sessionresult = mysqli_query($conn,$sessionquery);
            $sessionrow = mysqli_fetch_assoc($sessionresult);
            $sessiontid=$sessionrow["teacher_id"];

           echo '
         <table id="att_table">
          <tr>
              <th  id="th" class="col1">Student name</th>
              <th  class="col2" id="th">Homework name</th>
              <th class="col3"  id="th">Date</th>
              <th  id="th">Score</th>
              <th class="col5" id="th">Class</th>
          </tr>';
                $hwnames = isset($_POST['posthwname']) ? $_POST['posthwname']:"";
                $date = isset($_POST['postdate']) ? $_POST['postdate'] : "";
                $class = isset($_POST['postclass']) ? $_POST['postclass'] : "";
                if($hwnames != '' && $date== '') {

                    $classquery = "select class_id from class where classname='$class'";
                    $classresult = mysqli_query($conn,$classquery);
                    $classrow = mysqli_fetch_assoc($classresult);
                    $classid = $classrow["class_id"];

                    $query = "select firstname,hwname,date,score,class_id from homeworkview where teacher_id = '$sessiontid' and hwname LIKE '$hwnames' and class_id = '$classid' order by hwname";
                    $result = mysqli_query($conn,$query);
                while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
                    $b=$row["class_id"];
                    $queryd = "select classname from class where class_id = '$b'";
                    $results = mysqli_query($conn,$queryd);
                    $aa = mysqli_fetch_assoc($results);
                    $classname = $aa["classname"];

                echo '
          <tr>
              <td class="col1">'.$row["firstname"].'</td>
              <td class="col2">'.$row["hwname"].'</td>
              <td class="col3">'.$row["date"].'</td>
              <td class="col4">'.$row["score"].'</td>
              <td class="col5">'.$classname.'</td>
          </tr>' ;
            }
                    echo '</table>';
                }
                else if($hwnames == '' && $date!='') {
                    $classquery = "select class_id from class where classname='$class'";
                    $classresult = mysqli_query($conn,$classquery);
                    $classrow = mysqli_fetch_assoc($classresult);
                    $classid = $classrow["class_id"];

                    $query = "select firstname,hwname,date,score,class_id from homeworkview where  teacher_id = '$sessiontid' AND date='$date' and class_id = '$classid'";
                    $result = mysqli_query($conn,$query);
                    while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
                        $b=$row["class_id"];
                        $queryd = "select classname from class where class_id = '$b'";
                        $results = mysqli_query($conn,$queryd);
                        $aa = mysqli_fetch_assoc($results);
                        $classname = $aa["classname"];

                        echo '
          <tr>
              <td class="col1">'.$row["firstname"].'</td>
              <td class="col2">'.$row["hwname"].'</td>
              <td class="col3">'.$row["date"].'</td>
              <td class="col4">'.$row["score"].'</td>
              <td class="col5">'.$classname.'</td>
          </tr>';
                    }
                    echo '</table>';
                } else if($hwnames != '' && $date != ''){
                    $classquery = "select class_id from class where classname='$class'";
                    $classresult = mysqli_query($conn,$classquery);
                    $classrow = mysqli_fetch_assoc($classresult);
                    $classid = $classrow["class_id"];

                    $query = "select firstname,hwname,date,score,class_id from homeworkview where teacher_id = '$sessiontid' and class_id = '$classid' and date='$date' and hwname LIKE '$hwnames' order by hwname desc ";
                    $result = mysqli_query($conn,$query);
                    while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
                        $b=$row["class_id"];
                        $queryd = "select classname from class where class_id = '$b'";
                        $results = mysqli_query($conn,$queryd);
                        $aa = mysqli_fetch_assoc($results);
                        $classname = $aa["classname"];

                        echo '
          <tr>
              <td class="col1">'.$row["firstname"].'</td>
              <td class="col2">'.$row["hwname"].'</td>
              <td class="col3">'.$row["date"].'</td>
              <td class="col4">'.$row["score"].'</td>
              <td class="col5">'.$classname.'</td>
          </tr>';
                    }
                    echo '</table>';
                } else if($hwnames == '' && $date == ''){
                    $classquery = "select class_id from class where classname='$class'";
                    $classresult = mysqli_query($conn,$classquery);
                    $classrow = mysqli_fetch_assoc($classresult);
                    $classid = $classrow["class_id"];

                    $query = "select firstname,hwname,date,score,class_id from homeworkview where  teacher_id = '$sessiontid' and class_id = '$classid' order by hwname desc ";
                    $result = mysqli_query($conn,$query);
                    while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
                        $b=$row["class_id"];
                        $queryd = "select classname from class where class_id = '$b'";
                        $results = mysqli_query($conn,$queryd);
                        $aa = mysqli_fetch_assoc($results);
                        $classname = $aa["classname"];

                        echo '
          <tr>
              <td class="col1">'.$row["firstname"].'</td>
              <td class="col2">'.$row["hwname"].'</td>
              <td class="col3">'.$row["date"].'</td>
              <td class="col4">'.$row["score"].'</td>
              <td class="col5">'.$classname.'</td>
          </tr>';
                    }
                    echo '</table>';
                }
            }

            if($operation=="edview") {

                $sessionname= $_POST['session'];
                $sessionquery = "select teacher_id from teacher where username = '$sessionname'";
                $sessionresult = mysqli_query($conn,$sessionquery);
                $sessionrow = mysqli_fetch_assoc($sessionresult);
                $sessiontid=$sessionrow["teacher_id"];

                $class = $_POST['class'];
                $classquery = "select class_id from class where classname = '$class'";
                $classresult = mysqli_query($conn,$classquery);
                $classrow = mysqli_fetch_assoc($classresult);
                $classid=$classrow["class_id"];

                echo '<table id="att_table">
          <tr>
              <th  class="col1" id="th" >Student ID</th>
              <th  class="col2" id="th">Student name</th>
              <th  class="col3" id="th">Homework name</th>
              <th  id="th">Homework Date</th>
              <th  id="th">Score</th>
              <th  id="th">Class</th>
          </tr>';
                $query = "select * from homeworkview where class_id = '$classid'";
                $result = mysqli_query($conn, $query);
                $rowCount=mysqli_num_rows($result);
                $aa = 0;

                $oldhwname = array();
                $oldhwdate = array();
                while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                    $aa++;
                    $marki = "marki".$aa."";
                    $datei = "datei".$aa."";
                    $namei = "namei".$aa."";
                    $studenti = "studenti".$aa."";

                    echo '<tr>
              <td class="col1" "><input type="text"   name = "'.$studenti.'" value="'.$row["student_id"].'" readonly="readonly" style="text-align:center;border:none;"></td>
              <td class="col2">' . $row["firstname"] . '</td>
              <td class="col3"><input type = "text"   name = "'.$namei.'" style="width:80px;" value="'.$row["hwname"].'"/></td>
              <td class="col4"><input type = "text"   name = "'.$datei.'" value="'.$row["date"].'"/></td>
              <td class="col5"><input type = "text"   name = "'.$marki.'" value="'.$row["score"].'"/></td>
              <td class="col6">'.$class.'</td>
              </tr>';
                    array_push($oldhwname,$row["hwname"]);
                    array_push($oldhwdate,$row["date"]);

                }
                echo ' <tr>
              <td><button id="hwedit">Edit</button></td>
          </tr>
      </table>';

                echo '
      <script>
    $("#hwedit").click(function() { ';
                echo 'var s = '.$sessiontid.';';
                echo ' var rc = '.$rowCount.';';
                for($i=1;$i<=$rowCount;$i++) {
                    $iii=0;
                    $is = $i-1;
                    echo 'var oldhwname'.$i.' = "'.$oldhwname[$is].'";';
                    echo 'var oldhwdate'.$i.' = "'.$oldhwdate[$is].'";';
                    echo 'var a'.$i.' = document.getElementsByName("namei'.$i.'")['.$iii.'].value;';
                    echo 'var b'.$i.' = document.getElementsByName("datei'.$i.'")['.$iii.'].value;';
                    echo 'var c'.$i.' = document.getElementsByName("marki'.$i.'")['.$iii.'].value;';
                    echo 'var d'.$i.' = document.getElementsByName("studenti'.$i.'")['.$iii.'].value;';
                }

                echo '
        $.post("homeworkview.php", {operation:"edit", ';
                for($ii=1;$ii<=$rowCount;$ii++) {
                    echo 'hwnamei'.$ii.':a'.$ii.' ,';
                    echo 'hwdatei'.$ii.':b'.$ii.' ,';
                    echo 'hwmarki'.$ii.':c'.$ii.' ,';
                    echo 'hwstidi'.$ii.':d'.$ii.' ,';
                    echo 'oldhwdatei'.$ii.':oldhwdate'.$ii.' ,';
                    echo 'oldhwnamei'.$ii.':oldhwname'.$ii.' ,';

                }
                echo 'rowCount:'.$rowCount.' , session:s';


                echo ' },function (data) {
                $("#tab2tablecontent").html(data);
            });
        });
         </script>';
            }

            if($operation=="edit") {
                include("../includes/connect.php");

                $a1 = $_POST['operation'];
                $s = $_POST['session'];

                $rowCount = $_POST['rowCount'];
                for($i=1;$i<=$rowCount;$i++) {
                    $a = $_POST['hwnamei'.$i.''];
                    $b = $_POST['hwdatei'.$i.''];
                    $c = $_POST['hwmarki'.$i.''];
                    $d = $_POST['hwstidi'.$i.''];
                    $oldhwname = $_POST['oldhwnamei'.$i.''];
                    $oldhwdate = $_POST['oldhwdatei'.$i.''];
                    $editquery = "update score_homework set score='$c',date='$b',hwname='$a' where student_id='$d' and date = '$oldhwdate' and hwname = '$oldhwname';";
                    if(mysqli_query($conn,$editquery)) {

                    } else {
                        echo 'error!';
                    }
                }
                echo '<script>alert("Success!");</script>';
            }

            if($operation=="isview") {

                $sessionname= $_POST['session'];
                $sessionquery = "select teacher_id from teacher where username = '$sessionname'";
                $sessionresult = mysqli_query($conn,$sessionquery);
                $sessionrow = mysqli_fetch_assoc($sessionresult);
                $sessiontid=$sessionrow["teacher_id"];

                $class = isset($_POST['class']) ? $_POST['class'] : "";
                $classquery = "select class_id from class where classname = '$class'";
                $classresult = mysqli_query($conn,$classquery);
                $classrow = mysqli_fetch_assoc($classresult);
                $classid=$classrow["class_id"];

                $teacherclassquery = "select teacherclass_id from teacherclass where class_id = $classid";
                $teacherclassresult= mysqli_query($conn,$teacherclassquery);
                $teacherclassrow=mysqli_fetch_assoc($teacherclassresult);
                $teacherclassid=$teacherclassrow["teacherclass_id"];

                echo '<table id="att_table">
          <tr>
              <th  class="col1" id="th" >Student ID</th>
              <th  class="col2" id="th">Student name</th>
              <th  class="col3" id="th">Homework name</th>
              <th  id="th">Homework Date</th>
              <th  id="th">Score</th>
              <th  id="th">Class</th>
          </tr>';



                $query = "select firstname,student_id from student where teacherclass_id = '$teacherclassid'";
                $result = mysqli_query($conn, $query);
                $rowCount=mysqli_num_rows($result);
                $aa = 0;
                while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                    $aa++;
                    $marki = "marki".$aa."";
                    $datei = "datei".$aa."";
                    $namei = "namei".$aa."";
                    $studenti = "studenti".$aa."";

//                    $a = $row["student_id"];
//                    $querys = "select firstname from student where student_id = '$a'";
//                    $rlts = mysqli_query($conn, $querys);
//                    $rowa = mysqli_fetch_assoc($rlts);
                    echo '<tr>
              <td class="col1" "><input type="text" name = "'.$studenti.'" value="'.$row["student_id"].'" readonly="readonly" style="text-align:center;border:none;"></td>
              <td class="col2">' . $row["firstname"] . '</td>
              <td class="col3"><input type = "text"   name = "'.$namei.'"/></td>
              <td class="col4"><input type = "text"   name = "'.$datei.'" placeholder="ex:2015-09-01"/></td>
              <td class="col5"><input type = "text"   name = "'.$marki.'"/></td>
              <td class="col6">'.$class.'</td>
              </tr>';
                }
                echo ' <tr>
              <td><button id="hwinsert">Insert</button></td>
          </tr>
      </table>';

                echo '
      <script>
    $("#hwinsert").click(function() { ';
                echo 'var s = '.$sessiontid.';';
                echo ' var rc = '.$rowCount.';';
                for($i=1;$i<=$rowCount;$i++) {
                    $iii=0;
                    echo 'var a'.$i.' = document.getElementsByName("namei'.$i.'")['.$iii.'].value;';
                    echo 'var b'.$i.' = document.getElementsByName("datei'.$i.'")['.$iii.'].value;';
                    echo 'var c'.$i.' = document.getElementsByName("marki'.$i.'")['.$iii.'].value;';
                    echo 'var d'.$i.' = document.getElementsByName("studenti'.$i.'")['.$iii.'].value;';
                }

                echo '
        $.post("homeworkview.php", {operation:"insert", ';
                for($ii=1;$ii<=$rowCount;$ii++) {
                    echo 'hwnamei'.$ii.':a'.$ii.' ,';
                    echo 'hwdatei'.$ii.':b'.$ii.' ,';
                    echo 'hwmarki'.$ii.':c'.$ii.' ,';
                    echo 'hwstidi'.$ii.':d'.$ii.' ,';
                }
                echo 'rowCount:'.$rowCount.' , session:s';


                echo ' },function (data) {
                $("#tab2tablecontent").html(data);
            });
        });
         </script>';
            }

            if($operation=="insert") {
                include("../includes/connect.php");

                $a1 = $_POST['operation'];
                $s = $_POST['session'];

                $rowCount = $_POST['rowCount'];
                for($i=1;$i<=$rowCount;$i++) {
                    $a = $_POST['hwnamei'.$i.''];
                    $b = $_POST['hwdatei'.$i.''];
                    $c = $_POST['hwmarki'.$i.''];
                    $d = $_POST['hwstidi'.$i.''];
                    $insert_query = "insert into score_homework (student_id,score,date,hwname,teacher_id) values('$d','$c','$b','$a','$s')";
                    if(mysqli_query($conn,$insert_query)) {
                    }
                }
                echo '<script>alert("Success!");</script>';
            }


            ?>