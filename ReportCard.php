<?php
class ReportCard{
	//Things we need to construct a ReportCard
	private $syear;
	private $sid;
	private $template_id;
	private $teacher_id;
	private $teacher_kh_id;
	private $teacher_name;
	private $teacher_kh_name;

	//total school days by semester
	private $sdays1;
	private $sdays2;

	//days absent/tardy by semester
	private $da1;
	private $da2;
	private $dt1;
	private $dt2;

	private $sname; //Full student name (Surname, Firstname)
	private $grade; //normal name of grade, pulled from template_id (e.g. "Grade 2")

	//comments (duh)
	private $comment1;
	private $comment2;
	private $comment3;
	private $comment4;

	//Date the report card was generated
	private $date;

	private $HEIGHTLIMIT = 21;
	private $COLUMNS = 4;
	private $KEY = 1;

	//attendance data
	private $sdays = array();
	private $da = array();
	private $dt = array();

	//grading schema - if these are updated, need to redo headers and key
	private $schema_3 = Array(
			'Ch'=>'✔',
			'.'=>' ',
			'selected'=>'✔'
			);
	private $schema_4e = Array(
			'E'=>'E','G'=>'G','S'=>'S','N'=>'N','U'=>'U','NA'=>'NA','.'=>'UG', 'selected'=>'E'
			);
	private $schema_4g = Array(
			'4'=>'4','3'=>'3','2'=>'2','1'=>'1','NA'=>'NA','.'=>'UG', 'selected'=>'4'
			);

	private $effort_schema;
	private $grade_schema;
	function __construct($syear="2012", $sid=null, $template_id="2", $teacher_id="209", $teacher_kh_id="209"){

		$this->syear=$syear;
		$this->sid=$sid;
		$this->template_id=$template_id;
		$this->teacher_id=$teacher_id;
		$this->teacher_kh_id=$teacher_kh_id;
		$this->date = date("d M Y",time());

		$dbh = $this->connectELDB();
		$sdbh =$this->connectOpenSIS();

		// Good stuff starts here!

		//generate actual student name
		if($sid!=null){
			$query = $sdbh->prepare("SELECT first_name, last_name from students where student_id = '$sid'");
			$query->execute();
			$val = $query->fetch();
			$this->sname = $val['last_name'].", ".$val['first_name'];
		}
		else $this->sname = "Please Select a Student";

		//generate actual teacher name
		$query = $sdbh->prepare("SELECT first_name, last_name from staff where staff_id = '$teacher_id'");
		$query->execute();
		$val = $query->fetch();
		$this->teacher_name = $val['last_name'].", ".$val['first_name'];

		//generate actual teacher_kh name
        if($teacher_kh_id == 0) $this->teacher_kh_name = null;
        else{
		   $query = $sdbh->prepare("SELECT first_name, last_name from staff where staff_id = '$teacher_kh_id'");
		   $query->execute();
		   $val = $query->fetch();
		   $this->teacher_kh_name = $val['last_name'].", ".$val['first_name'];
        }

		//Pull the grade name from the template ID and store it in the session
		$sql = "SELECT * from templates WHERE template_id = '$template_id'";
		$query = $dbh->prepare($sql);
		$query->execute();
		$template = $query->fetch();
		$this->grade = $template['template_name'];
		$this->HEIGHTLIMIT = $template['height_limit'];
		$this->COLUMNS = $template['columns'];
		$this->KEY = $template['key'];

		if($this->COLUMNS == 4){
			$this->effort_schema = $this->schema_4e;
			$this->grade_schema = $this->schema_4g;
		}
		elseif($this->COLUMNS == 3){
			$this->effort_schema = $this->schema_3;
			$this->grade_schema = $this->schema_3;
		}
		//where do s1 and s2 begin? (will have to re-evaluate for a Logos version where we go by quarter(?))
		$query = $sdbh->prepare("SELECT * FROM marking_periods where school_id=2 AND syear = $syear AND parent_id >0");
		$query->execute();
		$mp_result = $query->fetchAll(PDO::FETCH_ASSOC);
		$i = 1;
		
		//this runs once per marking period -
		foreach($mp_result as $val){
			$sdate = $val['start_date'];
			$edate = $val['end_date'];
			
			//get total number of days per marking period from attendance calendar (all the way to the end of the year)
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
			
			//get the total number of unknown days
			$q = $sdbh->prepare("SELECT COUNT(*) as count from attendance_calendar where syear=$syear AND school_id=2 AND school_date>='"
					.date("Y-m-d",strtotime("Today"))."' AND school_date<='".$edate."'");
		
			$q->execute();
			$dures = $q->fetch();
			
		
			//load them up
			$sdays[$i] = $res['count'];
			$da[$i] = $dares['count'];
			$dt[$i] = $dtres['count'];
			$du[$i] = $dures['count'];
			
			$i++;
		}

		$this->sdays1 = $sdays['1'];
		$this->sdays2 = $sdays['2'];

		//tardies are tardies!
		$this->dt1 = $dt['1'];
		$this->dt2 = $dt['2'];
		
		//If we're not at the end of a marking period, we don't know about certain days - so we give them the benefit of the doubt
		$unknownS1 = $du['1'];
		$unknownS2 = $du['2'];
		
		//days absent are the total days - days present - days tardy (that is: all attendance codes that aren't 'present' or 'late')
		$this->da1 = $sdays['1'] - $da['1'] - $this->dt1 - $unknownS1;
		$this->da2 = $sdays['2'] - $da['2'] - $this->dt2 - $unknownS2;
	}

