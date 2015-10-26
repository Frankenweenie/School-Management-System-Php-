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
		<link rel="stylesheet" href="css/mindex-style.css" >
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
  
		<?php include('includes/header.php')?>
		<?php include('includes/sidebar.php')?>
  
		<div id="main">
	
		<div id="event_frame">
			<div id="event_title1" class="event_title_text">
				<a>Edit Exam Mark</a>
			</div>
		</div>
		<div id="zai"></div>
		<div id="event_content">
			<div id="tab3">
				<form method = "post">
					<div id="examName" class="input">
					<a>Exam Name</a><br>
	
				<?php
					include("includes/connect.php");
					$abc=$_SESSION['user_name'];
					$querya = "select teacher_id from teacher where username = '$abc'";
					$rlat = mysqli_query($conn,$querya);
					$rowb = mysqli_fetch_assoc($rlat);
					$tid=$rowb["teacher_id"];
	
					$sqle = "SELECT DISTINCT ename FROM `score_exam` where teacher_id = '$tid';"; 
					$query = mysqli_query($conn, $sqle);

					echo '<select id = "examCombo" name="combo" >';
					echo '<option id = disCombo2 value="" disabled selected>Select exam name</option>';

					while ($rows = mysqli_fetch_array($query, MYSQL_ASSOC)) { 
						echo '<option id = "examCombos" value="' . $rows['ename'] . '">'. $rows['ename'] .'</option>';
					}
					echo '</select>';

					echo '</div>';
					echo '<div id="classTf" class="input">';
					echo '<a>Class</a><br>';
 
					$sqle = "SELECT DISTINCT classname FROM `table1` where teacher_id = '$tid';"; 
					$queryCbox = mysqli_query($conn, $sqle);

					echo '<select id = "classCbox" name="classCbox" >';
					echo '<option id = disCombo value="Students of all classes">Students of all classes</option>';
					while ($rowCbox = mysqli_fetch_array($queryCbox, MYSQL_ASSOC)) {
						if($rowCbox['classname']=="FullScore")
							continue;	
						echo '<option id = "classCombo" value="' . $rowCbox['classname'] . '">'. $rowCbox['classname'] .'</option>';
					}
					echo '</select>';

				?>		 
					</div>
				<div id="examDate" name = "examDate" class="input" >
					<a>Exam Taken Date</a><br>
					<input type="textfield" name = "dateField" id="dateField" readonly = "readonly"></input>
				</div>
				<button id = "showExamBtn" type="submit" name = "submitted">Show me</button>
		
		
				<?php
					//include("../includes/connect.php");

					$sql = "select student.code, student.firstname, student.student_id, score_exam.score, score_exam.date, score_exam.ename
					from student left join score_exam on student.student_id = score_exam.student_id where teacher_id = '$tid';";
	
					echo '<table id="att_table">

					<tr>
						<th  id="th" class="col1">No.</th>
						<th  class="col2" id="th">Student ID</th>
						<th class="col3"  id="th">Name</th>
						<th class = "col4"  id="th">Exam</th>
					</tr>';
		  
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
	
					if(isset($_POST['submitted'])){
	
						$classChoice = $_POST['classCbox'];
						echo '
						<script>
							document.getElementById("classCbox").value = "'.$classChoice.'";
						</script>';
		
						if($classChoice!="Students of all classes"){
							$querySelection = "select class_id from class where classname = '".$_POST['classCbox']."'";
							$cId = mysqli_query($conn, $querySelection);
							$rowcId =  mysqli_fetch_array($cId, MYSQL_ASSOC);
		
							$querySelection2 = "select teacherclass_id from teacherclass where class_id = '".$rowcId['class_id']."' and teacher_id = '$tid'";
							$cId2 = mysqli_query($conn, $querySelection2);
							$rowcId2 =  mysqli_fetch_array($cId2, MYSQL_ASSOC);

							$nameChoice = $_POST['combo'];
							$sql = "select student.code, student.firstname, student.student_id, score_exam.score, score_exam.date, score_exam.ename 
							from student left join score_exam on student.student_id = score_exam.student_id 
							where teacher_id = '$tid' and score_exam.ename = '$nameChoice' and teacherclass_id = '".$rowcId2['teacherclass_id']."';";
		
							$result = mysqli_query($conn,$sql);
							$row=mysqli_fetch_array($result,MYSQL_ASSOC);
		
						}else{
	
							$nameChoice = @$_POST['combo'];
							$sql = "select student.code, student.firstname, student.student_id, score_exam.score, score_exam.date, score_exam.ename
							from student left join score_exam on student.student_id = score_exam.student_id
							where teacher_id = '$tid' and score_exam.ename = '$nameChoice' ;";
							
							$result = mysqli_query($conn,$sql);
							$row=mysqli_fetch_array($result,MYSQL_ASSOC);
						}
						
						$ldate = $row["date"];

						echo '
						<script>
							document.getElementById("dateField").value = "'.$ldate.'";
							document.getElementById("examCombo").value = "'.$nameChoice.'";
						</script>';
		
						$sqlForScore = "select * from score_exam where teacher_id = '4' and score_exam.ename = '$nameChoice' and student_id = '$idealStudentId'  ;";
						$resultForScore = mysqli_query($conn,$sqlForScore);
						$rowForScore=mysqli_fetch_array($resultForScore,MYSQL_ASSOC);
		 
						echo '<div id="editedExamDate" name = "editedExamDate">
						<input id="datepicker" name = "datepicker" placeholder = "Change Date Here"/>
						</div>
						<input id="editedExamName" name = "editedExamName" placeholder = "Change Name Here"/>
						<input id="editedFullScore" name = "editedFullScore" placeholder = "Change Fullscore here"/>
						
						<script>
							document.getElementById("editedFullScore").value = "'.$rowForScore['score'].'";
						</script>
		
						<button id = "done" type="submit" name = "submitEdit">Done</button>';
						
						$result = mysqli_query($conn,$sql);
						$i=0;
	
						while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
							if($row['firstname']=="$idealStudentName"){
								continue;
							}
							$i++;
							echo '<tr>
									<td class="col1">'.$i.'</td>
									<td class="col2"><input type="text" name = "code_'.$i.'" value = "'.$row["code"].'"  readonly = "readonly"/></td>
									<td class="col3">'.$row["firstname"].'</td>
									<td class="col4"><input type="text" name = "score_'.$i.'" value = "'.$row["score"].'"/></td>
								</tr>';
						}	

					}	
					
					if(isset($_POST['submitEdit'])){
	
						$classChoice = $_POST['classCbox'];
						echo '
							<script>
								document.getElementById("classCbox").value = "'.$classChoice.'";
							</script>';
		
						if($classChoice!="Students of all classes"){
							$querySelection = "select class_id from class where classname = '".$_POST['classCbox']."'";
							$cId = mysqli_query($conn, $querySelection);
							$rowcId =  mysqli_fetch_array($cId, MYSQL_ASSOC);
		
							$querySelection2 = "select teacherclass_id from teacherclass where class_id = '".$rowcId['class_id']."' and teacher_id = '$tid'";
							$cId2 = mysqli_query($conn, $querySelection2);
							$rowcId2 =  mysqli_fetch_array($cId2, MYSQL_ASSOC);
		
							$nameChoice = @$_POST['combo'];
							$sql = "select student.code, student.firstname, student.student_id, score_exam.score, score_exam.date, score_exam.ename
							from student left join score_exam on student.student_id = score_exam.student_id
							where teacher_id = '$tid' and score_exam.ename = '$nameChoice' and teacherclass_id = '".$rowcId2['teacherclass_id']."';";
		
							$result = mysqli_query($conn,$sql);
							$row=mysqli_fetch_array($result,MYSQL_ASSOC);
						}else{
	
							$nameChoice = @$_POST['combo'];
							$sql = "select student.code, student.firstname, student.student_id, score_exam.score, score_exam.date, score_exam.ename 
							from student left join score_exam on student.student_id = score_exam.student_id 
							where teacher_id = '$tid' and score_exam.ename = '$nameChoice' ;";
		
							$result = mysqli_query($conn,$sql);
							$row=mysqli_fetch_array($result,MYSQL_ASSOC);
						}
						
						$ldate = $row["date"];
						echo '
							<script>
								document.getElementById("dateField").value = "'.$ldate.'";
							</script>';
		 
						echo '<div id="editedExamDate" name = "editedExamDate">
							<input id="datepicker" name = "datepicker" placeholder = "Change Date Here"/>	
							 </div>
		
							<input id="editedExamName" name = "editedExamName" placeholder = "Change Name Here"/>
							<input id="editedFullScore" name = "editedFullScore" placeholder = "Change Fullscore here"/>
							<button id = "done" type="submit" name = "submitEdit">Done</button>';

    
						$result = mysqli_query($conn,$sql);
						$i=0;
						while($row=mysqli_fetch_array($result,MYSQL_ASSOC)) {
							if($row['firstname']=="$idealStudentName")
								continue;
							$i++;
							echo '
								<tr>
									<td class="col1">'.$i.'</td>   
									<td class="col2"><input type="text" name = "code_'.$i.'" value = "'.$row["code"].'" readonly = "readonly"/></td> 
									<td class="col3">'.$row["firstname"].'</td>
									<td class="col4"><input type="text" id = "scores_'.$i.'" name="score_'.$i.'" value = "'.$row["score"].'"/></td>
								</tr>';
		  
		  
							$editedDate = $_POST['datepicker'];
							$editedName = $_POST['editedExamName'];
		
							if($editedName == ""){
								$editedName = $nameChoice;	
							}
		
							if($editedDate == ""){
								$editedDate = @$ldate;
							}
		
							$studentCode = @$_POST['code_'.$i];
							$examScore = @$_POST['score_'.$i];
				
							$update_query = "update score_exam set ename = '$editedName', date = '$editedDate', score = '$examScore' where ename = '$nameChoice' and student_id = '$row[student_id]'";	
							$editedFullScore = @$_POST['editedFullScore'];
							
							$updateScore = "update score_exam set ename = '$editedName', date = '$editedDate', score = '$editedFullScore' where ename = '$nameChoice' and student_id = '$idealStudentId'";
							$resScore = mysqli_query($conn, $updateScore);
							$res = mysqli_query($conn, $update_query);
							
							echo '<script>document.getElementById("scores_'.$i.'").value = "'.@$_POST['score_'.$i].'";</script>';
						}
							
							
						echo '
							<script>
								document.getElementById("dateField").value = "'.@$editedDate.'";
								document.getElementById("examCombo").value = "'.@$editedName.'";
								document.getElementById("editedFullScore").value = "'.@$editedFullScore.'";
							</script>';	
					}
					echo '</table>';
				?>    
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