<?php
if(isset($_POST["descript"]) && isset($_POST["project_name"]) && isset($_POST["dev_id"])) {
	$descript = $_POST["descript"];
	$project_name = $_POST["project_name"];
	$dev_id = $_POST["dev_id"];
	saveProject($descript, $project_name, $dev_id);
} else {
	echo json_encode(array('response' => -1,'message' => 'Missing fields sent to server'));
}
/*
	Connect to database
*/
function DBC($dbname) {
	$dbhost="192.168.0.2";
	$dbuser= "web";
	$dbpass= "digipoint";
	$dbh = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}
/*
	Save project information to database
*/
function saveProject($descript, $project_name, $dev_id) {
	try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "INSERT INTO project(description,name,dev_id) VALUES(?, ?, ?);";
		$STH = $DBH->prepare($SQL);
		$return = $STH->execute(array($descript,$project_name,$dev_id));
		if($return) {
			echo json_encode(array('response' => 1));
		} else {
			echo json_encode(array('response' => 0));
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
?>
