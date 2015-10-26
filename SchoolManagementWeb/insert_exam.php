<?php
session_start();
if(!isset($_SESSION['user_name'])){
    header("location: login.php");
} else {}
?>

<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Exam</title>
	<link rel="stylesheet" href="css/mindex-style2.css" >
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
  
  <?php include('includes/header.php')?>
  <?php include('includes/sidebar.php')?>
  
	<div id="main">
		<div id="event_frame">
			<div id="event_title2" class="event_title_text" onclick="tab1()">
				<a>Insert Exam Mark</a>
			</div>
		</div>
		<div id="zai"></div>
		<div id="event_content">
			<div id="tab2">
			
			<?php
				include("includes/connect.php");
				$abc=$_SESSION['user_name'];
				$querya = "select teacher_id from teacher where username = '$abc'";
				$rlat = mysqli_query($conn,$querya);
				$rowb = mysqli_fetch_assoc($rlat);
				$tid=$rowb["teacher_id"];?>

				<form action = "insert_exam.php" method = "post">

					<div id="className" class="input">
						<a>Class Name</a><br>
						<select  id ="classCombo" name="classCombo" onchange='this.form.submit()'>
						<option>All Students </option>
					<?php 
						$query = "select distinct classname from table1 where teacher_id = '$tid'";
						$run = mysqli_query($conn,$query);
						while($row = mysqli_fetch_array($run)){
							if($row['classname']=="Example")
								continue;
							$class = $row['classname'];
					?>
					
					<option><?php echo $class?></option>
					<noscript><input type='submit' value="submit"></noscript>
					<?php   } ?>
						</select>
					</div>
					
					<div id="insertExamDate" name = "insertExamDate" class="input">
						<a>Exam Taken Date</a><br>
						<input id="datepicker" name = "datepicker"/>
					</div>
		
					<div id="insertExamFullScore" name = "insertExamFullScore" class="input">
						<a>Full Score</a><br>
						<input type="textfield" id="fullscore" name = "fullscore"></input>
					</div>
					<div id="insertExamName" name = "insertExamName" class="input">
						<a>Exam Name</a><br>
						<input type="textfield" name = "insertExamField" id="insertExamField"></input>
					</div>		

				<button id = "insertAllBtn" name = "insertBtn" type = "submit">Done</button>

				<?php
					$queryIdealClassId = "select * from class where classname= 'Example'";
					$resultIdealClassId = mysqli_query($conn, $queryIdealClassId);
					$rowIdealClassId = mysqli_fetch_array($resultIdealClassId, MYSQL_ASSOC);
		  
					$queryIdealTeacherClassId = "select * from teacherclass where class_id='".$rowIdealClassId['class_id']."' and teacher_id = '4'";
					$resultIdealTeacherClassId = mysqli_query($conn, $queryIdealTeacherClassId);
					$rowIdealTeacherClassId = mysqli_fetch_array($resultIdealTeacherClassId, MYSQL_ASSOC);
		  
					$queryIdealStudentId = "select * from student where teacherclass_id='".$rowIdealTeacherClassId['teacherclass_id']."'";
					$resultIdealStudentId = mysqli_query($conn, $queryIdealStudentId);
					$rowIdealStudentId = mysqli_fetch_array($resultIdealStudentId, MYSQL_ASSOC);
		  
					$idealStudentId = $rowIdealStudentId['student_id'];
					$idealStudentName = $rowIdealStudentId['firstname'];

					$sql = "select * from table2 where teacher_id = '$tid'";
					$result = mysqli_query($conn,$sql);
					
				if(isset($_POST['classCombo'])){

					$classChoice = $_POST['classCombo'];
	   
					if($classChoice!= "All Students"){
						$sql = "select * from table2 where classname = '$classChoice' and teacher_id = '$tid';";
						$result = mysqli_query($conn,$sql);
						$row=mysqli_fetch_array($result,MYSQL_ASSOC);
					}else{
						$sql = "select * from table2 where teacher_id = '$tid';";
						$result = mysqli_query($conn,$sql);
						$row=mysqli_fetch_array($result,MYSQL_ASSOC);
					}

				echo '<script>
						document.getElementById("classCombo").value = "'.$classChoice.'";
					  </script>';
				}	 

				echo '<div><table id="att_table">
						<tr>
							<th id="th" class="col1">No.</th>
							<th  class="col2" id="th">Student ID</th>
							<th class="col3"  id="th">Name</th>
							<th class = "col4"  id="th">Exam</th>
						</tr>';
    
				$result = mysqli_query($conn,$sql);
				$i=0;
				$rowCount = mysqli_num_rows($result);

				while($row=mysqli_fetch_array($result,MYSQL_ASSOC)){
					$i++;
					$ssid = "ssid".$i."";
					$presence = "presence".$i."";
					$sid = $row['student_id'];	
					if($sid == "$idealStudentId")
						continue;
					
					echo '
						<tr>
						
							<td class="col1"><input readonly = "readonly" name="student_'.$i.'"  type="text" value="'.$row["student_id"].'"></td>   
							<td class="col2">'.$row["code"].'</td>
							<td class="col3">'.$row["firstname"].'</td>
							<td class="col4"><input type="text" value = "" name="score_'.$i.'"/></td>
						</tr>';
				}
	
				if(isset($_POST['insertBtn'])){
		
					$datepick = $_POST['datepicker'];
					$examName = $_POST['insertExamField'];
					$fullscore = $_POST['fullscore'];
					
									
					if($fullscore==""){
						echo '<script language="javascript">
								alert("Full score must be filled!!")
							  </script>';
					
					}else{					
									
						if($examName==""){
										
							echo '<script language="javascript">';
							echo 'alert("Insert your exam names at least!!")';
							echo '</script>';
										
						}else if($datepick==""){
							for($j=1; $j<=$rowCount; $j++){
											
								
											
								$studentId = $_POST['student_'.$j];
								$examScore = $_POST['score_'.$j];
								$datepick = date("Y-m-d");
										
										if($studentId==$idealStudentId)
									continue;
								$selecting_query = "select * from score_exam where student_id = '$studentId' and ename ='$examName'";
								$exec = mysqli_query($conn,$selecting_query);
								$count = mysqli_num_rows($exec);
										
								if($count==0){

										$insert_query = "insert into score_exam
										   (student_id,score,date,ename,teacher_id)
											values
											('$studentId','$examScore','$datepick','$examName','$tid')";	
											
										$res = mysqli_query($conn, $insert_query);
								}
											
							}
										
						$selecting_querys = "select * from score_exam where student_id = '$idealStudentId' and ename ='$examName'";
						$execs = mysqli_query($conn,$selecting_querys);
						$counts = mysqli_num_rows($execs);
										
						if($counts==0){		
							$score_query = "insert into score_exam (student_id,score,date,ename,teacher_id) values ('$idealStudentId','$fullscore','$datepick','$examName','4')";
							$res_query = mysqli_query($conn, $score_query);
						}
								
						if($counts!=0){
							echo '<script language="javascript">';
							echo 'alert("Full score has already inserted. If you want to change, use Edit Exam Mark!!")';
							echo '</script>';			
						}
										
						}else{
										
							for($j=1; $j<=$rowCount; $j++){
											
								
											
								$studentId = $_POST['student_'.$j];
								$examScore = $_POST['score_'.$j];
										
										if($studentId==$idealStudentId)
									continue;
										
								$selecting_query = "select * from score_exam where student_id = '$studentId' and ename ='$examName'";
								$exec = mysqli_query($conn,$selecting_query);
								$count = mysqli_num_rows($exec);
		
								if($count==0){

									$insert_query = "insert into score_exam
									(student_id,score,date,ename,teacher_id)
									values
									('$studentId','$examScore','$datepick','$examName','$tid')";	

									$res = mysqli_query($conn, $insert_query);
								}
								
								
								$selecting_querys = "select * from score_exam where student_id = '$idealStudentId' and ename ='$examName'";
								$execs = mysqli_query($conn,$selecting_querys);
								$counts = mysqli_num_rows($execs);
							}
										
							if($counts==0){
								$score_query = "insert into score_exam (student_id,score,date,ename,teacher_id) values ('$idealStudentId','$fullscore','$datepick','$examName','4')";
								$res_query = mysqli_query($conn, $score_query);
							}
								
							if($counts!=0){
								echo '<script language="javascript">';
								echo 'alert("Full score has already inserted. If you want to change, use Edit Exam Mark!!")';
								echo '</script>';
											
							}
									
									
						}
					}
				}

    echo '</table>';
?> 

				</div> 
				</form>
			</div>		
		</div>
    </div>
</body>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script> $(document).ready(function(){
	$("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' }); 
	}); 
</script>

</html>