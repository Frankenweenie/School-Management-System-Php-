
<div class="container">
    <div id="sidebar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="event.php">Events</a></li>
            <li id="parentmenu" onclick="dropdown()"><a>Attendance</a></li>
				<li id="submenu1"><a href="attendance.php">Check Attendance</a></li>
				<li id="submenu2"><a href="attMark.php">View Attendance</a></li>
				<li id="submenu3"><a href="editAttMark.php">Edit Attendance</a></li>
				<li id="submenu4"><a onclick="showG()" href="graphTest.php">Overview Attendance</a></li>
				
            <li><a href="student.php">Student</a></li>
            <li><a href="class.php">Class Routine</a></li>
            <li><a href="teacher.php">Teachers</a></li>
            
				
		
		    <li id="actprt" onclick="dropdown2()"><a href="#" id="activity">Activity</a></li>
				<li id="actsub1"><a href="veditactivity.php" id="veditactivity">View/Edit Activity mark</a></li>
				<li id="actsub2"><a href="insertActivity.php" id="insertactivity">Insert Activity mark</a></li>
			
			
             <li id="epm" onclick="dropdown1()"><a href="#">Exam mark</a></li>
				<li id="esm1"><a href="exam.php">View Exam mark</a></li>
				<li id="esm2"> <a href="insert_exam.php">Insert Exam mark</a></li>
				<li id="esm3"><a href="edit_exam.php">Edit Exam mark</a></li>
				<li id="esm4"><a href="report_exam.php">Report Exam</a></li>
				
            <li><a href="homework.php">Homework mark</a></li>
			 <li><a href="report_homework.php">Report</a></li>
			
			<li><a href="totalov.php">Total Overview</a></li>
			
            <li><a href="logout.php">Sign Out</a></li>
        </ul>
    </div>
</div>
<?php include('js/javas.php')?>