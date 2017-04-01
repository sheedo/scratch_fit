<?php
if(isset($_POST["email"]) && isset($_POST["password"])) {
	$email = $_POST["email"];
	$password = $_POST["password"];
	getUser($email, $password);
} else {
	echo json_encode(array('response' => -1,'message' => 'Email and password was not sent to server'));
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
	Check if developer account exist in database using email and password -return a response of 1 if found, 0 if not found
*/
function getUser($email, $password) {
	try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "SELECT password,dev_id FROM developer WHERE email = ?;";
		$STH = $DBH->prepare($SQL);
		$STH->execute(array($email));
		$return = false;
		$json_dev = "";
		foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
			//All passwords are hashed using password_hash, so to we must use password_verify to compare them
			if (password_verify($password, $row['password'])) {
					$json_dev = json_encode(array('response' => 1,'dev_id' => $row['dev_id']));
			    $return = true;
			}
		}
		if($return) {
			echo $json_dev;
		} else {
			echo json_encode($json_dev = array('response' => 0));
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
?>
