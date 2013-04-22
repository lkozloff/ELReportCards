<?php 

/**
 *  We're expecting these to come in somehow. Probably a previous form? In OpenSIS maybe through session variables?
 *	$teacher
 *	$template_id
 **/

session_start();
//connect to DBs
$dbh = new PDO('mysql:host=localhost;dbname=test', "root", "mysqldrowssaP");
$sdbh = new PDO('mysql:host=localhost;dbname=opensis_lisah', "root", "mysqldrowssaP");

//make sure Khmer will come through
$dbh->query('SET NAMES utf8');

//variables and defaults
$teacher_kh = "Thida Sor";

$syear; //current school year
$sid; //selected student's id
$teacher; //teacher's name
$template_id; //template id

//total school days by semester
$sdays1; 
$sdays2; 

//days absent/tardy by semester
$da1; 
$da2; 
$dt1; 
$dt2; 

$comment1; 
$comment2;
$comment3;
$comment4;

//Date the report card was generated
$date = date("d M Y",time());

//pull in the default values if we don't already have them
if(!isset($_REQUEST['syear']))
	$syear = 2012;
else
	$syear = $_REQUEST['syear'];

if(!isset($_SESSION['sid']))
	$sid = null;
else
	$sid = $_SESSION['sid'];

//are we sending from a form? or have we already gotten a teacher?
if(!isset($_REQUEST['teacher']))
	if(isset($_SESSION['teacher'])) $teacher = $_SESSION['teacher'];
	else $teacher = "No Teacher set!";
else{
	$teacher = $_REQUEST['teacher'];
	$_SESSION['teacher'] = $teacher;
}
//same for the template id
if(!isset($_REQUEST['template_id']))
	if(isset($_SESSION['template_id'])) $template_id = $_SESSION['template_id'];
else $template_id = 1;
else{
	$template_id = $_REQUEST['template_id'];
	$_SESSION['template_id'] = $template_id;
}

//print("Current SID:$sid");

//prepare the selected students name
if($sid!=null){
	$query = $sdbh->prepare("SELECT first_name, last_name from students where student_id = '$sid'");
	$query->execute();
	$students_result = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($students_result as $val){
		$sname = $val['last_name'].", ".$val['first_name'];
	}
}
else $sname = "No Student Selected!";

//make sure all our importnat stuff is loaded into the session
$_SESSION['sid'] = $sid;
$_SESSION['syear'] = $syear;
$_SESSION['template_id'] = $template_id;
$_SESSION['teacher'] = $teacher;

//Pull the grade name from the template ID and store it in the session
$sql = "SELECT * from templates WHERE template_id = '$template_id'";
$query = $dbh->prepare($sql);
$query->execute();
$template = $query->fetch();
$_SESSION['grade'] = $template['template_name'];

//and keep it available for later use
$grade = $_SESSION['grade'];

$students = getEnrolledStudents($sdbh, $syear,$grade, $sname);

//calculate number of days in semester - Ugly to break up into helper functions.
$sdays = array();
$da = array();
$dt = array();

