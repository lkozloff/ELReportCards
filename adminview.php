<?php
	session_start();
	include("ReportCard.php");
	
	//pull in the default values if we don't already have them
	if(!isset($_REQUEST['syear']))
		$syear = 2012;
	else
		$syear = $_REQUEST['syear'];
	
	if(!isset($_SESSION['sid']))
		$sid = null;
	else{
		//hack to make list alphabetized: needs to be stripped from what's actually there.  (Surname, Firstname.SID)
		$collate = explode(".",$_SESSION['sid']);
		$sid = $collate[1];
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
		<link rel = "stylesheet" type="text/css" href="style_web.css" media="screen"/>
		<link rel = "stylesheet" type="text/css" href="style_print.css" media ="print"/>
		<script src="js/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/simple-expand.min.js" type="text/javascript" charset="utf-8"></script>
		
		<script type="text/javascript">
			$(function () {
	            $('.expander').simpleexpand();
	        });
			
		 </script>
	</head><body>
	<?php 
	$students = $rp->getEnrolledStudents();
	print("<div id = \"nav\">");
	print("<h1><a href =\"#\" class = \"expander\">".$rp->getGrade()."</a></h1>");
	print("<div class = \"content\">\n");
	foreach($students as $studentid=>$student){
		$collate = explode(".",$studentid);
		if(strcmp($collate[0],"selected")==0) break;
		$sid = $collate[1];
		print("<a href = \"#$sid\">$student</a><br/>\n");
	}
	print("</div></div>");
	
	foreach($students as $studentid=>$student){
		
		
		$collate = explode(".",$studentid);
		if(strcmp($collate[0],"selected")==0) break;
		$sid = $collate[1];
		print("<a name = \"$sid\"></a>");
		$rp = new ReportCard($syear,$sid,$template_id,$teacher_id, $teacher_kh_id);
		$rp->toHTML();
		?>
				<div style ="page-break-after: always;"></div>	
		<?php 
	}
?>
