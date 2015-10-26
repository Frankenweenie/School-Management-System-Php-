<?php
session_start();
if(!isset($_SESSION['user_name'])){
    header("location: login.php");
} else {

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
			<div id="event_title1" class="event_title_text" onclick="tab1()"><a>View Event</a></div>
			<div id="event_title2" class="event_title_text" onclick="tab2()"><a>Insert Event</a></div>
			<div id="event_title3" class="event_title_text" onclick="tab3()"><a>Edit Event</a></div>
		</div>
		<div id="zai"></div>
		<div id="event_content">
			
				<div id="tab1">
				
					<table>
						<tr id="event_td" style="border-top:#cfcfcf 1px solid;border-bottom:#cfcfcf 1px solid;height:40px;">
							<th>Event ID</th><th>Event Title</th><th>Event Content</th><th>Image</th>
						</tr>
						<?php
						include("includes/connect.php");
						
						$query = "select * from event order by 1 DESC";
						$run = mysqli_query($conn,$query);
						while($row=mysqli_fetch_array($run)){
							$event_id = $row['id'];
							$event_title = $row['title'];
							$event_content = $row['content'];
							$event_img = $row['img'];
						
						?>
						
						<tr>
							<td id="event_td1"><?php echo $event_id;?></td>
							<td id="event_td2"><?php echo $event_title;?></td>
							<td id="event_td3"><?php echo $event_content;?></td>
							<td id="event_td4"><?php echo $event_img;?></td>
						</tr>
						
						<?php } ?>
					</table>
				</div>
				
				<div id="tab2">
				<div id="zai"></div>
					<form align="center" method="post" action="event.php" enctype="multipart/form-data">
						<table>
							<tr>
								<td style="border-top:#cfcfcf 1px solid;border-bottom:#cfcfcf 1px solid;height:40px;height:80px;"><a>Event Title:</a></td>
								<td style="border-top:#cfcfcf 1px solid;border-bottom:#cfcfcf 1px solid;height:40px;"><input name="ititle" type="textfield"></input></td>
							</tr>
							<tr>
								<td><a>Event Content:</a></td>
								<td><textarea id="ta" onclick="enlarge()" name="icontent"></textarea></td>
							</tr>
							<tr>
								<td><a>Event Image:</a></td>
								<td>
									<div id="btnframe">
									<button id="btnf">Insert Image</button>
									<input id="btn"  onmouseover="btnresponse()" onmouseout="btnresponseback()" type="file" name="iimage" value="Insert Image"></input>
									
									</div>
								</td>
							</tr>
						</table>
						<input id="btn3" type="submit" name="btn" value="Insert Event/Post"/>
					</form>
					
				<?php
					/*include("includes/connect.php");*/
					if(isset($_POST['btn'])){
						$event_title1 = $_POST['ititle'];
						$event_content1 = $_POST['icontent'];
						$event_img1 = $_FILES['iimage']['name'];
						$tmp_img = $_FILES['iimage']['tmp_name'];
						
						if($event_img1==''){
							$event_img1 = '5.jpg';
						}	
						if($event_title1=='' or $event_content1==''){
							echo "<script>alert('any of the fields is empty')</script>";
							
						}
						else {
						move_uploaded_file($tmp_img,"nfimgs/$event_img1");
						
						$insert_query = "insert into event
						(title,content,img)
						values
						('$event_title1','$event_content1','$event_img1')";
						
							if(mysqli_query($conn,$insert_query)){
								echo "<center><h1>Event inserted successfully</h1></center>";
								echo "<script>window.open('event.php','_self')</script>";
								
							}
						}
					}
	}
				?>	
				
				</div>