//where do s1 and s2 begin? (will have to re-evaluate for a Logos version where we go by quarter(?))
$query = $sdbh->prepare("SELECT * FROM marking_periods where school_id=2 AND syear = $syear AND parent_id >0");
$query->execute();
$mp_result = $query->fetchAll(PDO::FETCH_ASSOC);
$i = 1;
//this runs once per marking period - 
foreach($mp_result as $val){
	$sdate = $val['start_date'];
	$edate = $val['end_date'];
	if(strtotime($edate) > time()){
		$edate = date("Y-m-d",strtotime("Yesterday")); //don't want to account for today
	}
	//get total number of days per marking period - this excludes holidays, as we would want
	$q = $sdbh->prepare("SELECT COUNT(*) as count from attendance_calendar where syear=$syear AND school_id=2 AND school_date>='"
				.$sdate."' AND school_date<='".$edate."'");
	$q->execute();
	$res = $q->fetch();
	
	//get total number of days present for selected student by
	$qda = $sdbh->prepare("
						SELECT count(attendance_period.school_date) as count from attendance_period,
						(SELECT id from attendance_codes where syear=$syear AND school_id =2 AND title LIKE \"present\") as present_id
						WHERE
						attendance_period.attendance_code = present_id.id AND student_id = $sid AND school_date>='"
				.$sdate."' AND school_date<='".$edate."'");
	$qda->execute();
	$dares = $qda->fetch();
	
	//get total number of days tardy
	$qdt = $sdbh->prepare("
						SELECT count(attendance_period.school_date) as count from attendance_period,
						(SELECT id from attendance_codes where syear=$syear AND school_id =2 AND title LIKE \"late\") as late_id
						WHERE
						attendance_period.attendance_code = late_id.id AND student_id = $sid AND school_date>='"
				.$sdate."' AND school_date<='".$edate."'");
	$qdt->execute();
	$dtres = $qdt->fetch();

	//load them up
	$sdays[$i] = $res['count'];
	$da[$i] = $dares['count'];
	$dt[$i] = $dtres['count'];
	$i++;
}

$sdays1 = $sdays['1'];
$sdays2 = $sdays['2'];

//tardies are tardies!
$dt1 = $dt['1'];
$dt2 = $dt['2'];
//days absent are the total days - days present - days tardy (that is: all attendance codes that aren't 'present' or 'late') 
$da1 = $sdays['1'] - $da['1'] - $dt1;
$da2 = $sdays['2'] - $da['2'] - $dt2;

?>
<html>
	<head><meta charset="UTF-8" />
		<link rel = "stylesheet" type="text/css" href="styles_test.css" media ="print"/>
		<link rel = "stylesheet" type="text/css" href="styles_test.css"/>
		<script src="js/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
		 $(document).ready(function() {
			 $('.editGrade').editable('save.php', { 
			     data   : " {'4':'4','3':'3','2':'2','1':'1','NA':'NA','.':'UG', 'selected':'4'}",
			     type   : 'select',
			     submit : 'OK'
				     
			 });
			 $('.editEffort').editable('save.php', { 
			     data   : " {'E':'E','G':'G','S':'S','N':'N','U':'U','NA':'NA','.':'UG', 'selected':'E'}",
			     type   : 'select',
			     submit : 'OK'
			 });
			 $('.student').editable('save.php', { 
			     data   : "<?php print(str_replace("\"","'",json_encode($students)));?>",
			     type   : 'select',
			     submit : 'OK',
			   	 callback : function(value, settings) {
			  	 	window.location.reload();
			     }
			 });
		     $('.commentblock').editable('save.php', { 
		         type      : 'textarea',
		         cancel    : 'Cancel',
		         submit    : 'OK',
		         indicator : '<img src="img/indicator.gif">',
		         tooltip   : 'Click to edit...'
		     });
		 });
		 </script>
	</head>
<?php
/*************************************************************
 * 			FINALLY! - The Main Layout! - FINALLY!
 *************************************************************/

	print("<table style = \"width: 90%;\"><tr>");	
	
		//Print the comments on the left hand side
		print("<td class = \"noborder\" align = \"left\">");
			printComments($dbh, $template_id, $sid);
		print("</td>");
		
		//Print the title on the right hand side
		print("<td class = \"noborder\" align = \"right\">");
			printTitle($sname, $grade, $teacher, $teacher_kh, $date, $sdays1, $sdays2, $da1, $da2, $dt1, $dt2);
		print("</td>");
	print("</tr></table>");
	?>
<!-- --------------------------------------------Break Here-------------------------------------------------------------------------------------- -->	
<div style ="page-break-before: always;"></div>	
<!-- --------------------------------------------Break Here-------------------------------------------------------------------------------------- -->
	
	<?php 
	
	print("<table style = \"width: 90%;\"><tr>");
	//left page grades
	print("<td class = \"noborder\" align = \"left\">");
	
	
		print("<table class = \"outline\">");
		
		printHeader();
		$HEIGHTLIMIT =  17; // not fitting right? adjust this.
		$topic_id = 0;
		foreach($dbh->query("SELECT * from template_fields WHERE template_id='$template_id' ORDER BY topic_id") as $row) {
			
			//does this happen? Move on to the right side
			if($topic_id==$HEIGHTLIMIT){
				print("</table><br><br><br></td>"); //these breaks move the left table up in line with the right, may have to change
				print("<td class = \"noborder\" align = \"right\"><table class = \"outline\">");
				printHeader();
			}
			
			printRow($dbh,$row,$template_id,$sid,$topic_id);
			$topic_id++;
		}
	
		print("</table>");
		printKey();
		print("</td>");
	print("</tr></table>");
	
	/*************************************************************
	 * 			FINALLY! - The Main Layout is Done!! - FINALLY!
	*************************************************************/
	
