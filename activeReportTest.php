<html>
	<head><meta charset="UTF-8" />
	<link rel = "stylesheet" type="text/css" href="styles.css"/>
	</head>
<?php

	$dbh = new PDO('mysql:host=localhost;dbname=test', "root", "mysqldrowssaP");
	$dbh->query('SET NAMES utf8');
	print("<table border =1>");
	?>	<tr><td align ="right" style = "font-size:x-large" rowspan="2"><b>Grading Period</b>   </td><td  align = "center" colspan="2">Semester 1</td><td  align = "center" colspan="2">Semester 2</td></tr>
		<tr><td align = "center">Grade</td><td align = "center">Effort</td><td align = "center">Grade</td><td align = "center">Effort</td></tr>
	<?php 
	foreach($dbh->query('SELECT * from template_fields ORDER BY topic_id') as $row) {
		printRow($row);
	}
	print("</table>");
	
	$dbh = null; //closes the connection
	
	function printRow($row){
		if($row['is_graded']){
			print("
					<tr><td align=\"right\" style = \"font-size:large;\">".$row['text_en']."<br>".$row['text_kh']."</td>
					<td align = \"center\" style = \"font-size:.75cm;\">4</td>
					<td align = \"center\" style = \"font-size:.75cm;\">E</td>
					<td align = \"center\" style = \"font-size:.75cm;\">3</td>
					<td align = \"center\" style = \"font-size:.75cm;\">U</td>"
			);
		
		}
		else{
			print("
			<tr><td align=\"right\" colspan = \"5\" style =\"font-size:x-large\">".$row['text_en']."<br>".$row['text_kh']."</td></tr>
			");
		}
	}

?>
</html>