<!*************************************************TAB***3***********************************************->			
				<div id="tab3">
					<table>
						<tr id="event_td" style="border-top:#cfcfcf 1px solid;border-bottom:#cfcfcf 1px solid;height:40px;">
							<th>Event ID</th><th>Event Title</th><th>Event Content</th><th>Image</th><th>Button</th>
						</tr>
					<form method="post" enctype="multipart/form-data">
						<?php
						include("includes/connect.php");
						
						$query = "select * from event order by 1 DESC";
						$run = mysqli_query($conn,$query);
						$i=0;
						while($row=mysqli_fetch_array($run)){
							$i++;
							$event_id = $row['id'];
							$event_title = $row['title'];
							$event_content = $row['content'];
							$event_img = $row['img'];
							
							$eid = "eid".$i."" ;
							$etitle = "etitle".$i."" ;
							$econtent = "econtent".$i."" ;
							$eimg = "eimg".$i."";
							$eeimg = "eeimg".$i."";
							$edtbtn = "ebtn".$i."" ;
							$chgimg = "chgimg".$i."()" ;
							$fakebtn = "fakebtn".$i."" ;
						
						
						echo'
						<tr>
							<td id="event_td1"><input    name="'.$eid.'"      id="etd1" type="textfield" value="'.$event_id.'"></input></td>
							<td id="event_td2"><input    name="'.$etitle.'"   id="etd2" type="textfield" value="'.$event_title.'"></input></td>
							<td id="event_td3"><input    name="'.$econtent.'" id="eta"  type="textfield" value="'.$event_content.'"></textarea></td>
							<td id="event_td4">
								<div id="'.$fakebtn.'" class="fakebtn"><a>Change Image</a></div>
								<input id="'.$eimg.'" name="'.$eimg.'"  onclick="'.$chgimg.'"   class="etd4" type="file">
								<a style="display:none;">'.$event_img.'</a>
							</td>
							<td><input id="ebtn" style="height:40px;" type="submit" onclick="" name="'.$edtbtn.'" value="Save" onclick="sout()"/></td>
						</tr>
						
						
						';
					
					
				
				
					echo $eid;
					echo $econtent;
					
					if(isset($_POST[$edtbtn])){
						$edit_id = $_POST[$eid];
						$edit_title = $_POST[$etitle];
						$edit_content = $_POST[$econtent];
						$edit_img = $_FILES[$eimg]['name'];
						$tmp_img = $_FILES[$eimg]['tmp_name'];
					
					
						if($edit_title ==''){
						echo "<script>alert('Any of the field is empty')</script>";
						}else{
							move_uploaded_file($tmp_img,"nfimgs/$edit_img");
							$edit_query = "update event set title='".$edit_title."', content='".$edit_content."',img = '".$edit_img."'
							where id='".$edit_id."'";
							
							if(mysqli_query($conn,$edit_query)){
								echo "Мэдээлэл өөрчлөгдлөө";
								echo "<script>window.open('event.php','_self')</script>";
				
							}else{
								echo "Something Wrong!!!!";
								
							}
						}
					}
			 } ?>
				</table>
				</form>
				</div>
		</div>
	</div>



  

</body>
<script>
function sout(){
	document.getElementById('eta').innerHTML = 'Hello JavaScript!';
	
}

function btnresponse(){
	var btnf = document.getElementById('btnf');
	btnf.style.transition ="0.3s";
	btnf.style.background ="white";
	btnf.style.color ="#3399cc";
	btnf.style.border ="#3399cc 1px solid";
	
}
function btnresponseback(){
	var btnf = document.getElementById('btnf');
	btnf.style.background ="#3399cc";
	btnf.style.color ="white";
	btnf.style.border ="none";
	btnf.style.transition ="0.3s";
}
function tab1(){
	
	var eta = document.getElementById('eta');
	eta.style.transition ="0s";
	var ebtn = document.getElementById('ebtn');
	ebtn.style.transition ="0s";
	var btnf = document.getElementById('btnf');
	btnf.style.transition ="0s";
	var btn3 = document.getElementById('btn3');
	btn3.style.transition ="0s";
		
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
	
	var ta = document.getElementById('ta');
	ta.style.transition = "0s";
		
	}
	

function tab2(){
	
	var eta = document.getElementById('eta');
	eta.style.transition ="0s";
	var ebtn = document.getElementById('ebtn');
	ebtn.style.transition ="0s";
	var btn3 = document.getElementById('btn3');
	btn3.style.transition ="0s";
	var btnf = document.getElementById('btnf');
	btnf.style.transition ="0s";
	
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
	
	var ta = document.getElementById('ta');
	ta.style.transition = "0s";
		
	}
	
	function tab3(){
	
	var eta = document.getElementById('eta');
	eta.style.transition ="0s";
	var ebtn = document.getElementById('ebtn');
	ebtn.style.transition ="0s";
	var btn3 = document.getElementById('btn3');
	btn3.style.transition ="0s";
	var btnf = document.getElementById('btnf');
	btnf.style.transition ="0s";
	
	var ta = document.getElementById('ta');
	ta.style.transition = "0s";
		
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
	
function enlarge(){
	var ta = document.getElementById('ta');
		
		ta.style.transition = "0.3s";
		ta.style.height = "300px";
	
}
	
	
</script>		
</html>