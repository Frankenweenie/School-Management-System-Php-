<?php
session_start();
if(!isset($_SESSION['user_name'])){
    header("location: login.php");
} else {
}
?>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Welcome</title>
	<link rel="stylesheet" href="css/index-style.css" >
  </head>
  <body>
  
  <?php include('includes/header.php')?>
  <?php include('includes/sidebar.php')?>
  
	<div id="main">
		<div id="att_frame">
			<div id="att_title"><a>Home</a></div>
			<div id="att_content"></div>
		</div>
		<div id="zai"></div>
		<?php 
		include('includes/connect.php');
		
		$select_posts = "select * from event order by 1 DESC LIMIT 0,3";
		$run_posts = mysqli_query($conn,$select_posts);
		
		while($row=mysqli_fetch_array($run_posts)){
			$event_id = $row['id'];
			$event_title = $row['title'];
			$event_content = $row['content'];
			$event_img = $row['img'];
		
		
		?>
		
		<div id = "event">
			<h2 class="event_title">
				<a><?php echo $event_title; ?></a>
			</h2>

			<center><img id="event_img" src="nfimgs/<?php echo $event_img;?>" width= "450" height="300" /></center>

			<p class="event_content" align="justify"><?php echo $event_content; ?></p>  
		</div>
		<?php } ?>

    </div>



  

</body>
</html>