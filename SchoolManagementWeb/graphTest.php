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
  <?php include('includes/sidebar.php')?>
  
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
						<th id="now" style="width:600px;">Line</th>
						<th>Last Column</th>
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
						
						
						//$query_graphTop = "select sum(score) as score from classattendance where student_id = '1001'";
						$query_graphTop = "select distinct date from classattendance";
						$top = mysqli_query($conn,$query_graphTop);
						$mustscore = '';
						$dateRowCount = mysqli_num_rows($top);
						/*while($rw = mysqli_fetch_array($top)){
							$mustscore = $rw['score'];
						}*/
						$mustscore = $dateRowCount*5;
						$query_graphAll = '';
						if($chosenMonth == 'OverAll'){
							$query_graphAll = "SELECT code, SUM(score) AS 'score' FROM classattendance where classname = '$chosenClass' group by firstname ";
						}else{
							$query_graphAll = "SELECT code, SUM(score) AS 'score' FROM classattendance where classname = '$chosenClass' and month(date) = '$chosenMonth' group by firstname ";
						}
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
							$fl = $sscore/$mustscore*100;
							$percentage = sprintf("%.2f", $fl);
							
					?>
					
					<tr>
						<td><?php echo $scode?></td>
						<td>
							<div class="graphclass" id="<?php echo $tagid?>" 
								 style="height:25px;
										background:lightblue;
										width:1px;"
										><a><?php echo '(',$percentage,'%',')';
										if($percentage < 50 and $percentage > 0){
											echo 'You gotta WORK b*tch!';;
										}elseif($percentage >= 41 and $percentage <= 69){
											echo 'Work harder';
										}
										elseif($percentage >= 70 and $percentage <= 89){
											echo 'Keep going';
										}
										elseif($percentage >= 90 and $percentage <= 100){
											echo 'You think you can keep it?!';
										}
									?></a>
							</div>
							
							<style>
								#graphline<?php echo $i?>{
									height:25px;
									background:lightblue;
									width:<?php echo $sscore/$mustscore*100,'%'?>;
									animation-name:graphing<?php echo $i?>;
									animation-duration:<?php echo $percentage/15,'s'?>;
									animation-delay:0s;
									animation-iteration-count:1;
									animation-fill-mode: forwards;
								}

								@keyframes graphing<?php echo $i?>{
									0%{background:lightblue;
										width:0px;}
									100%{background:<?php
									
									if($percentage < 50 and $percentage > 0){
											echo '#FF6666';
										}elseif($percentage >= 41 and $percentage <= 69){
											echo '#00CC99';
										}
										elseif($percentage >= 70 and $percentage <= 89){
											echo 'lightblue';
										}
										elseif($percentage >= 90 and $percentage <= 100){
											echo '#3399cc';
										}
									
										
									?>;
										width:<?php echo $sscore/$mustscore*100,'%'?>;
									}
								}
							</style>
							
							
						</td>
						<td><?php echo $sscore?></td>
					</tr>
					
		    <?php		
						} 	} 
					?>
					
					
					
					
				</table>
			
			</form>
				
		</div>



  

</body>
		
</html>