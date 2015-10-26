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
				<a>Exam Report</a>
			</div>
		</div>
		<div id="zai"></div>
		<div id="event_content">
			<div id="tab1">	
				<form action="report_exam.php" method="post">
				<div id="examName" class="input">
					<a>Choose Month</a><br>
	
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
	 
						$sqle = "SELECT DISTINCT MONTHNAME(date) FROM `score_exam` where teacher_id = '$tid';"; 
						$query = mysqli_query($conn, $sqle);

						echo '<select id = "monthCombo" name="combo" >';
						echo '<option id = disCombo2 disabled selected><a>Select month</a></option>';
						while ($rows = mysqli_fetch_array($query, MYSQL_ASSOC)) { 
							echo '<option id = "examComb" value="' . $rows['MONTHNAME(date)'] . '">'. $rows['MONTHNAME(date)'] .'</option>';
						}
						echo '</select>';
				echo '</div>';
				echo '<div id="classTf" class="input">';
					echo '<a>Choose class</a><br>';
 
					$sqle = "SELECT DISTINCT classname FROM `table1` where teacher_id = '$tid';"; 
					$queryCbox = mysqli_query($conn, $sqle);

					echo '<select id = "classCbox" name="classCbox" >';
					echo '<option value="Students of all classes">Students of all classes</option>';
					while ($rowCbox = mysqli_fetch_array($queryCbox, MYSQL_ASSOC)) { 
						if($rowCbox['classname']=="Example")
							continue;
						echo '<option id = "examCbox" value="' . $rowCbox['classname'] . '">'. $rowCbox['classname'] .'</option>';
					}
					echo '</select>';
					
					?>		 
				</div>
		 
				<button id = "showExamBtn" type="submit" name = "submitted">Show me</button>
				</form>
				
				<table id="att_table">
					<tr>
						<th  id="th" class="col1">No.</th>
						<th  class="col2" id="th">Student ID</th>
						<th  class="col2" id="th">Student name</th>
						<th  class="col2" id="th">Total Score</th>

						
					<?php
						if(isset($_POST['submitted'])){
						echo'<th  class="col2" id="th">Percent(%)</th>
					</tr>';
					
							$chosenMonth = @$_POST['combo'];
							$chosenClass = $_POST['classCbox'];
							echo'
								<script>
									document.getElementById("monthCombo").value = "'.$chosenMonth.'";
									document.getElementById("classCbox").value = "'.$chosenClass.'";
								</script>';

							if($chosenMonth==""){
								echo '<script language="javascript">
								alert("Choose the month name you want to see!!")
								</script>';
							}	
	
							if($chosenClass!="Students of all classes"){
								$querySelection = "select class_id from class where classname = '".$_POST['classCbox']."'";
								$cId = mysqli_query($conn, $querySelection);
								$rowcId =  mysqli_fetch_array($cId, MYSQL_ASSOC);
		
								$querySelection2 = "select teacherclass_id from teacherclass where class_id = '".$rowcId['class_id']."' and teacher_id = '$tid'";
								$cId2 = mysqli_query($conn, $querySelection2);
								$rowcId2 =  mysqli_fetch_array($cId2, MYSQL_ASSOC);
								$sql = "select distinct firstname, code from table3 where teacher_id = '$tid' and teacherclass_id = '".$rowcId2['teacherclass_id']."';";
							}else{
								$sql = "select distinct firstname, code from table3 where teacher_id = '$tid';";
							}
			
							$i=0;
							$result = mysqli_query($conn,$sql);
							$queryScore = "select SUM(score) from score_exam where student_id='$idealStudentId' and MONTHNAME(date)='$chosenMonth'";
							$resultScore = mysqli_query($conn,$queryScore);
							$rowScore=mysqli_fetch_array($resultScore,MYSQL_ASSOC);
	
							echo'
								<div id="scoretf" name = "scoretf" class="input">
									<input type="textfield" name = "dateField" id="dateField" readonly = "readonly" value = "Full score: '.$rowScore['SUM(score)'].'"></input>
								</div>';
					
							while($row=mysqli_fetch_array($result,MYSQL_ASSOC)){    
								$querySumScore = "select SUM(score) from table3 where firstname = '".$row['firstname']."' and MONTHNAME(date) = '$chosenMonth'";
								$resultSumScore = mysqli_query($conn, $querySumScore);
								$rowSumScore = mysqli_fetch_array($resultSumScore, MYSQL_ASSOC);
								@$percentage = @$rowSumScore['SUM(score)']*100/@$rowScore['SUM(score)'];
								$realPercent = sprintf("%.2f", $percentage);
			
								if($row["firstname"]=="$idealStudentName")
									continue;
								$i++;
								echo '
									<tr>
										<td class="col1">'.$i.'</td>  
										<td class="col2">'.@$row["code"].'</td> 
										<td class="col3">'.$row["firstname"].'</td>
										<td class="col4"><input type="text" name="tf" readonly = "readonly" value = "'.$rowSumScore['SUM(score)'].'"/></td>
										<td class="col1">'.$realPercent.'</td>
									</tr>';
							}
						}	  
					?>    	


				</table>		
			</div>				
		</div>
    </div>
</body>	
</html>