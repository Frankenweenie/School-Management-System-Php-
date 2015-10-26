<?php
include('includes/connect.php');
	$tUserName = $_SESSION['user_name'];
	$queryFndTid = "select * from teacher where username = '$tUserName';";
	$fndTid = mysqli_query($conn,$queryFndTid);
	$tid = '';
	$tname = '';
	$stype =  '';
	if($res = mysqli_fetch_array($fndTid)){
		$tid = $res['teacher_id'];
		$tname = $res['firstname'];
		$stype = $res['subject_type'];
	}

?>

<div id = "header">

      <img id="logo3" src="img/logo3.png" width="60px"/>
      <a id="a1">School Management System</a>
      <div id="user">
          <img id="hangai" height="40px"  src="<?php
		
		if($stype = 'Java'){
			echo 'img/jlogo.png';
		}elseif($stype= 'c#'){
			echo 'img/clogo.png';
		}elseif($stype= 'korean'){
			echo 'img/klogo.png';
		}else{
			echo 'img/clogo.png';
		}
		
	  ?>" width="40px"/>
          <a id="a2"><?php echo $tname,'-';if($stype = 'java'){
			echo 'Java';
		}elseif($stype= 'c#'){
			echo 'C#';
		}elseif($stype= 'korean'){
			echo 'Korean Language';
		}else{
			echo 'Who the hell are you?!?';
		}?></a>
      </div>
</div>
 


