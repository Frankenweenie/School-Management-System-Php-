<?php
session_start();
if(!isset($_SESSION['user_name'])){
    header("location: login.php");
} else {
}
?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Exam</title>
	<link rel="stylesheet" href="css/mindex-style.css" >
  </head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <body>
  
	<?php include('includes/header.php')?>
	<?php include('includes/sidebar.php')?>
  
	<div id="main">
		<div id="event_frame">
			<div id="event_title1" class="event_title_text" onclick="tab1()">
				<a>View Exam Mark</a>
			</div>	
		</div>
		<div id="zai"></div>
		<div id="event_content">
			<div id="tab1">	
				<form action="exam.php" method="post">

		<div id="examName" class="input">
			<a>Exam Name</a><br>
	
		 <?php
			include("includes/connect.php");
			$abc=$_SESSION['user_name'];
            $querya = "select teacher_id from teacher where username = '$abc'";
            $rlat = mysqli_query($conn,$querya);
            $rowb = mysqli_fetch_assoc($rlat);
            $tid=$rowb["teacher_id"];
			
			
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
	 
			$sqle = "SELECT DISTINCT ename FROM `score_exam` where teacher_id = '$tid';"; 
			$query = mysqli_query($conn, $sqle);

			echo '<select id = "examCombo" name="combo" >';
			echo '<option id = disCombo2 value="" disabled selected>Select exam name</option>';
			while ($rows = mysqli_fetch_array($query, MYSQL_ASSOC)) { 
				echo '<option id = "examCombo" value="' . $rows['ename'] . '">'. $rows['ename'] .'</option>';
			}
			echo '</select>';

		 
		echo '</div>';
		echo '<div id="classTf" class="input">';
        echo '<a>Class</a><br>';
 
		$sqle = "SELECT DISTINCT classname FROM `table1` where teacher_id = '$tid';"; 
		$queryCbox = mysqli_query($conn, $sqle);

		echo '<select id = "classCbox" name="classCbox" >';
		echo '<option value="Students of all classes">Students of all classes</option>';
		while ($rowCbox = mysqli_fetch_array($queryCbox, MYSQL_ASSOC)) { 
			if($rowCbox['classname']=="FullScore")
				continue;
		echo '<option id = "examCombo" value="' . $rowCbox['classname'] . '">'. $rowCbox['classname'] .'</option>';
		}
		echo '</select>';

		 ?>		 
		 </div>
		 
		 <div id="examDate" name = "examDate" class="input">
			<a>Exam Taken Date</a><br>
			<input type="textfield" name = "dateField" id="dateField" readonly = "readonly"></input>
		</div>
			<button id = "showExamBtn" type="submit" name = "submitted">Show me</button>
				</form>
				<table id="att_table">
					<tr>
						<th  id="th" class="col1">No.</th>
						<th  class="col2" id="th">Student ID</th>
						<th class="col3"  id="th">Name</th>
						<th class = "col4"  id="th">Exam</th>
					</tr>

				<?php
					//include("../includes/connect.php");
					echo '
					<script>
						document.getElementById("disCombo2").value = "Select exam name";
					</script>';
	
					$sql = "select student.code, student.firstname, student.student_id, score_exam.score, score_exam.date, score_exam.ename
							from student left join score_exam on student.student_id = score_exam.student_id where teacher_id = '$tid';";
	
		
	
					if(isset($_POST['submitted'])){
						$classChoice = $_POST['classCbox'];
						$nameChoice = @$_POST['combo'];

						if($nameChoice==""){
							echo '<script language="javascript">
							alert("Choose the exam name you want to see!!")
							</script>';
						}	
	
						if($classChoice!="Students of all classes"){
							$querySelection = "select class_id from class where classname = '".$_POST['classCbox']."'";
							$cId = mysqli_query($conn, $querySelection);
							$rowcId =  mysqli_fetch_array($cId, MYSQL_ASSOC);
		
							$querySelection2 = "select teacherclass_id from teacherclass where class_id = '".$rowcId['class_id']."' and teacher_id = '$tid'";
							$cId2 = mysqli_query($conn, $querySelection2);
							$rowcId2 =  mysqli_fetch_array($cId2, MYSQL_ASSOC);
	
							$sql = "select student.code, student.firstname, student.student_id, score_exam.score, score_exam.date, score_exam.ename 
							from student left join score_exam on student.student_id = score_exam.student_id 
							where teacher_id = '$tid' and score_exam.ename = '$nameChoice' and teacherclass_id = '".$rowcId2['teacherclass_id']."';";
						}else{
							$sql = "select student.code, student.firstname, student.student_id, score_exam.score, score_exam.date, score_exam.ename
							from student left join score_exam on student.student_id = score_exam.student_id
							where teacher_id = '$tid' and score_exam.ename = '$nameChoice';";
						}
		
						$result = mysqli_query($conn,$sql);
						$row=mysqli_fetch_array($result,MYSQL_ASSOC);
						$ldate = $row["date"];

						echo '
							<script>
								document.getElementById("dateField").value = "'.$ldate.'";
								document.getElementById("examCombo").value = "'.$nameChoice.'";
								document.getElementById("classCbox").value = "'.$classChoice.'";
							</script>';
		 
						$result = mysqli_query($conn,$sql);
						$i=0;
		
						while($row=mysqli_fetch_array($result,MYSQL_ASSOC)){         
							if($row["firstname"]=="$idealStudentName")
								continue;
							$i++;
							echo '
							<tr>
								<td class="col1">'.$i.'</td>
								<td class="col2">'.$row["code"].'</td>
								<td class="col3">'.$row["firstname"].'</td>
								<td class="col4"><input type="text" name="tf" readonly = "readonly" value = "'.$row["score"].'"/></td>
							</tr>';

						}
	
						$queryScore = "select * from score_exam where student_id='$idealStudentId' and ename = '$nameChoice'";
						$resultScore = mysqli_query($conn,$queryScore);
						$rowScore=mysqli_fetch_array($resultScore,MYSQL_ASSOC);
						
	
						echo'
						<div id="scoretf" name = "scoretf" class="input">
							<input type="textfield" name = "dateField" id="dateField" readonly = "readonly" value = "Full score: '.$rowScore['score'].'"></input>
						</div>';

						echo '</table>';		
					}
				?>    			
			</div>				
		</div>
    </div>
</body>	
</html>