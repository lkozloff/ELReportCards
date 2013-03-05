<?php
require_once "tcpdf/tcpdf.php";
require_once "tcpdf/config/lang/eng.php";

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

$grades1Arr = Array(
		's1g1' => '1',
		's1e1' => 'E',
		's2g1' => '2',
		's2e1' => 'G',
		
		's1g2' => '3',
		's1e2' => 'E',
		's2g2' => '4',
		's2e2' => 'S',
		
		's1g3' => '1',
		's1e3' => 'E',
		's2g3' => '2',
		's2e3' => 'N',
		
		's1g4' => '3',
		's1e4' => 'G',
		's2g4' => '4',
		's2e4' => 'U',
		
		's1g5' => '1',
		's1e5' => 'E',
		's2g5' => '2',
		's2e5' => 'G',
		
		's1g6' => '3',
		's1e6' => 'S',
		's2g6' => '4',
		's2e6' => 'N',
		
		's1g7' => '1',
		's1e7' => 'U',
		's2g7' => '2',
		's2e7' => 'E',
		
		's1g8' => '3',
		's1e8' => 'G',
		's2g8' => '4',
		's2e8' => 'S',
		
		's1g9' => '4',
		's1e9' => 'N',
		's2g9' => '4',
		's2e9' => 'U',
		
		's1g10' => '4',
		's1e10' => 'E',
		's2g10' => '4',
		's2e10' => 'E',
		
		's1g11' => '4',
		's1e11' => 'E',
		's2g11' => '4',
		's2e11' => 'E',
		
		's1g12' => '4',
		's1e12' => 'E',
		's2g12' => '4',
		's2e12' => 'E',
		
		's1g13' => '4',
		's1e13' => 'E',
		's2g13' => '4',
		's2e13' => 'E'
		);