?>
</html>
<?php 
//close up connections
$dbh = null;
$sdbh = null;
/*****************************
 ***** Helper Functions ******
 *****************************/
//who is enrolled? returns an array with the currently selected student marked as such
function getEnrolledStudents($sdbh,$syear, $grade, $sname){
	//grab student names to populate list
	$query = $sdbh->prepare("SELECT
			enrolled_students.sid,
			enrolled_students.fname,
			enrolled_students.sname,
			Grade.grade
	
			FROM
	
			(SELECT students.first_name as fname, students.last_name as sname, students.student_id as sid, students.birthdate as DOB, student_enrollment.grade_id as grade_id from students, student_enrollment
			WHERE
			student_enrollment.student_id = students.student_id AND student_enrollment.syear = $syear AND student_enrollment.school_id=2 )
			as enrolled_students,
	
			(SELECT school_gradelevels.title as grade, school_gradelevels.id as grade_id from school_gradelevels) as Grade
	
			WHERE
			enrolled_students.grade_id = Grade.grade_id AND
			Grade.grade LIKE '%$grade%'
	
			ORDER BY sname ASC");
	
	
	$query->execute();
	$students_result = $query->fetchAll(PDO::FETCH_ASSOC);
	$students = array();
	foreach($students_result as $val){
		$name = $val['sname'].", ".$val['fname'];
		$tempsid = $val['sid'];
		$students[$tempsid] = $name;
	}
	$students['selected'] = $sname;
	
	return $students;
}

//prints the grading key (self contained)
function printKey(){
	?>
			<table style = "border-style:none;">
				<tr style = "border-style:none;">
					<td style = "border-style:none;">
						<table style = "width:90%;">
							<tr class = "sectiontitlecenter"><td colspan="2"  style = "width:100%; font-size:small">Achievement</td></tr>
							<tr><td style="width:3%" align="center">4</td><td style = "width:50%; font-size: small;">Consistently Above Standard<br>ទំនាក់ទំនងលេខ</td></tr>
							<tr><td style="width:3%" align="center">3</td><td style = "width:50%; font-size: small;">Meeting Standards<br>ទំនាក់ទំនងលេខ</td></tr>
							<tr><td style="width:3%" align="center">2</td><td style = "width:50%; font-size: small;">Making Progress<br>ទំនាក់ទំនងលេខ</td></tr>
							<tr><td style="width:3%" align="center">1</td><td style = "width:50%; font-size: small;">Making Minimum Progress<br>ទំនាក់ទំនងលេខ</td></tr>
							<tr><td style="width:3%" align="center">NA</td><td style = "width:50%; font-size: small;">Not Applicable<br>ទំនាក់ទំនងលេខ</td></tr>
						</table>
					</td>
					
					<td style = "width:10%; border-style: none;"></td>
					
					<td style = "border-style:none">
						<table style = "width:90%;">
							<tr class = "sectiontitlecenter"><td colspan="2" style = "width:100%; font-size:small">Effort</td></tr>
							<tr><td style="width:3%" align="center">E</td><td style = "width:50%; font-size: small;">Excellent<br>ទំនាក់ទំនងលេខ</td></tr>
							<tr><td style="width:3%" align="center">G</td><td style = "width:50%; font-size: small;">Good<br>ទំនាក់ទំនងលេខ</td></tr>
							<tr><td style="width:3%" align="center">S</td><td style = "width:50%; font-size: small;">Satisfactory<br>ទំនាក់ទំនងលេខ</td></tr>
							<tr><td style="width:3%" align="center">N</td><td style = "width:50%; font-size: small;">Needs Improvement<br>ទំនាក់ទំនងលេខ</td></tr>
							<tr><td style="width:3%" align="center">U</td><td style = "width:50%; font-size: small;">Unsatisfactory<br>ទំនាក់ទំនងលេខ</td></tr>
							<tr><td style="width:3%" align="center">NA</td><td style = "width:50%; font-size: small;">Not Applicable<br>ទំនាក់ទំនងលេខ</td></tr>
						</table>
					</td>
				</tr>
			</table>
		<?php 
	}
	
//prints the grading header (effort/grade/semester and so on) - expects an open table
function printHeader(){
	?>
	<tr><td class="sectiontitle" rowspan="2"><b>Grading Period</b>   </td><td  class = "sectiontitlecenter" colspan="2">Semester 1</td><td  class = "sectiontitlecenter" colspan="2">Semester 2</td></tr>
	<tr><td class = "sectiontitlecenter">Grade</td><td class = "sectiontitlecenter">Effort</td><td class = "sectiontitlecenter">Grade</td><td class = "sectiontitlecenter">Effort</td></tr>
	<?php 
}
	
	
//prints a table row - either grades or a section header
function printRow($dbh,$row,$template_id,$sid,$topic_id){
	
	if($row['is_graded']){
		//pull the grades from the DB
		$sql = "SELECT * from el_grades WHERE template_id = '$template_id' AND student_id = '$sid' AND topic_id ='$topic_id'";
		$query = $dbh->prepare($sql);
		$query->execute();
		$grades = $query->fetchAll();	
		//default values if things don't exist
		$truegrades = Array(
				"S1E"=>".",
				"S1G"=>".",
				"S2E"=>".",
				"S2G"=>"."
		);

		foreach($grades as $grade){
			switch ($grade){
				//case S1E
				case (strcasecmp($grade['term'],"S1") == 0 && strcasecmp($grade['type'], "E") == 0):
					$truegrades['S1E'] = $grade['value'];
					break;
					// case S1G
				case (strcasecmp($grade['term'],"S1") == 0 && strcasecmp($grade['type'], "G") == 0):
					$truegrades['S1G'] = $grade['value'];
					break;
					// case S2E
				case (strcasecmp($grade['term'],"S2") == 0 && strcasecmp($grade['type'], "E") == 0):
					$truegrades['S2E'] = $grade['value'];
					break;
					// case S2G
				case (strcasecmp($grade['term'],"S2") == 0 && strcasecmp($grade['type'], "G") == 0):
					$truegrades['S2G'] = $grade['value'];
					break;
			}
				
		}
		print("<tr><td align=\"right\" style = \"font-size:small;\">".$row['text_en']."<br>".$row['text_kh']."</td>

				<td align = \"center\" style = \"font-size:normal;\" class=\"editGrade\" id=\"S1G".$row['topic_id']."\">".$truegrades['S1G']."</td>
				<td align = \"center\" style = \"font-size:normal;\" class=\"editEffort\" class=\"editGrade\" id=\"S1E".$row['topic_id']."\">".$truegrades['S1E']."</td>
				<td align = \"center\" style = \"font-size:normal;\" class=\"editGrade\"class=\"editGrade\" id=\"S2G".$row['topic_id']."\">".$truegrades['S2G']."</td>
				<td align = \"center\" style = \"font-size:normal;\" class=\"editEffort\"class=\"editGrade\" id=\"S2E".$row['topic_id']."\">".$truegrades['S2E']."</td>"
		);

	}
	else{
		print("
		<tr><td colspan = \"5\" class = \"sectiontitle\">".$row['text_en']."<br>".$row['text_kh']."</td></tr>
		");
	}
}

// prints out the comments on the back of the report card (self contained)
function printComments($dbh, $template_id, $sid){
	$sql = "SELECT * from el_comments WHERE template_id = '$template_id' AND student_id = '$sid'";
	//print($sql);
	$query = $dbh->prepare($sql);
	$query->execute();
	$comments = $query->fetchAll();
	$truecomments = Array(
			"1"=>"",
			"2"=>"",
			"3"=>"",
			"4"=>"");
	foreach($comments as $comment){
		$truecomments[$comment['comment_id']] = $comment['comment'];
	}
	print("
			<table class = \"outline\">
				<tr><td class = \"sectiontitlecenter\"><b>GENERAL COMMENTS</b></td></tr>
					<tr><td class = \"sectiontitlecenter\">S1 - English		</td></tr>
					<tr><td class=\"commentblock\"  id = \"C1\">".$truecomments['1']."</td></tr>
					<tr><td class = \"sectiontitlecenter\">S1 - Khmer			</td></tr>
					<tr><td class=\"commentblock\" id = \"C2\">".$truecomments['2']."</td></tr>
					<tr><td class = \"sectiontitlecenter\">S2 - English		</td></tr>
					<tr><td class=\"commentblock\" id = \"C3\">".$truecomments['3']."</td></tr>
					<tr><td class = \"sectiontitlecenter\">S2 - Khmer			</td></tr>
					<tr><td class=\"commentblock\" id = \"C4\">".$truecomments['4']."</td></tr>
			</table>
		");

}

// prints all the important stuff on the front page of the report card (self contained)
function printTitle($sname, $grade, $teacher, $teacher_kh, $date, $sdays1, $sdays2, $da1, $da2, $dt1, $dt2){
	?>
	<table class = \"nooutline\">
		<tr><td class = "noborder" style = "height: 10%; text-align:center;"><img src = "img/AHISLogo.png" style = "height: 3.5cm;"></td></tr>
		<tr><td class = "noborder" align ="center"><b style = "font-size: 15pt;">ASIAN HOPE INTERNATIONAL SCHOOL</b></td></tr>
		<tr><td class = "noborder" align ="center"><b style = "font-size: 12pt;">a ministry of Asian Hope Cambodia</b></td></tr>
		<tr><td class = "noborder" align ="center"><b style = "font-size: 12pt;">PHNOM PENH, KINGDOM OF CAMBODIA</b></td></tr>
		<tr><td class = "noborder" align ="center"><b style = "font-size: 15pt;">2012-2013 REPORT CARD</b></td></tr>
		<tr><td class = "noborder" align ="center"><b style = "font-size: 12pt;">PH: 023.885.170</b></td></tr>
		<tr><td class = "noborder" align ="center"><b style = "font-size: 12pt;">ASIANHOPESCHOOL.ORG</b></td></tr>
		<tr><td class = "noborder" style = "height: 5%;"></td></tr>
		<tr><td class = "noborder" align = "center">
			<table style = "width: 70%; border: none; margin-bottom: 2%;">		
				<tr><td class = "noborder"><b>Student</b></td><td class = "student" id = "sid" align = "right"><?php print $sname;?></td></tr>
				<tr><td class = "noborder"><b>Grade</b></td><td class = "noborder" align = "right"><?php print $grade;?></td></tr>
				<tr><td class = "noborder"><b>Classroom Teacher</b></td><td class = "noborder" align = "right"><?php print $teacher;?></td></tr>
				<tr><td class = "noborder"><b>Khmer Teacher</b></td><td class = "noborder" align = "right"><?php print $teacher_kh;?></td></tr>
				<tr><td class = "noborder"><b>Date</b></td><td class = "noborder" align = "right"><?php print $date; ?></td></tr>
			</table>
		</td></tr>
		<tr><td class = "noborder" align = "center">
			<table style = "width: 70%; margin-bottom: 2%;" border = "1" align = "center">		
				<tr><td align = "right" style = "width: 50%"><b>Semester</b></td><td align = "center" style = "width:20%">1</td><td align = "center"  style = "width:20%">2</td></tr>
				<tr><td align = "center" colspan="3" style ="font-size:normal;"><b>Attendance</b></td></tr>
				<tr><td align = "right"><b>Number of School Days</b></td><td align = "center"><?php print $sdays1;?></td><td align = "center"><?php print $sdays2;?></td></tr>
				<tr><td align = "right"><b>Days Absent</b></td><td align = "center"><?php print $da1;?></td><td align = "center"><?php print $da2; ?></td></tr>
				<tr><td align = "right"><b>Days Tardy</b></td><td align = "center"><?php print $dt1;?></td><td align = "center"><?php print $dt2;?></td></tr>
			</table>
		</td></tr>
		<tr><td class = "noborder" align = "center">
			<table style = "width: 100%;" border = "0">		
				<tr><td class = "noborder" style = "height: 3%;" align = "left"><b>Classroom Teacher's Signature</b></td><td class = "noborder" align = "center">_____________________</td></tr>
				<tr><td class = "noborder" style = "height: 3%;" align = "left"><b>Khmer Teacher's Signature</b></td><td class = "noborder" align = "center">_____________________</td></tr>
				<tr><td class = "noborder" style = "height: 3%;" align = "left"><b>Principal's Signature</b></td><td class = "noborder" align = "center">_____________________</td></tr>
			</table>
		</td></tr>
	</table>
	<?php 
}
		

?>