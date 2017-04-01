<?php
if(isset($_POST["pid"])  && isset($_POST["dev_id"]) && isset($_POST["token"])) {
	$pid = $_POST["pid"];
	$dev_id = $_POST["dev_id"];
	$token = $_POST["token"];
	$registration = $_POST["registration"];
	$sms = $_POST["sms"];
	$facebook_appid = $_POST["facebook_appid"];
	$google_clientid = $_POST["google_clientid"];
	$linkedin_apikey = $_POST["linkedin_apikey"];
	$instagram_clientid = $_POST["instagram_clientid"];
	$instagram_clientsecret = $_POST["instagram_clientsecret"];
	// PHP will interpret javascript null as a string and not NULL
	$facebook_appid = $facebook_appid == "null" ? NULL : $facebook_appid;
	$google_clientid = $google_clientid == "null" ? NULL : $google_clientid;
	$linkedin_apikey = $linkedin_apikey == "null" ? NULL : $linkedin_apikey;
	$instagram_clientid = $instagram_clientid == "null" ? NULL : $instagram_clientid;
	$instagram_clientsecret = $instagram_clientsecret == "null" ? NULL : $instagram_clientsecret;
	saveAPI($pid, $dev_id, $token, $sms, $registration, $facebook_appid, $google_clientid, $linkedin_apikey, $instagram_clientid,$instagram_clientsecret);
} else {
	echo json_encode(array('response' => -1,'message' => 'No pid or dev_id or token was sent to server'));
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
	Store all details about the API - such as if they selected sms or registration and also keys for the social api if selected
*/
function saveAPI($pid, $dev_id, $token, $sms,$registration, $facebook_appid, $google_clientid, $linkedin_apikey, $instagram_clientid,$instagram_clientsecret) {
	try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "INSERT INTO api(pid,dev_id,token,sms,registration,facebook_appid,google_clientid,linkedin_apikey,instagram_clientid,instagram_clientsecret) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$STH = $DBH->prepare($SQL);
		$return = $STH->execute(array($pid, $dev_id, $token, $sms, $registration, $facebook_appid, $google_clientid, $linkedin_apikey, $instagram_clientid,$instagram_clientsecret));
		if($return){
			echo json_encode(array('response' => 1));
		} else {
			echo json_encode(array('response' => 0,'message' => 'Could not save API information'));
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
?>
