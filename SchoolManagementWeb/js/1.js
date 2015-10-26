<script>	
	function dropdown(){
		var sb1 = document.getElementById('submenu1');
		var sb2 = document.getElementById('submenu2');		
		var sb3 = document.getElementById('submenu3');	
		var sb4 = document.getElementById('submenu4');	
		
		sb1.style.height = '49px';
		sb1.style.visibility = 'visible';
		sb1.style.transition = '0.3s';
		
		sb2.style.height = '49px';
		sb2.style.visibility = 'visible';
		sb2.style.transition = '0.3s';
		
		sb3.style.height = '49px';
		sb3.style.visibility = 'visible';
		sb3.style.transition = '0.3s';
		
		sb4.style.height = '49px';
		sb4.style.visibility = 'visible';
		sb4.style.transition = '0.3s';
	}
	function showG(){
	var x<?php echo $i?> = document.getElementById('<?php echo $tagid?>');
	x<?php echo $i?>.style.width = '0';
	x<?php echo $i?>.style.transition = '1s';
	x<?php echo $i?>.style.transitionDelay = '1s';
	x<?php echo $i?>.style.width = '<?php echo $sscore/$mustscore*100,'%'?>';
	}
</script>

	
		
		
	
							