	/*
	 * Outputs the report card, but leaves most of the styling to an external stylesheet (nominally.. maybe not so much right now)
	 */
	function toHTML(){
		$dbh = $this->connectELDB();
		$sdbh = $this->connectOpenSIS();

		print("<table style = \"width: 90%; margin-left: auto; margin-right: auto;\"><tr>");

		//Print the comments on the left hand side
		print("<td class = \"left\">");
		$this->printComments();
		print("</td>");

		//Print the title on the right hand side
		print("<td class = \"right\">");
		$this->printTitle();
		print("</td>");
		print("</tr></table>");
		?>
		<!-- --------------------------------------------Break Here-------------------------------------------------------------------------------------- -->
		<div style ="page-break-before: always;"></div>
		<!-- --------------------------------------------Break Here-------------------------------------------------------------------------------------- -->

			<?php

			print("<table style = \"width: 90%; margin-left: auto; margin-right: auto;\"><tr>");
			//left page grades
			print("<td class = \"left\">");


				print("<table class = \"outline\">");

				$this->printHeader();

				$topic_id = 0;
				foreach($dbh->query("SELECT * from template_fields WHERE template_id='".$this->template_id."' ORDER BY topic_id") as $row) {

					//does this happen? Move on to the right side
					if($topic_id==$this->HEIGHTLIMIT){
						print("</table></td>"); //these breaks move the left table up in line with the right, may have to change
						print("<td class = \"right\"><table class = \"outline\">");
						$this->printHeader();
					}

					$this->printRow($row,$topic_id);
					$topic_id++;
				}

				print("</table>");
				$this->printKey();
				print("</td>");
			print("</tr></table>");
	}