$pdf = new TCPDF('P', 'mm' , 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Lyle Kozloff');
$pdf->SetTitle('Student ID Card');
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

//set margins
$pdf->SetMargins(2,2,2);
//set auto page breaks
$pdf->SetAutoPageBreak(false);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// define barcode style
$style = array(
		'position' => '',
		'align' => 'C',
		'stretch' => false,
		'fitwidth' => true,
		'cellfitalign' => '',
		'border' => false,
		'hpadding' => 'auto',
		'vpadding' => 'auto',
		'fgcolor' => array(0,0,0),
		'bgcolor' => false, //array(255,255,255),
		'text' => false,
		'font' => 'helvetica',
		'fontsize' => 12,
		'stretchtext' => 0
);

//*** END PDF Setup *****//


$KhmerOS = $pdf->addTTFfont('fonts/KhmerOSbattambang.ttf', 'TrueTypeUnicode', '', 32);
$pdf->SetFont('KhmerOSbattambang', '', 9);
$pdf->AddPage('L');

$pdf->writeHTMLCell(120,70,10,10,Comments($comment1, $comment2, $comment3, $comment4),'0',1);
$pdf->writeHTMLCell(120,70,165,10,Title($sname, $grade, $teacher, $teacher_kh, $date, $sdays1, $sdays2, $da1, $da2, $dt1, $dt2),'0',1);

$pdf->AddPage('L');

$pdf->writeHTMLCell(120,70,10,10,Grades1($grades1Arr),'0',1);
$pdf->writeHTMLCell(120,70,165,10,Grades2($grades1Arr),'0',1);


$pdf->Output('example_005.pdf', 'I');

function Comments($comment1, $comment2, $comment3, $comment4){
	return("
	<table border=\"1\">
		<tr><td align =\"center\"><b>GENERAL COMMENTS</b></td></tr>
		<tr><td align =\"center\">S1 - English		</td></tr>
		<tr><td style = \"height: 4cm;\">&nbsp;&nbsp;&nbsp;$comment1</td></tr>
		<tr><td align =\"center\">S1 - Khmer			</td></tr>
		<tr><td style = \"height: 4cm;\">&nbsp;&nbsp;&nbsp;$comment2</td></tr>
		<tr><td align =\"center\">S2 - English		</td></tr>
		<tr><td style = \"height: 4cm;\">&nbsp;&nbsp;&nbsp;$comment3</td></tr>
		<tr><td align =\"center\">S2 - Khmer			</td></tr>
		<tr><td style = \"height: 4cm;\">&nbsp;&nbsp;&nbsp;$comment4</td></tr>	
	</table>

	");
	
}

function Title($sname, $grade, $teacher, $teacher_kh, $date, $sdays1, $sdays2, $da1, $da2, $dt1, $dt2 ){
	return("
	<table>
		<tr><td style = \"height: 4cm;\"></td></tr>
		<tr><td align =\"center\"><b style = \"font-size: .60cm;\">ASIAN HOPE INTERNATIONAL SCHOOL</b></td></tr>
		<tr><td align =\"center\"><b style = \"font-size: .40cm;\">a ministry of Asian Hope Cambodia</b></td></tr>
		<tr><td align =\"center\"><b style = \"font-size: .40cm;\">PHNOM PENH, KINGDOM OF CAMBODIA</b></td></tr>
		<tr><td align =\"center\"><b style = \"font-size: .60cm;\">2012-2013 REPORT CARD</b></td></tr>
		<tr><td align =\"center\"><b style = \"font-size: .40cm;\">PH: 023.885.170</b></td></tr>
		<tr><td align =\"center\"><b style = \"font-size: .40cm;\">ASIANHOPESCHOOL.ORG</b></td></tr>
		<tr><td style = \"height: 1cm;\"></td></tr>
		<tr><td align = \"center\" style = \"width:1.7cm;\"></td><td>
				<table style = \"width: 8cm;\">		
				<tr><td><b>Student</b></td><td style align = \"right\">$sname</td></tr>
				<tr><td><b>Grade</b></td><td align = \"right\">$grade</td></tr>
				<tr><td><b>Classroom Teacher</b></td><td align = \"right\">$teacher</td></tr>
				<tr><td><b>Khmer Teacher</b></td><td align = \"right\">$teacher_kh</td></tr>
				<tr><td><b>Date</b></td><td align = \"right\">$date</td></tr>
				</table>
											</td></tr>
			<tr><td></td></tr>
		</table>
		<table>
			<tr style = \"height: 5cm\"><td></td></tr>
		</table>
		<table align = \"center\">
		<tr><td align = \"center\" style = \"width:1.7cm;\"></td>
				<td>
				<table style = \"width: 8cm;\" border = \"1\">		
					<tr><td align = \"right\" style = \"width: 4cm\"><b>Semester&nbsp;&nbsp;&nbsp;</b></td><td align = \"center\" style = \"width:2cm\">1</td><td align = \"center\"  style = \"width:2cm\">2</td></tr>
					<tr><td align = \"center\" colspan=\"3\" style =\"font-size:large;\"><b>Attendance</b></td></tr>
					<tr><td align = \"right\"><b>Number of School Days&nbsp;&nbsp;&nbsp;</b></td><td align = \"center\">$sdays1</td><td align = \"center\">$sdays2</td></tr>
					<tr><td align = \"right\"><b>Days Absent&nbsp;&nbsp;&nbsp;</b></td><td align = \"center\">$da1</td><td align = \"center\">$da2</td></tr>
					<tr><td align = \"right\"><b>Days Tardy&nbsp;&nbsp;&nbsp;</b></td><td align = \"center\">$dt1</td><td align = \"center\">$dt2</td></tr>
				</table>
				</td>
		</tr>
		
		</table>
			<br>
			<table align = \"center\">
		<tr><td align = \"center\" style = \"width:1.0cm;\"></td>
				<td>
				<table style = \"width: 10cm;\" border = \"0\">		
					<tr><td style = \"height: .75cm;\" align = \"left\"><b>Classroom Teacher's Signature&nbsp;&nbsp;&nbsp;</b></td><td align = \"center\">_____________________</td></tr>
					<tr><td style = \"height: .75cm;\" align = \"left\"><b>Khmer Teacher's Signature&nbsp;&nbsp;&nbsp;</b></td><td align = \"center\">_____________________</td></tr>
					<tr><td style = \"height: .75cm;\" align = \"left\"><b>Principal's Signature&nbsp;&nbsp;&nbsp;</b></td><td align = \"center\">_____________________</td></tr>
				</table>
				</td>
		</tr>
			
		</table>
	
	");
}

//expecting 13 elements in array s1X1-s1X13, s1X1-s1X13
function Grades1($g){
		return("
				
			<table border=\"1\">
				<tr><td align =\"right\" style = \"width:8cm; height:.75cm; font-size:x-large\" rowspan=\"2\"><b>Grading Period</b>&nbsp;&nbsp;&nbsp;</td><td  align = \"center\" style = \"width:2cm;\" colspan=\"2\">Semester 1</td><td  align = \"center\" style = \"width:2cm;\" colspan=\"2\">Semester 2</td></tr>
				<tr><td align = \"center\">Grade</td><td align = \"center\">Effort</td><td align = \"center\">Grade</td><td align = \"center\">Effort</td></tr>
				<tr><td align=\"right\" colspan = \"5\" style = \"font-size:x-large\">English Language Arts&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Speaking and Listening&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g1']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e1']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g1']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e1']."</td>
				</tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Reading&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g2']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e2']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g2']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e2']."</td>
				</tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Writing (including spelling)&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g3']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e3']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g3']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e3']."</td>
				</tr>
								
				<tr><td align=\"right\" colspan = \"5\" style = \"font-size:x-large\">Khmer Language Arts&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Speaking and Listening&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g4']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e4']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g4']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e4']."</td>
				</tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Reading&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g5']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e5']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g5']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e5']."</td>
				</tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Writing (including spelling)&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g6']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e6']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g6']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e6']."</td>
				</tr>
				
				<tr><td align=\"right\" colspan = \"5\" style = \"font-size:x-large\">Mathematics&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Numbers&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g7']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e7']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g7']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e7']."</td>
				</tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Shape, Space and Measure&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g8']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e8']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g8']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e8']."</td>
				</tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Data Handling&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g9']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e9']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g9']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e9']."</td>
				</tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Problem Solving&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g10']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e10']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g10']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e10']."</td>
				</tr>
				
				<tr><td align=\"right\" colspan = \"5\"></td></tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Topic (Science, Social Studies, Humanities, Art)<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g11']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e11']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g11']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e11']."</td>
				</tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Performing Arts&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g12']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e12']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g12']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e12']."</td>
				</tr>
				<tr><td align=\"right\" style = \"font-size:large;\">Physical Education&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g13']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e13']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g13']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e13']."</td>
				</tr>
				
				</table>
				
				
				");
}
//expecting 1-10
function Grades2($g){
	return("
	
			<table border=\"1\">
			<tr><td align =\"right\" style = \"width:8cm; height:.75cm; font-size:x-large\" rowspan=\"2\"><b>Grading Period</b>&nbsp;&nbsp;&nbsp;</td><td  align = \"center\" style = \"width:2cm;\" colspan=\"2\">Semester 1</td><td  align = \"center\" style = \"width:2cm;\" colspan=\"2\">Semester 2</td></tr>
				<tr><td align = \"center\">Grade</td><td align = \"center\">Effort</td><td align = \"center\">Grade</td><td align = \"center\">Effort</td></tr>
	
				<tr><td align=\"right\" colspan = \"5\" style = \"font-size:x-large\">Study and Learning Skills&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
	
				<tr><td align=\"right\" style = \"font-size:large;\">Works independently&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g1']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e1']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g1']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e1']."</td>
			</tr>

				<tr><td align=\"right\" style = \"font-size:large;\">Plays well in groups&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g2']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e2']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g2']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e2']."</td>
				</tr>
			
				<tr><td align=\"right\" style = \"font-size:large;\">Plays cooperatively with others&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g3']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e3']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g3']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e3']."</td>
				</tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Follows directions&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g4']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e4']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g4']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e4']."</td>
				</tr>
			
				<tr><td align=\"right\" style = \"font-size:large;\">Organizes and looks after belongings&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g5']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e5']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g5']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e5']."</td>
				</tr>
				
				<tr><td align=\"right\" style = \"font-size:large;\">Perseveres in problem solving&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g6']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e6']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g6']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e6']."</td>
				</tr>
			
				<tr><td align=\"right\" style = \"font-size:large;\">Makes good use of time&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g7']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e7']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g7']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e7']."</td>
				</tr>
			
				<tr><td align=\"right\" style = \"font-size:large;\">Seeks help when needed&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g8']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e8']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g8']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e8']."</td>
				</tr>
			
				<tr><td align=\"right\" style = \"font-size:large;\">Completes classwork&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g9']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e9']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g9']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e9']."</td>
				</tr>
			
				<tr><td align=\"right\" style = \"font-size:large;\">Works neatly and carefully&nbsp;&nbsp;&nbsp;<br>ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1g10']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s1e10']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2g10']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">".$g['s2e10']."</td>
				</tr>
				</table>
			
				&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;<br>
				<table>
				<tr>
					<td>
						<table border=\"1\">
						<tr><td colspan=\"2\" align=\"center\" style = \"width:5.5cm\">Achievement</td></tr>
						<tr><td style=\"width:.5cm\" align=\"center\">4</td><td style = \"width:5cm\">&nbsp;&nbsp;&nbsp;Consistently Above Standard<br>&nbsp;&nbsp;&nbsp;ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
						<tr><td style=\"width:.5cm\" align=\"center\">3</td><td style = \"width:5cm\">&nbsp;&nbsp;&nbsp;Meeting Standards&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
						<tr><td style=\"width:.5cm\" align=\"center\">2</td><td style = \"width:5cm\">&nbsp;&nbsp;&nbsp;Making Progress&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
						<tr><td style=\"width:.5cm\" align=\"center\">1</td><td style = \"width:5cm\">&nbsp;&nbsp;&nbsp;Making Minimum Progress&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
						<tr><td style=\"width:.5cm\" align=\"center\">NA</td><td style = \"width:5cm\">&nbsp;&nbsp;&nbsp;Not Applicable&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
						</table>
					</td>
					
					<td style = \"width:2.6cm\"></td>
					
					<td>
						<table border=\"1\">
						<tr><td colspan=\"2\" align=\"center\" style = \"width:5.5cm\">Effort</td></tr>
						<tr><td style=\"width:.5cm\" align=\"center\">E</td><td style = \"width:5cm\">&nbsp;&nbsp;&nbsp;Excellent&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
						<tr><td style=\"width:.5cm\" align=\"center\">G</td><td style = \"width:5cm\">&nbsp;&nbsp;&nbsp;Good&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
						<tr><td style=\"width:.5cm\" align=\"center\">S</td><td style = \"width:5cm\">&nbsp;&nbsp;&nbsp;Satisfactory&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
						<tr><td style=\"width:.5cm\" align=\"center\">N</td><td style = \"width:5cm\">&nbsp;&nbsp;&nbsp;Needs Improvement&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
						<tr><td style=\"width:.5cm\" align=\"center\">U</td><td style = \"width:5cm\">&nbsp;&nbsp;&nbsp;Unsatisfactory&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
						<tr><td style=\"width:.5cm\" align=\"center\">NA</td><td style = \"width:5cm\">&nbsp;&nbsp;&nbsp;Not Applicable&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;ទំនាក់ទំនងលេខ&nbsp;&nbsp;&nbsp;</td></tr>
						</table>
					</td>
				</tr>
				</table>
	
				");
}

?>