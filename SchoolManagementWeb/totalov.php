<?php
session_start();
if(!isset($_SESSION['user_name'])){
    header("location: login.php");
} else {
	include('includes/connect.php');
	$tUserName = $_SESSION['user_name'];
	$queryFndTid = "select teacher_id from teacher where username = '$tUserName';";
	$fndTid = mysqli_query($conn,$queryFndTid);
	$tid = '';
	if($res = mysqli_fetch_array($fndTid)){
		$tid = $res['teacher_id'];
	}
	
}

?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>GRAPHTESTSHU!</title>
	<link rel="stylesheet" href="css/index-style.css" >
	<link rel="stylesheet" href="css/graph-style.css" >
  </head>
  <body>
  
  <?php include('includes/header.php')?>
  <?php include('includes/sidebar.php');
  
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
  ?>
  
  
  
  
	<div id="main">
		<div id="event_frame">
			<div id="event_title1" class="event_title_text" onclick="tab1()"><a>View Event</a></div>
		</div>
		<div id="zai"></div>
		<div id="event_content">
			
			<form id = "graphForm" method="post">
				<div id="chooser">
					<div class="class">
						<a class="classChooser">Class</a><br><br>
						<select id="chosenClass" name="chosenClass" class="classChooser" onchange='this.form.submit()'>
						<option selected="selected">Select Class</option>
							<?php
							include('includes/connect.php');
							
							$classQuery = "select classname from teacherclass1 where teacher_id ='$tid';";
							$run = mysqli_query($conn,$classQuery);
							while($row = mysqli_fetch_array($run)){
								
								$class = $row['classname'];
				?>		
								<option><?php echo $class?></option>
								<noscript><input type='submit' value="submit"></noscript>
				<?php   
							}
				?>
							
									
						</select>
					</div>
				<?php   
					if(isset($_POST['chosenClass'])){
						$chosenClass1 = $_POST['chosenClass'];
					
				?>	
						<div class="month">
						<a class="dateChooser">Month</a><br><br>
						<select id="cMonth" name = "chosenMonth" class="dateChooser">
							<option selected="selected">OverAll</option>
				<?php
							
							$monthQuery = "select distinct month(date) as month from classattendance;";
							$run = mysqli_query($conn,$monthQuery);
							while($row = mysqli_fetch_array($run)){
								
								$month = $row['month'];
								$fndMonth = 'null';
								$chosenMonth;
								switch($month){
									case 1:  $fndMonth = 'January';   $chosenMonth = '1';    break;
									case 2:  $fndMonth = 'February';  $chosenMonth = '2';    break;
									case 3:  $fndMonth = 'March';     $chosenMonth = '3';    break;
									case 4:  $fndMonth = 'April';     $chosenMonth = '4';    break;
									case 5:  $fndMonth = 'May';       $chosenMonth = '5';    break;
									case 6:  $fndMonth = 'Jun';       $chosenMonth = '6';    break;
									case 7:  $fndMonth = 'July';      $chosenMonth = '7';    break;
									case 8:  $fndMonth = 'August';    $chosenMonth = '8';    break;
									case 9:  $fndMonth = 'September'; $chosenMonth = '9';    break;
									case 10: $fndMonth = 'October';   $chosenMonth = '10';   break;
									case 11: $fndMonth = 'November';  $chosenMonth = '11';   break;
									case 12: $fndMonth = 'December';  $chosenMonth = '12';   break;
								}
				?>		
								<option value="<?php echo $chosenMonth?>"><?php echo $fndMonth?></option>
				<?php   
							}
				?>
							<script>
								document.getElementById("chosenClass").value = "<?php echo $chosenClass1?>";
							</script>	
						</select>
					</div>
				<?php   
					}
				?>
					<input type="submit" name="graphbtn" id="graphbtn" style="width:200px;height:35px;" value="Let'see what happens">
					
				</div>
			
				<table>
					<tr>
						<th>Student Code</th>
						<th>Attendance (20)</th>
						<th>Exam (25)</th>
						<th>Homework (25)</th>
						<th>Active (30)</th>
						<th>Total (100)</th>
					</tr>
					<?php
					
					if(isset($_POST['graphbtn'])){
						$chosenClass = $_POST['chosenClass'];
						$chosenMonth = $_POST['chosenMonth'];
						$fndMonth = '';
						switch($chosenMonth){
									case 1:  $fndMonth = 'January';       break;
									case 2:  $fndMonth = 'February';      break;
									case 3:  $fndMonth = 'March';         break;
									case 4:  $fndMonth = 'April';         break;
									case 5:  $fndMonth = 'May';           break;
									case 6:  $fndMonth = 'Jun';           break;
									case 7:  $fndMonth = 'July';          break;
									case 8:  $fndMonth = 'August';        break;
									case 9:  $fndMonth = 'September';     break;
									case 10: $fndMonth = 'October';       break;
									case 11: $fndMonth = 'November';      break;
									case 12: $fndMonth = 'December';      break;
								}
						
						?>
							<script>
								document.getElementById("now").innerHTML = "<?php echo $fndMonth?>";
							</script>	
					
						<?php 
						
						$query_graphAll = '';
						$query_graphTop = '';
						if($chosenMonth == 'OverAll'){
							$query_graphAll = "SELECT code, SUM(score) AS 'score' FROM classattendance where classname = '$chosenClass' group by firstname ";
							$queryScore = "select SUM(score) from score_exam where student_id='$idealStudentId'";
							$query_graphTop = "select distinct date from classattendance";
							
						}else{
							$query_graphAll = "SELECT code, SUM(score) AS 'score' FROM classattendance where classname = '$chosenClass' and month(date) = '$chosenMonth' group by firstname ";
							$queryScore = "select SUM(score) from score_exam where student_id='$idealStudentId' and MONTH(date)='$chosenMonth'";
							$query_graphTop = "select distinct date from classattendance where MONTH(date)='$chosenMonth'";
							
						}
						
						$top = mysqli_query($conn,$query_graphTop);
						$mustscore = '';
						$dateRowCount = mysqli_num_rows($top);
						$mustscore = $dateRowCount*5;
						
						//$topA = mysqli_query($conn,$query_graphATop);
						//$mustAscore = '';
						//$ARowCount = mysqli_num_rows($topA);
						
						//$mustAscore = $ARowCount*5;
						
						$run = mysqli_query($conn,$query_graphAll);
						$i=0;
						if($run == ''){
							echo 'fuck this! it is empty';
						} 
						while($row = mysqli_fetch_array($run)){
						$i++;
							$scode = $row['code'];
							$sscore = $row['score'];
							$tagid = 'graphline'.$i.'';
							$fl = $sscore/$mustscore*20;
							$percentage = sprintf("%.2f", $fl);
							if($chosenMonth == 'OverAll'){
								$query_graphATop = "select distinct date from classactivity";
								$query_graphAall = "SELECT code, SUM(score) AS 'score' FROM classactivity where classname = '$chosenClass'";	
								$queryEscore = "select SUM(score) from table3 where code = '$scode' and teacher_id = '$tid'";
								$queryHWscore = "select AVG(score) from classhomework where code = '$scode' and teacher_id = '$tid' ";
								$queryAscore = "select SUM(score) from classactivity where code = '$scode' and teacher_id = '$tid' ";
									
							}else{
								$queryAscore = "select SUM(score) from classactivity where code = '$scode' and teacher_id = '$tid' and MONTH(date) = '$chosenMonth' ";
								$queryHWscore = "select AVG(score) from classhomework where code = '$scode' and teacher_id = '$tid' and MONTH(date) = '$chosenMonth'";
								$queryEscore = "select SUM(score) from table3 where code = '$scode' and MONTH(date) = '$chosenMonth' and teacher_id = '$tid'";
								$query_graphAall = "SELECT code, SUM(score) AS 'score' FROM classactivity where code = '$scode' and classname = '$chosenClass' and month(date) = '$chosenMonth' group by firstname ";
								$query_graphATop = "select distinct date from classactivity where MONTH(date)='$chosenMonth'";
							}
							
							$Atop = mysqli_query($conn,$query_graphATop);
							$acDateRowCount = mysqli_num_rows($Atop);
							$mustAcscore = $acDateRowCount*5;
							
							//echo $acDateRowCount,'--------------------';
							
							$AcScore = mysqli_query($conn,$query_graphAall);
							$Atop1=mysqli_fetch_array($AcScore,MYSQL_ASSOC);
							
							
							$AScore = mysqli_query($conn,$queryAscore);
							$ARowScore=mysqli_fetch_array($AScore,MYSQL_ASSOC);
							
							$HWScore = mysqli_query($conn,$queryHWscore);
							$HWRowScore=mysqli_fetch_array($HWScore,MYSQL_ASSOC);
							
							$resultScore = mysqli_query($conn,$queryScore);
							$rowScore=mysqli_fetch_array($resultScore,MYSQL_ASSOC);
							
							
							$run1 = mysqli_query($conn,$queryEscore);
							$rowSumScore = mysqli_fetch_array($run1, MYSQL_ASSOC);
							
							$averageExam = $rowSumScore['SUM(score)']*25/$rowScore['SUM(score)'];
							$averageHW = $HWRowScore['AVG(score)']/4;
							
							$averageA = $ARowScore['SUM(score)'];
							
							$fl2 = $Atop1['score']/$mustAcscore*30;
							
							$fl1 = $averageA/$mustscore*20;
							$percentage1 = sprintf("%.2f", $fl);
							$percentage2 = sprintf("%.2f", $averageExam);
							$percentage3 = sprintf("%.2f", $averageHW);
							$percentage4 = sprintf("%.2f", $fl2); 
							$total = $percentage1 + $percentage2 + $percentage3+ $percentage4;
							
					?>
					
					<tr>
						<td><?php echo $scode?></td>
						<td><?php echo $percentage1?></td>
						<td><?php echo $percentage2?></td>
						<td><?php echo $percentage3?></td>
						<td><?php echo $percentage4?></td>
						<td><?php echo $total?></td>
					</tr>
					
		    <?php		
						} 	} 
					?>
					
					
					
					
				</table>
			
			</form>
				
		</div>



  

</body>
		
</html>