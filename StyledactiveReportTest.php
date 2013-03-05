<html>
	<head><meta charset="UTF-8" />
	<link rel = "stylesheet" type="text/css" href="styles_test.css" media ="print"/>
	<link rel = "stylesheet" type="text/css" href="styles_test.css"/>
	</head>
<?php
$comment1 = "comment1";
$comment2 = "លេខ2";
$comment3 = "comment3";
$comment4 = "លេខ4";

$sname = "Tom Foolery";
$grade = "Grade 2" ;
$teacher = "Sonny N. Cher" ;
$teacher_kh = "Thida Sor";
$date = "15-May-2013";
$sdays1 = 85;
$sdays2 = 90;
$da1  =5;
$da2 = 6;
$dt1 = 7;
$dt2 = 8;
	//connect to DB
	$dbh = new PDO('mysql:host=localhost;dbname=test', "root", "mysqldrowssaP");
	
	//make sure Khmer will come through
	$dbh->query('SET NAMES utf8');
	
	print("<table style = \"width: 90%;\"><tr>");	
		//Print the comments on the left hand side
		print("<td class = \"noborder\" align = \"left\">");
			printComments();
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
	print("<td class = \"noborder\" align = \"left\">");
	
	
		print("<table class = \"outline\">");
		
		printHeader();
		$heightLimit =  17;
		$i = 0;
		foreach($dbh->query('SELECT * from template_fields ORDER BY topic_id') as $row) {
			
			if($i>=$heightLimit){
				print("</table><br><br><br></td>"); //these breaks move the left table up in line with the right, may have to change
				print("<td class = \"noborder\" align = \"right\"><table class = \"outline\">");
				printHeader();
				$i=0;
			}
			
			printRow($row);
			$i++;
		}
		
		
		print("</table>");
		printKey();
		print("</td>");
	print("</tr></table>");
	
	$dbh = null; //closes the connection
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
					<tr><td class = "noborder"><b>Student</b></td><td class = "noborder" align = "right"><?php print $sname;?></td></tr>
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
	function printComments(){
		?>
		<table class = \"outline\">
			<tr><td class = "sectiontitlecenter"><b>GENERAL COMMENTS</b></td></tr>
				<tr><td class = "sectiontitlecenter">S1 - English		</td></tr>
				<tr><td class="commentblock">$comment1</td></tr>
				<tr><td class = "sectiontitlecenter">S1 - Khmer			</td></tr>
				<tr><td class="commentblock">$comment2</td></tr>
				<tr><td class = "sectiontitlecenter">S2 - English		</td></tr>
				<tr><td class="commentblock">$comment3</td></tr>
				<tr><td class = "sectiontitlecenter">S2 - Khmer			</td></tr>
				<tr><td class="commentblock">$comment4</td></tr>	
		</table>
		<?php 
	}
	function printHeader(){
		?>
		<tr><td class="sectiontitle" rowspan="2"><b>Grading Period</b>   </td><td  class = "sectiontitlecenter" colspan="2">Semester 1</td><td  class = "sectiontitlecenter" colspan="2">Semester 2</td></tr>
		<tr><td class = "sectiontitlecenter">Grade</td><td class = "sectiontitlecenter">Effort</td><td class = "sectiontitlecenter">Grade</td><td class = "sectiontitlecenter">Effort</td></tr>
		<?php 
	}

	function printRow($row){
		if($row['is_graded']){
			print("
					<tr><td align=\"right\" style = \"font-size:small;\">".$row['text_en']."<br>".$row['text_kh']."</td>
					<td align = \"center\" style = \"font-size:.normal;\">4</td>
					<td align = \"center\" style = \"font-size:normal;\">E</td>
					<td align = \"center\" style = \"font-size:normal;\">3</td>
					<td align = \"center\" style = \"font-size:normal;\">U</td>"
			);
		
		}
		else{
			print("
			<tr><td colspan = \"5\" class = \"sectiontitle\">".$row['text_en']."<br>".$row['text_kh']."</td></tr>
			");
		}
	}

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

?>
</html>