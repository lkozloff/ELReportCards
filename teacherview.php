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
			 $('.student').editable('save.php', { 
			     data   : "<?php print($rp->getEnrolledStudentsSchema());?>",
			     type   : 'select',
			     submit : 'OK',
			   	 callback : function(value, settings) {
			  	 	window.location.reload();
			     }
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
	print("<div id = \"nav\">");
	print("<h1><a href =\"#\" class = \"expander\">".$rp->getGrade()." - ".$rp->getTeacherName()."</a></h1>");
	print("<div class = \"content\">\n");
	foreach($students as $studentid=>$student){

		//break if we get to the 'selected' entry
		$collate = explode(".",$studentid);
		if(strcmp($collate[0],"selected")==0) break;
		
		//otherwise pull the SID
		$sid = $collate[1];
		
		$data = intval($rp->hasData($sid));
			if      ($data>=20){ $color = "white";}
			else if ($data>=10 && $data<20){ $color = "orange";}
			else if ($data<10) { $color = "red";}
			else 				{ $color = "brown";}

		
		print("<strong style =\"color:$color;\">$student - ");
		print($data."</strong><br/>");
	}
	print("<a href =\"index.php\">- choose another template -</a></div></div>");
	$rp->toHTML();
?>
