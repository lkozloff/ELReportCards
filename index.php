<?php
//connect to DB
$dbh = new PDO('mysql:host=localhost;dbname=el_reportcards', "root", "mysqldrowssaP");
$sdbh = new PDO('mysql:host=localhost;dbname=opensis_lisah', "root", "mysqldrowssaP");

//make sure Khmer will come through
$sdbh->query('SET NAMES utf8');


$templates = array();
$query = $dbh->prepare("SELECT * from templates order by template_name ASC");
$query->execute();
$templates_result = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($templates_result as $val){
	$template_id = $val['template_id'];
	$templates[$template_id] = $val['template_name'];
}


//grab staff names for list
$query = $sdbh->prepare("SELECT staff_id, first_name, last_name from staff WHERE syear = 2012 and current_school_id=2 and profile ='teacher'
		order by last_name");
$query->execute();
$teachers_result = $query->fetchAll(PDO::FETCH_ASSOC);
$teachers = array();
foreach($teachers_result as $val){
	$name = $val['last_name'].", ".$val['first_name'];
	$nicename = $val['first_name']." ".$val['last_name'];
	$teachers[$nicename] = $name;
	$teachers['id'] = $val['staff_id'];
}
?>
<html>
	<body>
		<form name="input" action="ReportCardTester.php" method="post">	
			<select name ="teacher_id">
				<?php foreach($teachers_result as $teacher) print("<option value = \"".$teacher['staff_id']."\">".$teacher['last_name'].", ".$teacher['first_name']."</option>")?>
			</select>
			<select name ="teacher_kh_id">
				<?php foreach($teachers_result as $teacher) print("<option value = \"".$teacher['staff_id']."\">".$teacher['last_name'].", ".$teacher['first_name']."</option>")?>
			</select>
			
			<select name ="template_id">
				<?php foreach($templates as $template_id =>$template) print("<option value =\"".$template_id."\">".$template."</option>")?>
			</select>
			<input type="submit" value="Submit">
		</form>
	</body>
</html>