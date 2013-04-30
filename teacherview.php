<?php
	session_start();
	include("ReportCard.php");
	
	//pull in the default values if we don't already have them
	if(!isset($_REQUEST['syear']))
		$syear = 2012;
	else
		$syear = $_REQUEST['syear'];
	
	if(isset($_REQUEST['sid'])){
		$collate = explode(".",$_REQUEST['sid']);
		$sid = $collate[1];
		
		$_SESSION['sid'] = $_REQUEST['sid'];
	}
	else if(isset($_SESSION['sid'])){
		//hack to make list alphabetized: needs to be stripped from what's actually there.  (Surname, Firstname.SID)
		$collate = explode(".",$_SESSION['sid']);
		$sid = $collate[1];
	}	
	else{
		$sid = null;
	}
	
	//are we sending from a form? or have we already gotten a teacher?
	if(!isset($_REQUEST['teacher_id']))
		if(isset($_SESSION['teacher_id'])) $teacher_id = $_SESSION['teacher_id'];
	else $teacher_id = "No Teacher set!";
	else{
		$teacher_id = $_REQUEST['teacher_id'];
		$_SESSION['teacher_id'] = $teacher_id;
	}
	
	if(!isset($_REQUEST['teacher_kh_id']))
		if(isset($_SESSION['teacher_kh_id'])) $teacher_kh_id = $_SESSION['teacher_kh_id'];
	else $teacher_kh_id = "No Teacher set!";
	else{
		$teacher_kh_id = $_REQUEST['teacher_kh_id'];
		$_SESSION['teacher_kh_id'] = $teacher_kh_id;
	}
	//same for the template id
	if(!isset($_REQUEST['template_id']))
		if(isset($_SESSION['template_id'])) $template_id = $_SESSION['template_id'];
	else $template_id = 1;
	else{
		$template_id = $_REQUEST['template_id'];
		$_SESSION['template_id'] = $template_id;
	}
	
	$rp = new ReportCard($syear,$sid,$template_id,$teacher_id, $teacher_kh_id);
	?>
	<html>
	<head><meta charset="UTF-8" />
		<link rel = "stylesheet" type="text/css" href="style_print.css" media ="print"/>
		<link rel = "stylesheet" type="text/css" href="style_web.css" media="screen"/>
		<script src="js/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/simple-expand.min.js" type="text/javascript" charset="utf-8"></script>
		
		<script type="text/javascript">
		 $(document).ready(function() {
			 $('.expander').simpleexpand();
			 
			 $('.editGrade').editable('save.php', { 
			     data   : "<?php print($rp->getGradeSchema());?>",
			     type   : 'select',
				 onblur : 'submit',
			     //submit : 'OK'
				     
			 });
			 $('.editEffort').editable('save.php', { 
				 data   : "<?php print($rp->getEffortSchema());?>",
			     type   : 'select',
			     onblur : 'submit',
			     //submit : 'OK'
			 });
		     $('.commentblock').editable('save.php', { 
		         type      : 'textarea',
		         //cancel    : 'Cancel',
		         //submit    : 'OK',
		         onblur : 'submit',
		         indicator : '<img src="img/indicator.gif">',
		         placeholder   : '',
		         callback : function(value, settings) {
					  	 	window.location.reload();
				 }
		     });
		 });
		 </script>
	</head><body>
	<?php 
	$students = $rp->getEnrolledStudents();
	$count = 0;
	$data_total = 0;
	
	print("<div id = \"nav\">");
	print("<h1><a href =\"#\" class = \"expander\">".$rp->getGrade()." - ".$rp->getTeacherName()."</a></h1>");
	print("<div class = \"content\">\n<table>");
	print("<tr><td>Name</td><td>Estimated Completion</td>");
	foreach($students as $studentid=>$student){

		//break if we get to the 'selected' entry
		$collate = explode(".",$studentid);
		if(strcmp($collate[0],"selected")==0) break;
		
		//otherwise pull the SID
		$tempsid = $collate[1];
		
		$data = intval($rp->hasData($tempsid));
			if      ($data>=75){ $color = "white";}
			else if ($data>=50 && $data<75){ $color = "orange";}
			else if ($data<50) { $color = "rgb(255,128,128)";}
			else 				{ $color = "brown";}
		
		
		print("<tr><td><a href = \"teacherview.php?sid=$student.$tempsid\" style =\"color:$color;\">$student</a></td>");
		print("<td style = \"color: $color\">".$data."%</a></td>");
		
		$count++;
		$data_total += $data;
	}
	print("<tr><td><strong>Total Completion:</strong></td><td><strong>".(intval($data_total/$count))."%</strong></td></tr>");
	print("</table><a href =\"index.php\">- choose another template -</a></div></div>");
	$rp->toHTML();
?>
