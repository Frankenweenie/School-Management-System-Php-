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
    <title>Checking Attendance</title>
    <link rel="stylesheet" href="css/index-style.css" >
	
</head>
<body>
  <?php include('includes/header.php')?>
  <?php include('includes/sidebar.php')?>


<div id="main">
    <div id="att_frame">
        <div id="att_title"><a>Attendance</a></div>
        <div id="att_content"></div>
    </div>
	<div id="zai"/>
	
		<form method="post">
			<div id="attSelectDate" class="input">
				<a>Date</a><br>
				<?php
				
				$cdate = date("Y-m-d");
				
				?>
				
				<input style="margin-top:25px;text-align:center;" name="chosenDate" id="chosendate" type="textfield" value="<?php echo $cdate;?>">
			</div>
				
			<div id="attSelectClass" class="input">
				<a>Select Class</a><br>
				
				<select  id ="cbox" name="combobox" onchange='this.form.submit()'>
					<option selected="selected">Select Class</option>	
					<?php 
						include('includes/connect.php');
						$query = "select distinct classname from classattendance where teacher_id = '$tid'";
						$run = mysqli_query($conn,$query);
						while($row = mysqli_fetch_array($run)){
							$class = $row['classname'];
					?>
					
					<option><?php echo $class;?></option>
					<noscript><input type='submit' value="submit"></noscript>
				<?php   } ?>
				</select>
				
			</div>

				<button  id="attBtn" name="saveatt" type="submit">Save Attendance</button>		
				
				
				<table style="margin-top:60px;border-collapse:collapse;margin-left:25px;">
					<tr style="border-top:#cfcfcf 1px solid;
						   border-bottom:#cfcfcf 1px solid;
						   height:60px;">
					   <th>ID</th>
						<th>Student Code</th>
						<th>First Name</th>
						<th>Attendance</th>
					</tr>
					
					<?php
						
						if(isset($_POST['combobox'])){
							$chosenClass2 = $_POST['combobox'];
							$query4 = "select * from studentclass2 where classname ='$chosenClass2' and teacher_id = '$tid'";
							$run4 = mysqli_query($conn,$query4);
							$i=0;
							$rowCount = mysqli_num_rows($run4);
							while($row4 = mysqli_fetch_array($run4)){
								$i++;
								$ssid = "ssid".$i."";
								$presence = "presence".$i."";
								$sid = $row4['student_id'];
								$scode = $row4['code'];
								$sname = $row4['firstname'];
								
						?>	
						
					<tr id="attInsertRow">
						<td width="15%"><input style="text-align:center;border:none;" readonly="readonly" name="<?php echo $ssid ?>" type="text" value="<?php echo $sid?>"/></td>
						<td width="15%"><?php echo $scode?></td>
						<td width="25%"><?php echo $sname?></td>
						<td width="40%">
							<input  type="text" style="width:50px;" name="<?php echo $presence?>"/>
						</td>
					</tr>		
							
					<?php	  }  
					
							echo'
								<script>
									document.getElementById("cbox").value = "'.$chosenClass2.'";
								</script>
								';					
						}	
							
							if(isset($_POST['saveatt'])){
								$rdate = $_POST["chosenDate"];
								for($j=1;$j<=$rowCount;$j++){
								
									$ssd = $_POST['ssid'.$j.''];
									$sscore = $_POST['presence'.$j.''];
									
									if($sscore == ''){
										echo '<script language="javascript">';
										echo 'alert("Open your f**king eyes there are empty fields!")';
										echo '</script>';
									}else{
										$cquery = "select score from classattendance where student_id = '$ssd' and date = '$rdate' and teacher_id = '$tid'";
										$run1 = mysqli_query($conn,$cquery);
										$count = mysqli_num_rows($run1);
										
										if($count != 0){
											echo '<center><h1>Attendance already inserted for student with ID'.$ssd.'</h1></center>';
										}elseif($count == 0){
											
											$insert_query = "insert into attendance
										    (student_id,score,date,teacher_id)
											values
											('$ssd','$sscore','$rdate','$tid')";	
											
											if(mysqli_query($conn,$insert_query)){
												echo '<center><h1>Successfully Inserted!</h1></center>';
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
				
   

  
<div id="footer">

    </div>

</div>

</body>
</html>