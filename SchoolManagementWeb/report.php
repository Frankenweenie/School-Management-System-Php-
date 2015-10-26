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

  
	<?php include('includes/header.php')?>
    <?php include('includes/sidebar.php')?>
	
<script>

</script>

<div id="main">

	<form method="post">
	<a id="att_table_title">Today: <?php echo date("l, Y-m-d"); ?></a>
	
	<div id="att_frame">
        <div id="att_title"><a>View Activity</a></div>
		<div id="att_content"></div>
    </div>

    <div id="currentDate" class="input">
       <a>Select Month</a><br>
	   <select id="class_choose" name="month_choose">
	   <option>January</option>
	   <option>February</option>
	   </select>
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
		<th>Must score</th>
		<th>Had score </th>
		<th>Sum score 30</th>
		
	</tr>
	<?php
	
	$sql = "SELECT * , count(distinct date)*5 as avah_onoo , sum(score) as avsan_onoo ,
	((sum(score)*30))/(count(distinct date)*5) as avsan_dundaj from `v_activity` WHERE classname = '".$class."' group by student_id";
	
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
		$avah = $row['avah_onoo'];
		$avsan = $row['avsan_onoo'];
		$avsan_dundaj = $row['avsan_dundaj'];	
		$avahname = 'avahname'.$i.'';
		$avsanname = 'avsanname'.$i.'';
		$i++;
		
	?>
		<tr>
			<td><input type="text" style="border:none;" readonly="readonly" name = "<?php echo $sidname?>" value="<?php echo $sid?>" ></td>
			<td><input type="text" style="border:none;" readonly="readonly" name = "<?php echo $scodename?>"  value="<?php echo $scode?>"></td>
			<td><input type="text"  style="border:none;" readonly="readonly" name = "<?php echo $snamename?>" value="<?php echo $sname?>"></td>
			<td><input type="text" style="border:none;" readonly="readonly" name = "<?php echo $avahname?>"  value="<?php echo $avah?>"></td>
			<td><input type="text"  style="border:none;" readonly="readonly" name = "<?php echo $avsanname?>" value="<?php echo $avsan?>"></td>
			<td><input type="text"  style="border:none;" readonly="readonly" name = "<?php echo $avsanname?>" value="<?php echo $avsan_dundaj?>"></td>
		
		</tr>
		<?php
		
	}
		?>
		<tr>
		    <td>
				<button id="btn2" name="btn2">Save Activity</button>
		    </td>
	    </tr>
		
	</table>

	</div>
	</form>
  </div>
  <div id="footer">
  </div>
 </body>
</html>
    

