<?php
if(isset($_POST["dev_id"])) {
	$dev_id = $_POST["dev_id"];
	getApiKeys($dev_id);
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
	Gets all the api keys for the developer and returns them as an array of JSON objects
*/
function getApiKeys($dev_id) {
	try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "SELECT pid,token FROM api WHERE dev_id = ?;";
		$STH = $DBH->prepare($SQL);
		$STH->execute(array($dev_id));
		$return = false;
		$json_keys = "";
		$json_array = array();
		foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
			array_push($json_array,array('response' => 1,'pid' => $row['pid'],'token' => $row['token']));
		  $return = true;
		}
		$json_keys = json_encode($json_array);
		if($return) {
			echo $json_keys;
		} else {
			array_push($json_array,array('response' => 0));
			echo json_encode($json_array);
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
?>
