<?php
if(isset($_POST["pid"]) && isset($_POST["dev_id"]) && isset($_POST["field_default"]) && isset($_POST["field_dev"])) {
	$pid = $_POST["pid"];
	$dev_id = $_POST["dev_id"];
	$field_default = $_POST["field_default"];
	$field_dev = $_POST["field_dev"];
	$field_type = $_POST["field_type"];
	$field_required = $_POST["field_required"];
	$field_length = $_POST["field_length"];
	saveDevRegBuild($pid, $dev_id, $field_default, $field_dev,$field_required,$field_type,$field_length);
} else {
	echo json_encode(array('response' => -1,'message' => 'No pid or dev_id or field_default or field_dev was sent to server'));
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
	Insert all the default field names with the field name set by the developer as well as other attribues such as required, type, length
*/
function saveDevRegBuild($pid, $dev_id, $field_default, $field_dev, $field_required, $field_type, $field_length) {
	try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "INSERT INTO devregbuild(pid,dev_id,field_default,field_dev,required,type,length) VALUES(?, ?, ?, ?, ?, ?, ?);";
		$STH = $DBH->prepare($SQL);
		$return = $STH->execute(array($pid, $dev_id, $field_default, $field_dev,$field_required,$field_type,$field_length));
		if($return) {
			echo json_encode(array('response' => 1));
		} else {
			echo json_encode(array('response' => 0,'message' => 'Could not save developer fields'));
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
?>