	/*****************************
	 ***** Helper Functions ******
	*****************************/
	//who is enrolled? returns an array with the currently selected student marked as such
	function getEnrolledStudents(){
		$sdbh = $this->connectOpenSIS();
		$syear = $this->syear;
		$grade = $this->grade;
		$sname = $this->sname;
		$teacher_id = $this->teacher_id;

		//grab student names to populate list - magic number school
		$query = $sdbh->prepare("SELECT
				enrolled_students.sid,
				enrolled_students.fname,
				enrolled_students.sname,
				course.course_title

				FROM

				(SELECT students.first_name as fname, students.last_name as sname,
				 students.student_id as sid, students.birthdate as DOB,students.is_disable,
				 schedule.course_period_id as course_period_id
				 FROM students, schedule
				 WHERE
				 schedule.student_id = students.student_id AND schedule.syear = 2012 AND schedule.school_id=2
				 AND students.is_disable IS NULL AND schedule.end_date IS NULL)
				 as enrolled_students,

				(SELECT course_title, course_period_id FROM course_details WHERE teacher_id = $this->teacher_id) as course


				WHERE
				enrolled_students.course_period_id = course.course_period_id

				ORDER BY sname ASC");


				$query->execute();
				$students_result = $query->fetchAll(PDO::FETCH_ASSOC);
				$students = array();
				foreach($students_result as $val){
				$name = $val['sname'].", ".$val['fname'];
				$tempsid = $val['sid'];
				$collate = $name.".".$tempsid;
				$students[$collate] = $name;
	}
	$students['selected'] = $sname;

	return $students;
	}

	function getEnrolledStudentsSchema(){
		return str_replace("\"","'",json_encode($this->getEnrolledStudents()));
	}

	function getGradeSchema(){
		return str_replace("\"","'",json_encode($this->grade_schema));
	}
	function getEffortSchema(){
		return str_replace("\"","'",json_encode($this->effort_schema));
	}
		//prints the grading key (self contained)
	function printKey(){
		if(strcmp($this->KEY,0)){
	?>
			<br/>
			<table style = "border-style:none;">
				<tr style = "border-style:none;">
					<td style = "border-style:none;">
						<table style = "width:90%;">
							<tr class = "sectiontitlecenter"><td colspan="2"  style = "width:100%; font-size:xsmall">Achievement</td></tr>
							<tr><td style="width:3%" align="center">4</td><td style = "width:50%; font-size: xsmall;">Consistently Above Standard<br> លើស្តង់ដា</td></tr>
							<tr><td style="width:3%" align="center">3</td><td style = "width:50%; font-size: xsmall;">Meeting Standards<br>ស្មើរស្តង់ដា</td></tr>
							<tr><td style="width:3%" align="center">2</td><td style = "width:50%; font-size: xsmall;">Making Progress<br>ដំណើរការទៅដល់ស្តង់ដា</td></tr>
							<tr><td style="width:3%" align="center">1</td><td style = "width:50%; font-size: xsmall;">Making Minimum Progress<br>អប្បបរមាក្នុងការដល់ស្តង់ដា</td></tr>
							<tr><td style="width:3%" align="center">NA</td><td style = "width:50%; font-size: xsmall;">Not Applicable<br>មិនមាននៅឡើយ</td></tr>
						</table>
					</td>

					<td style = "width:10%; border-style: none;"></td>

					<td style = "border-style:none">
						<table style = "width:90%;">
							<tr class = "sectiontitlecenter"><td colspan="2" style = "width:100%; font-size:xsmall">Effort</td></tr>
							<tr><td style="width:3%" align="center">E</td><td style = "width:50%; font-size: xsmall;">Excellent<br>ល្អណាស់</td></tr>
							<tr><td style="width:3%" align="center">G</td><td style = "width:50%; font-size: xsmall;">Good<br>ល្អ</td></tr>
							<tr><td style="width:3%" align="center">S</td><td style = "width:50%; font-size: xsmall;">Satisfactory<br>មធ្យម</td></tr>
							<tr><td style="width:3%" align="center">N</td><td style = "width:50%; font-size: xsmall;">Needs Improvement<br>ខ្សោយ</td></tr>
							<tr><td style="width:3%" align="center">U</td><td style = "width:50%; font-size: xsmall;">Unsatisfactory<br>ខ្សោយណាស់</td></tr>
							<tr><td style="width:3%" align="center">NA</td><td style = "width:50%; font-size: xsmall;">Not Applicable<br>មិនមាននៅឡើយ</td></tr>
						</table>
					</td>
				</tr>
			</table>
		<?php
		}
	}

	//prints the grading header (effort/grade/semester and so on) - expects an open table
	function printHeader(){
		if($this->COLUMNS == 3){
			?>
			<tr><td class = "sectiontitlecenter"></td><td class = "sectiontitlecenterfixed">Yes<br/>ធ្វើបាន</td><td class = "sectiontitlecenterfixed">Developing<br/>កំពុងធ្វើ</td><td class = "sectiontitlecenterfixed">Not Yet<br/>មិនទាន់ធ្វើ</td>
			<?php
		}
		else if($this->COLUMNS ==4){
			?>
			<tr><td class="sectiontitle" rowspan="2"><b>Grading Period</b>   </td><td  class = "sectiontitlecenter" colspan="2">Semester 1</td><td  class = "sectiontitlecenter" colspan="2">Semester 2</td></tr>
			<tr><td class = "sectiontitlecenter">Grade</td><td class = "sectiontitlecenter">Effort</td><td class = "sectiontitlecenter">Grade</td><td class = "sectiontitlecenter">Effort</td></tr>
			<?php
		}
	}


	//prints a table row - either grades or a section header
	private function printRow($row,$topic_id){
		$dbh = $this->connectELDB();
		$template_id = $this->template_id;
		$sid = $this->sid;

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
				if(strcmp($grade['value'],"Ch") == 0) $grade['value'] = "<img src = \"img\check.png\">";
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
			print("<tr><td align=\"right\" class = \"rowtitle\">".$row['text_en']."<br>".$row['text_kh']."</td>

					<td align = \"center\" class=\"editGrade\" id=\"S1G".$row['topic_id']."\">".$truegrades['S1G']."</td>
					<td align = \"center\"  class=\"editEffort\" class=\"editGrade\" id=\"S1E".$row['topic_id']."\">".$truegrades['S1E']."</td>
					<td align = \"center\"  class=\"editGrade\"class=\"editGrade\" id=\"S2G".$row['topic_id']."\">".$truegrades['S2G']."</td>"
			);
			if($this->COLUMNS == 4)
				print("<td align = \"center\" class=\"editEffort\"class=\"editGrade\" id=\"S2E".$row['topic_id']."\">".$truegrades['S2E']."</td>"
			);

		}
		else{
			print("
			<tr><td colspan = \"5\" class = \"sectiontitle\">".$row['text_en']."<br>".$row['text_kh']."</td></tr>
			");
		}
	}

	// prints out the comments on the back of the report card (self contained)
	 function printComments(){
		$dbh = $this->connectELDB();

		$template_id = $this->template_id;
		$sid = $this->sid;

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
				<table id = \"comments\">
					<tr><td class = \"commentSectionTitle\"><b>GENERAL COMMENTS</b></td></tr>
						<tr><td class = \"commentSectionTitle\">S1 - English		</td></tr>
						<tr><td class=\"commentblock\"  id = \"C1\">".$truecomments['1']."</td></tr>
						<tr><td class = \"commentSectionTitle\">S1 - Khmer			</td></tr>
						<tr><td class=\"commentblock\" id = \"C2\">".$truecomments['2']."</td></tr>
						<tr><td class = \"commentSectionTitle\">S2 - English		</td></tr>
						<tr><td class=\"commentblock\" id = \"C3\">".$truecomments['3']."</td></tr>
						<tr><td class = \"commentSectionTitle\">S2 - Khmer			</td></tr>
						<tr><td class=\"commentblock\" id = \"C4\">".$truecomments['4']."</td></tr>
				</table>
			");

	}

	// prints all the important stuff on the front page of the report card (self contained)
	 function printTitle(){
		?>
		<table id = \"title\">
			<tr><td class = "noborder" style = "height: 10%; text-align:center;"><img src = "img/AHISLogo.png" style = "height: 3.5cm;"></td></tr>
			<tr><td class = "noborder" align ="center"><b style = "font-size: 15pt;">ASIAN HOPE INTERNATIONAL SCHOOL</b></td></tr>
			<tr><td class = "noborder" align ="center"><b style = "font-size: 12pt;">a ministry of Asian Hope Cambodia</b></td></tr>
			<tr><td class = "noborder" align ="center"><b style = "font-size: 12pt;">PHNOM PENH, KINGDOM OF CAMBODIA</b></td></tr>
			<tr><td class = "noborder" align ="center"><b style = "font-size: 15pt;">2012-2013 REPORT CARD</b></td></tr>
			<tr><td class = "noborder" align ="center"><b style = "font-size: 12pt;">PH: 023.885.170</b></td></tr>
			<tr><td class = "noborder" align ="center"><b style = "font-size: 12pt;">ASIANHOPESCHOOL.ORG</b></td></tr>
			<tr><td class = "noborder" style = "height: 5%;"></td></tr>
			<tr><td class = "noborder" align = "center">
				<table style = "width: 70%; border: none; margin-bottom: 5%; margin-top: 5%">
					<tr><td class = "noborder"><b>Student</b></td><td class = "student" id = "sid" align = "right"><?php print $this->sname;?></td></tr>
					<tr><td class = "noborder"><b>Grade</b></td><td class = "noborder" align = "right"><?php print $this->grade;?></td></tr>
					<tr><td class = "noborder"><b>Classroom Teacher</b></td><td class = "noborder" align = "right"><?php print $this->teacher_name;?></td></tr>
                    <?php if(!is_null($this->teacher_kh_name)){?>	<tr><td class = "noborder"><b>Khmer Teacher</b></td><td class = "noborder" align = "right"><?php print $this->teacher_kh_name;?></td></tr><?php }?>
					<tr><td class = "noborder"><b>Date</b></td><td class = "noborder" align = "right"><?php print $this->date; ?></td></tr>
				</table>
			</td></tr>
			<tr><td class = "noborder" align = "center">
				<table style = "width: 35%; margin-bottom: 7%;" border = "1" align = "center">
					<tr><td align = "right" style = "width: 50%"><b>Semester</b></td><td align = "center" style = "width:20%">1</td><td align = "center"  style = "width:20%">2</td></tr>
					<tr><td align = "center" colspan="3" style ="font-size:normal;"><b>Attendance</b></td></tr>
					<tr><td align = "right"><b>Number of School Days</b></td><td align = "center"><?php print $this->sdays1;?></td><td align = "center"><?php print $this->sdays2;?></td></tr>
					<tr><td align = "right"><b>Days Absent</b></td><td align = "center"><?php print $this->da1;?></td><td align = "center"><?php print $this->da2; ?></td></tr>
					<tr><td align = "right"><b>Days Tardy</b></td><td align = "center"><?php print $this->dt1;?></td><td align = "center"><?php print $this->dt2;?></td></tr>
				</table>
			</td></tr>
			<tr><td class = "noborder" align = "center">
				<table style = "width: 100%;" border = "0">
					<tr><td class = "noborder" style = "height: 5%;" align = "left"><b>Classroom Teacher's Signature</b></td><td class = "noborder" align = "center">_____________________</td></tr>
                    <?php if(!is_null($this->teacher_kh_name)){?><tr><td class = "noborder" style = "height: 5%;" align = "left"><b>Khmer Teacher's Signature</b></td><td class = "noborder" align = "center">_____________________</td></tr><?php }?>
					<tr><td class = "noborder" style = "height: 5%;" align = "left"><b>Principal's Signature</b></td><td class = "noborder" align = "center">_____________________</td></tr>
				</table>
			</td></tr>
		</table>
		<?php
	}

	function getGrade(){
		return $this->grade;
	}

	function getTeacherName(){
		return $this->teacher_name;
	}

	//return the number of records a student has in the DB
	function hasData($sid){
		$dbh = $this->connectELDB();
		$template_id = $this->template_id;

		$sql = "SELECT columns from templates WHERE template_id = '$template_id'";
		$query = $dbh->prepare($sql);
		$query->execute();
		$res = $query->fetch();
		$columns = $res['columns'];

		//
		$count = 0;

		//special case if there are only 3 columns
		if($columns == 3){
			$sql = "SELECT count(*) as count from el_grades WHERE template_id = '$template_id' AND student_id = '$sid' AND value NOT LIKE '.'";
			$query = $dbh->prepare($sql);
			$query->execute();
			$res = $query->fetch();
			$count = $res['count'];
		}
		//otherwise just pull the grades and count those
		else{
			$sql = "SELECT count(*) as count from el_grades WHERE template_id = '$template_id' AND student_id = '$sid' AND type = 'E' AND value NOT LIKE '.'";
			$query = $dbh->prepare($sql);
			$query->execute();
			$res = $query->fetch();
			$count = $res['count'];

			$sql = "SELECT count(*) as count from el_grades WHERE template_id = '$template_id' AND student_id = '$sid' AND type = 'G' AND value NOT LIKE '.'";
			$query = $dbh->prepare($sql);
			$query->execute();
			$res = $query->fetch();
			$count += $res['count'];

			$count /= 2;
		}

		$sql = "SELECT count(*) as count from template_fields WHERE template_id = '$template_id' AND is_graded = 1";
		$query = $dbh->prepare($sql);
		$query->execute();
		$res = $query->fetch();
		$total = $res['count'];

		$percent = ($count/$total)*100;
		return $percent;

	}
	//these are terrible.
	private function connectOpenSIS(){
		include("data.php");
		$dsn = $DatabaseType.":host=".$DatabaseServer.";dbname=".$DatabaseName;
		return(new PDO($dsn, "$DatabaseUsername", "$DatabasePassword"));
	}
	private function connectELDB(){
		include("data.php");
		$dsn = $DatabaseType.":host=".$DatabaseServer.";dbname=".$ELDatabaseName;
		$dbh = new PDO($dsn, "$DatabaseUsername", "$DatabasePassword");
		$dbh->query('SET NAMES utf8');
		return($dbh);
	}
}
?>
