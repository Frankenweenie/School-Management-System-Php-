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
	$tid = $res['teacher_id'];}

?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Welcome</title>
	<link rel="stylesheet" href="css/index-style.css" >
  </head>
  <body>
  
  <?php include('includes/header.php')?>
  <?php include('includes/sidebar.php')?>
  
	<div id="main">
		<div id="event_frame">
			<div id="event_title1" class="event_title_text"><a>Editing</a></div>
			
		</div>
		<div id="zai"></div>
		<div id="event_content">
		
				
			<form id="editform" method="post">
				<div id="attSelectDate" class="input">
					<a>Date</a><br>
					<input style="margin-top:25px;" name="cdate" id="chosendate" type="textfield"></input>
				</div>

				<div id="attSelectClass" class="input">
					<a>Select Class</a><br>
					
					<select  id ="cbox" name="combobox" onchange='this.form.submit()'>
					<option selected="selected">Select Class</option>	
						<?php 
							include('includes/connect.php');
							$query = 'select * from class';
							$run = mysqli_query($conn,$query);
							while($row = mysqli_fetch_array($run)){
								$class = $row['classname'];
						?>
						
						<option><?php echo $class;?></option>
						<noscript><input type='submit' value="submit"></noscript>
						<?php } ?>
					</select>
					
				</div>

				<button  id="attBtn" name="btn2" type="submit">Take/View Attendance</button>
				
				<table style="margin-top:40px;">
				<tr style="border-top:#cfcfcf 1px solid;
						   border-bottom:#cfcfcf 1px solid;
						   height:60px;">
					<th id="codeRow">Code</th>
					<th id="nameRow">Name</th>
					<th id="classRow">Class</th>
					<th id="att1Row"></th>
					<th id="att2Row"></th>
					<th id="att3Row"></th>
					<th id="att4Row"></th>
					<th id="att5Row"></th>
				</tr>
				
				
				<?php
					if(isset($_POST['combobox'])){
						$chosenClass = $_POST['combobox'];
						$chosenDate = $_POST['cdate'];
						$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
						
						if($chosenDate == ''){
							$yesterday1  = date("Y-m-d", time() - 60 * 60 * 24);
							$yesterday2  = date("Y-m-d", time() - (60 * 60 * 24)*2);
							$yesterday3  = date("Y-m-d", time() - (60 * 60 * 24)*3);
							$yesterday4  = date("Y-m-d", time() - (60 * 60 * 24)*4);
							$yesterday5  = date("Y-m-d", time() - (60 * 60 * 24)*5);
							$query_view = 
						   "SELECT firstName, 
							SUM( CASE date WHEN '".$yesterday5."' THEN score ELSE 0 END ) AS '".$yesterday5."', 
							SUM( CASE date WHEN '".$yesterday4."' THEN score ELSE 0 END ) AS '".$yesterday4."', 
							SUM( CASE date WHEN '".$yesterday3."' THEN score ELSE 0 END ) AS '".$yesterday3."',
							SUM( CASE date WHEN '".$yesterday2."' THEN score ELSE 0 END ) AS '".$yesterday2."', 
							SUM( CASE date WHEN '".$yesterday1."' THEN score ELSE 0 END ) AS '".$yesterday1."' 
							FROM classattendance1 where classname = '$chosenClass' group by firstname";
							
							$run1 = mysqli_query($conn,$query_view);
							while($row1 = mysqli_fetch_array($run1)){
								$name = $row1['firstname'];
								$score1 = $row1[$yesterday5];
								$score2 = $row1[$yesterday4];
								$score3 = $row1[$yesterday3];
								$score4 = $row1[$yesterday2];
								$score5 = $row1[$yesterday1];								
								
								
								
							?>
							
							<tr>
								<td><?php echo $name ?></td>
								<td><?php echo $score1 ?></td>
								<td><?php echo $score2 ?></td>
								<td><?php echo $score3 ?></td>
								<td><?php echo $score4 ?></td>
								<td><?php echo $score5 ?></td>
								
								
							</tr>	
							<script>
							
								document.getElementById('codeRow').innerHTML = 'Name';
								document.getElementById('nameRow').innerHTML = '<?php echo $yesterday5 ?>';
								document.getElementById('classRow').innerHTML = '<?php echo $yesterday4 ?>';
								document.getElementById('att1Row').innerHTML = '<?php echo $yesterday3 ?>';
								document.getElementById('att2Row').innerHTML = '<?php echo $yesterday2 ?>';
								document.getElementById('att3Row').innerHTML = '<?php echo $yesterday1 ?>';
								
							</script>	
									
						<?php

								echo'
								<script>
								
								document.getElementById("cbox").value = "'.$chosenClass.'";
								</script>
								';
							}
							
						}else{
							$query_view = "select * from classattendance where classname = '$chosenClass' and date = '$chosenDate' and teacher_id = '$tid'";
							
							$run1 = mysqli_query($conn,$query_view);
							$i=0;
							while($row1 = mysqli_fetch_array($run1)){
								$code = $row1['code'];
								$name = $row1['firstname'];
								$class = $row1['classname'];
								$date = $row1['date'];
								$score = $row1['score'];

								
								$i++;
								$ecode = 'ecode'.$i.'';
								$ename = 'ename'.$i.'';
								$escore = 'escore'.$i.'';
								$eclass = 'eclass'.$i.'';
								
								
								
								?>
							
								<tr>
									<td><input name="<?php echo $ecode?>" value="<?php echo $code ?>"  readonly="readonly"></input></td>
									<td><input name="<?php echo $ename?>" value="<?php echo $name ?>"  readonly="readonly"></input></td>
									<td><input name="<?php echo $eclass?>" value="<?php echo $class ?>" readonly="readonly"></input></td>
									<td><input name="<?php echo $escore?>" value="<?php echo $score ?>"></input></td>
								</tr>	
								
								
								<?php

								echo'
								<script>
								document.getElementById("chosendate").value = "'.$date.'"
								document.getElementById("cbox").value = "'.$chosenClass.'";
								</script>
								';
							}
							echo'
								<button  id="attBtn" name="saveedit" type="submit">Save</button>
							';
								
							
							if(isset($_POST['saveedit'])){
								$rowCount = mysqli_num_rows($run1);
								
								
								for($j=1;$j<=$rowCount;$j++){
									$ecode = 'ecode'.$j.'';
									$ename = 'ename'.$j.'';
									$escore = 'escore'.$j.'';
									$eclass = 'eclass'.$j.'';
									
									$eecode = $_POST[$ecode];
									$eename = $_POST[$ename];
									$eescore = $_POST[$escore];
									$eeclass = $_POST[$eclass];
									//$chosenDate = $_POST['cdate'];
									$query_edit =  "update classattendance 
													set score = '$eescore' 
													where code = '$eecode' and date = '$chosenDate' and teacher_id = '$tid';";
									
									if(mysqli_query($conn,$query_edit)){
										echo '<center><h1>Successfully Edited!</h1></center>';
									}else{
										echo'<center><h1>Problem Occured!</h1></center>';
									}
								}
							}
						}
					}	
				?>
				</table>
				
				
			</form>
		</div>
	</div>



  

