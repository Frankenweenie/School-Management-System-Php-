<?php
session_start();
if(!isset($_SESSION['user_name'])){
    header("location: login.php");
} else {
}
?>
<html>
  <head>
  
    <title>Welcome</title>
	<link rel="stylesheet" href="css/index-style.css" >
	 <script src="js/jquery-2.1.4.min.js"></script>	  
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  </head>
  <body>
	<script>
		$(function() {
			$("#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
		});
	</script>
  
  
	<?php include('includes/header.php')?>
    <?php include('includes/sidebar.php')?>
	
<script>

</script>

<div id="main">

	<form method="post">
	<a id="att_table_title">Today: <?php echo date("l, Y-m-d"); ?></a>
	
	<div id="att_frame">
        <div id="att_title"><a>Insert Activity</a></div>
		<div id="att_content"></div>
    </div>

    <div id="currentDate" class="input">
        <a>Select Date</a><br>
        <input name ="datee" type="textfield" id="datepicker" value="<?php  echo date ("Y-m-d") ?>" />
    </div>

    <div id="selectClass" class="input">
        <a>Select Class</a><br>
        <select id="class_choose" name="class_choose">
		<option>select class</option>
		
        <?php 		
		include("includes/connect.php");
		$sql="select classname from class"; 
		$result = mysqli_query($conn,$sql);
		$chosenDate = $_POST['datee'];
		$class = $_POST['class_choose'];
		
		$i=0;
		
		while($row=mysqli_fetch_array($result,MYSQL_ASSOC)){
			
			$i++;
			
			echo '<option name="class_'.$i.'">'.$row["classname"].'</option>';
		}				
		?>	
		
        </select>
		<input name="dateconfirm" type="submit" id="dateconfirm" value="Confirm"/>
			<?php
				if(isset($_POST['dateconfirm'])){
					
					$chosenDate = $_POST['datee'];
					$class = $_POST['class_choose'];
					?>
					<script>
					document.getElementById('class_choose').value = '<?php echo $class?>';
					document.getElementById('datepicker').value = '<?php echo $chosenDate?>'; 
					</script>
			<?php		
				}
			?>
    </div>
	
	<div id="att_table">
	
	<table id="att_table">
	<tr>
		
		<th>ID</th>
		<th>Student Code</th>
		<th>Student Name</th>
		<th>Student Score</th>
		
	</tr>
	<?php
	
	
	
	
	$sql = "SELECT student.student_id, student.code, student.firstname, score_acitivty.score, score_acitivty.date, class.classname from student 
	join 
	teacherclass on student.teacherclass_id = teacherclass.teacherclass_id left outer 
	join score_acitivty on score_acitivty.student_id= student.student_id and score_acitivty.date = '".$chosenDate."'  join class on class.class_id = teacherclass.class_id and class.classname = '".$class."'";
    $result = mysqli_query($conn,$sql);
	$i=1;
	while($row = mysqli_fetch_array($result)){
		
		$sid = $row['student_id'];
		$scode = $row['code'];
		$sname = $row['firstname'];
		$sscore = $row['score'];
		$sidname = 'sid'.$i.'';
		$scodename = 'scode'.$i.'';
		$snamename = 'sname'.$i.'';
		$sscorename = 'sscore'.$i.'';
		$sscoreid = 'sscoreid'.$i.'';
		$i++;
	?>
		<tr>
			<td><input type="text" style="border:none;" readonly="readonly" name = "<?php echo $sidname?>" value="<?php echo $sid?>" ></td>
			<td><input type="text" style="border:none;" readonly="readonly" name = "<?php echo $scodename?>"  value="<?php echo $scode?>"></td>
			<td><input type="text"  style="border:none;" readonly="readonly" name = "<?php echo $snamename?>" value="<?php echo $sname?>"></td>
			<td><input id="<?php echo $sscoreid?>" style="border:none;text-align:center;" name = "<?php echo $sscorename?>" value = "<?php echo $sscore?>"></td>
		</tr>
		<?php
		
	}
		?>
		<tr>
		    <td>
				<button id="btn2" name="btn2">Save Activity</button>
		    </td>
	    </tr>
		
		<?php 
			$rowCount = mysqli_num_rows($result);
			
	
				
			if(isset($_POST['btn2'])){
				
				for($j=1;$j<=$rowCount;$j++){		
		
					$ssidname = $_POST['sid'.$j.''];
					$sscodename = $_POST['scode'.$j.''];
					$ssnamename = $_POST['sname'.$j.''];
					$ssscorename = $_POST['sscore'.$j.''];
					$ssscoreid = 'sscoreid'.$j.'';
					
			
					$query = "insert into score_acitivty values('$ssidname','$ssscorename','$chosenDate','1')";
				
				
				    $result = mysqli_query($conn, $query);					
				
				?>
				<script>
					document.getElementById('class_choose').value = '<?php echo $class?>';
					document.getElementById('datepicker').value = '<?php echo $chosenDate?>'; 
					document.getElementById('<?php echo $ssscoreid?>').value = '<?php echo $ssscorename?>'; 	
			    </script>
				<?php
			}}
		?>
	</table>

	</div>
	</form>
  </div>
  <div id="footer">
  </div>
 </body>
</html>
    

