<?php
if(isset($_POST["password"]) && isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"])) {
	$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$email = $_POST["email"];
	if(!checkDeveloperAccountExist($email)){
		saveUser($password, $fname, $lname, $email);
	} else{
		echo json_encode(array('response' => 0));
	}
} else {
	echo json_encode(array('response' => -1,'message' => 'Missing fields are sent to server'));
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
	Check if developer email address already exist before storing it - prevent duplicate
*/
function checkDeveloperAccountExist($email){
	try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "SELECT dev_id FROM developer WHERE email = ?;";
		$STH = $DBH->prepare($SQL);
		$STH->execute(array($email));
		$returnValue = false;
		foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
			$returnValue = true;
		}
		return $returnValue;
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
/*
	Store information about the developer account
*/
function saveUser($password, $fname, $lname, $email) {
	try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "INSERT INTO developer(password,fname,lname,email) VALUES(?, ?, ?, ?);";
		$STH = $DBH->prepare($SQL);
		$return = $STH->execute(array($password,$fname,$lname,$email));
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