</body>
<?php } ?>	
<script>

function tab1(){
	
	var x1 = document.getElementById('event_title1');
	var x2 = document.getElementById('event_title2');
	var x3 = document.getElementById('event_title3');
	
	var x11 = document.getElementById('tab1');
	var x22 = document.getElementById('tab2');
	var x33 = document.getElementById('tab3');
	x11.style.visibility ="visible";
	x22.style.visibility ="hidden";
	x33.style.visibility ="hidden";
	
	x2.style.color = "white";
	x2.style.left = "170px";
	x2.style.background = "#cfcfcf";
	x2.style.transition = "0.3s";
	x2.style.height = "30px"
	
	x1.style.color = "black";
	x1.style.left = "30px";
	x1.style.background = "white";
	x1.style.transition = "0.3s";
	x1.style.height = "40px"
	
	x3.style.color = "white";
	x3.style.left = "310px";
	x3.style.background = "#cfcfcf";
	x3.style.transition = "0.3s";
	x3.style.height = "30px"
	
}
	

function tab2(){
	
	var x11 = document.getElementById('tab1');
	var x22 = document.getElementById('tab2');
	var x33 = document.getElementById('tab3');
	x11.style.visibility ="hidden";
	x22.style.visibility ="visible";
	x33.style.visibility ="hidden";
	
	var x1 = document.getElementById('event_title1');
	var x2 = document.getElementById('event_title2');
	var x3 = document.getElementById('event_title3');
		
	x1.style.color = "white";
	x1.style.left = "170px";
	x1.style.background = "#cfcfcf";
	x1.style.transition = "0.3s";
	x1.style.height = "30px"
	
	x2.style.color = "black";
	x2.style.left = "30px";
	x2.style.background = "white";
	x2.style.transition = "0.3s";
	x2.style.height = "40px"
	
	x3.style.color = "white";
	x3.style.left = "310px";
	x3.style.background = "#cfcfcf";
	x3.style.transition = "0.3s";
	x3.style.height = "30px";
	
}
	
	function tab3(){
		
	var x11 = document.getElementById('tab1');
	var x22 = document.getElementById('tab2');
	var x33 = document.getElementById('tab3');
	x11.style.visibility ="hidden";
	x22.style.visibility ="hidden";
	x33.style.visibility ="visible";
		
	var x1 = document.getElementById('event_title1');
	var x2 = document.getElementById('event_title2');
	var x3 = document.getElementById('event_title3');
	
	x11.style.zIndex = "0";
	x22.style.zInedx = "0";
	x33.style.zIndex = "999";
	
	x2.style.color = "white";
	x2.style.left = "310px";
	x2.style.background = "#cfcfcf";
	x2.style.transition = "0.3s";
	x2.style.height = "30px"
	
	x1.style.color = "white";
	x1.style.left = "170px";
	x1.style.background = "#cfcfcf";
	x1.style.transition = "0.3s";
	x1.style.height = "30px"
	
	x3.style.color = "black";
	x3.style.left = "30px";
	x3.style.background = "white";
	x3.style.transition = "0.3s";
	x3.style.height = "40px"
		
	}
	

	
	
</script>		
</html>