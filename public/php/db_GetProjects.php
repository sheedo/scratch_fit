<?php
if(isset($_POST["dev_id"])) {
	$dev_id = $_POST["dev_id"];
	getProjects($dev_id);
} else {
	echo json_encode(array(array('response' => -1,'message' => 'No dev id was sent to server')));
}

/*
	Connect to the database
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
	Gets all the projects for the developer and returns them as an array of JSON objects
*/
function getProjects($dev_id) {
	try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "SELECT pid,name,description FROM project WHERE dev_id = ?;";
		$STH = $DBH->prepare($SQL);
		$STH->execute(array($dev_id));
		$return = false;
		$json_project = "";
		$json_array = array();
		foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
			array_push($json_array,array('response' => 1,'pid' => $row['pid'],'name' => $row['name'],'description' => $row['description']));
		  $return = true;
		}
		$json_project = json_encode($json_array);
		if($return) {
			echo $json_project;
		} else {
			array_push($json_array,array('response' => 0));
			echo json_encode($json_array);
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
?>
