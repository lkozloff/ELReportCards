<?php
session_start();

$template_id = $_SESSION['template_id'];

//hack to let the list be alphabetized.
$collate = explode(".",$_SESSION['sid']);
$sid = $collate[1];

$id = $_REQUEST['id'];
$value = $_REQUEST['value'];

$dbh = new PDO('mysql:host=localhost;dbname=test', "root", "mysqldrowssaP");
$dbh->query('SET NAMES utf8');

if(strcmp($id, "sid")==0){
	$_SESSION['sid'] = $value;
	//$value = "just entered SID ".$value;
}

else if(strlen($id)>2){
	$term = substr($id,0,2); //S1 or S2
	$type = substr($id,2,1); //Grade or Effort or Comment
	$topic_id = substr($id,3); //Topic ID (number, or E/K)
	
	$sql = "INSERT INTO el_grades (template_id, topic_id, student_id, term, type, value)
			VALUES ('$template_id', '$topic_id', '$sid', '$term', '$type', '$value')
			ON DUPLICATE KEY UPDATE value='$value'";

	
	
	$query = $dbh->prepare($sql);
	$query->execute();
	
	if(strcmp($value,"Ch") == 0) $value = "<img src = \"img\check.png\">";
}
else{
	$comment_id = substr($id,1);
	//process comment to get rid of bad things like single quotes and make line breaks htmlified.
	$cleanvalue = str_replace("\\n","<br>",$dbh->quote($value));  
	// we're getting a comment!
		$sql = "INSERT INTO el_comments (template_id, student_id, comment_id, comment)
				VALUES ('$template_id', '$sid', '$comment_id', $cleanvalue)
				ON DUPLICATE KEY UPDATE comment=$cleanvalue";
		$query = $dbh->prepare($sql);
		$query->execute();
		
			
		
}




print("$value");
//print($_REQUEST['value']);
?>