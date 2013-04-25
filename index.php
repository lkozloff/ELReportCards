<?php
//connect to DB

include("data.php");
$dsn = $DatabaseType.":host=".$DatabaseServer.";dbname=".$ELDatabaseName;
$dbh = new PDO($dsn, "$DatabaseUsername", "$DatabasePassword");
$dbh->query('SET NAMES utf8');

$dsn = $DatabaseType.":host=".$DatabaseServer.";dbname=".$DatabaseName;
$sdbh = new PDO($dsn, "$DatabaseUsername", "$DatabasePassword");

$templates = array();
$query = $dbh->prepare("SELECT * from templates order by template_name ASC");
$query->execute();
$templates_result = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($templates_result as $val){
	$template_id = $val['template_id'];
	$templates[$template_id] = $val['template_name'];
}


//grab staff names for list
<<<<<<< HEAD
$query = $sdbh->prepare("SELECT staff_id, first_name, last_name from staff WHERE syear = 2012 and current_school_id=2 and profile ='teacher' and is_disable IS NULL
=======
$query = $sdbh->prepare("SELECT staff_id, first_name, last_name from staff WHERE syear = 2012 and current_school_id=2 and profile ='teacher and is_disable IS NULL'
>>>>>>> c0be5df71d98a978904c8f977ad03f6ed1590db6
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
			<select name ="template_id">
				<?php foreach($templates as $template_id =>$template) print("<option value =\"".$template_id."\">".$template."</option>")?>
			</select>
			<input type="submit" value="Submit">
		</form>
	</body>
</html>
