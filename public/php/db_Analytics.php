<?php
/*
  Each function handles which ever filter option the user selects for which ever chart
*/
if(isset($_POST["pid"]) && isset($_POST["dev_id"]) && isset($_POST["chart"])) {
  $pid = $_POST["pid"];
	$dev_id = $_POST["dev_id"];
  //All calendar chart related functions
  if($_POST["chart"] == "cal"){
      if($_POST["filter"] == "totSignUp"){
        getTotalSignUpsByDay($pid,$dev_id,$_POST["fromYear"],$_POST["toYear"]);
      } else if($_POST["filter"] == "totDailyUser"){
        getTotalDailyUsers($pid,$dev_id,$_POST["fromYear"],$_POST["toYear"]);
      } else if($_POST["filter"] == "totSignUpRegion"){
        if(!empty($_POST["region"])){
          getTotalSignUpsByRegion($pid,$dev_id,$_POST["fromYear"],$_POST["toYear"],$_POST["region"]);
        } else{
          echo json_encode(array('response' => -1,'message' => 'No area code was posted'));
        }
      } else if($_POST["filter"] == "totDailyUserRegion"){
        if(!empty($_POST["region"])){
          getTotalDailyUsersByRegion($pid,$dev_id,$_POST["fromYear"],$_POST["toYear"],$_POST["region"]);
        } else{
          echo json_encode(array('response' => -1,'message' => 'No area code was posted'));
        }
      }
    //All bar chart related functions
    } else if($_POST["chart"] == "bar"){
      if($_POST["filter"] == "totSignUp"){
       getTotalSignUpsPerRegion($pid,$dev_id,$_POST["fromYear"],$_POST["toYear"]);
     } else if($_POST["filter"] == "totDailyUser"){
       getTotalDailyUsersPerRegion($pid,$dev_id,$_POST["fromYear"],$_POST["toYear"]);
     }
    }
} else {
	echo json_encode(array('response' => -1,'message' => 'Missing fields, no pid or dev_id or chart was posted to server'));
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
//NB: 4 functions below are used by Calendar chart - these should also be done in a cron job that stores the total in a summary table
/*
  Gets the total sign up for each day for the year range specified in the query - returns an object with each date(eg=2015-07-01) as key and the total sign up for that date as value
  The created_timestamp lets us know when an account has been created
*/
function getTotalSignUpsByDay($pid,$dev_id,$fromYear,$toYear) {
	try {
		$DBH = DBC('postgres'); //enter db name
    $SQL = "SELECT date(created_timestamp), count(*) FROM cust_global WHERE pid = ? AND dev_id = ? AND created_timestamp >= ? AND  created_timestamp <= ? GROUP BY date(created_timestamp);";
		$STH = $DBH->prepare($SQL);
  	$STH->execute(array($pid,$dev_id,$fromYear,$toYear));
		$jsonData = array();
		foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $jsonData[$row["date"]] = $row["count"];
		}
    //Add response code
    $jsonData["response"] = 1;
		echo json_encode($jsonData);
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
/*
  Gets the total daily users for the year range specified in the query - returns an object with each date(eg=2015-07-01) as key and the total daily users for that date as value
  The lastseen_timestamp lets us know when an account was last used, it is updated on login or on logout
*/
function getTotalDailyUsers($pid,$dev_id,$fromYear,$toYear) {
	try {
		$DBH = DBC('postgres'); //enter db name
    $SQL = "SELECT date(lastseen_timestamp), count(*) FROM cust_global WHERE pid = ? AND dev_id = ? AND lastseen_timestamp >= ? AND  lastseen_timestamp <= ? GROUP BY date(lastseen_timestamp);";
		$STH = $DBH->prepare($SQL);
		$STH->execute(array($pid,$dev_id,$fromYear,$toYear));
		$jsonData = array();
		foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
      $jsonData[$row["date"]] = $row["count"];
		}
    //Add response code
    $jsonData["response"] = 1;
		echo json_encode($jsonData);
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
/*
  Total sign ups for a particular region between the year range specified - region filter will only apply to sms since the area code is used to determine the region
*/
function getTotalSignUpsByRegion($pid,$dev_id,$fromYear,$toYear,$area_code){
  try {
    $DBH = DBC('postgres'); //enter db name
    $SQL = "SELECT date(created_timestamp), count(*) FROM cust_global WHERE pid = ? AND dev_id = ? AND login_code = 'sms' AND created_timestamp >= ? AND  created_timestamp <= ? AND id like ? GROUP BY date(created_timestamp);";
    $STH = $DBH->prepare($SQL);
    $STH->execute(array($pid,$dev_id,$fromYear,$toYear,$area_code.'%'));// % means find all phone numbers starting with the given area code
    $jsonData = array();
    foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
      $jsonData[$row["date"]] = $row["count"];
    }
    //Add response code
    $jsonData["response"] = 1;
    echo json_encode($jsonData);
  } catch(PDOException $e) {
    echo $e->getMessage();
  }
}
/*
  Total daily users for a particular region between the year range specified - region filter will only apply to sms since the area code is used to determine the region
*/
function getTotalDailyUsersByRegion($pid,$dev_id,$fromYear,$toYear,$area_code){
  try {
    $DBH = DBC('postgres'); //enter db name
    $SQL = "SELECT date(lastseen_timestamp), count(*) FROM cust_global WHERE pid = ? AND dev_id = ? AND login_code = 'sms' AND lastseen_timestamp >= ? AND  lastseen_timestamp <= ? AND id like ? GROUP BY date(lastseen_timestamp);";
    $STH = $DBH->prepare($SQL);
    $STH->execute(array($pid,$dev_id,$fromYear,$toYear,$area_code.'%'));// % means find all phone numbers starting with the given area code
    $jsonData = array();
    foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
      $jsonData[$row["date"]] = $row["count"];
    }
    //Add response code
    $jsonData["response"] = 1;
    echo json_encode($jsonData);
  } catch(PDOException $e) {
    echo $e->getMessage();
  }
}
//NB: 3 functions below are used by Bar chart - these should also be done in a cron job that stores the total in a summary table
/*
  Gets all the ids(phone numbers) of sign ups between the date range specified - each region occurence will be totalled by the regionCounter function
*/
function getTotalSignUpsPerRegion($pid,$dev_id,$fromYear,$toYear){
  try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "SELECT id FROM cust_global WHERE pid = ? AND dev_id = ? AND login_code = ? AND created_timestamp >= ? AND created_timestamp <= ?;";
		$STH = $DBH->prepare($SQL);
    $STH->execute(array($pid,$dev_id,"sms",$fromYear,$toYear));
		$return = false;
		$phoneArray = array();
		foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
      array_push($phoneArray,$row['id']);
		  $return = true;
		}
    echo regionCounter($phoneArray);
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
/*
  Gets all the ids(phone numbers) of daily users between the date range specified - each region occurence will be totalled by the regionCounter function
*/
function getTotalDailyUsersPerRegion($pid,$dev_id,$fromYear,$toYear){
  try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "SELECT id FROM cust_global WHERE pid = ? AND dev_id = ? AND login_code = ? AND lastseen_timestamp >= ? AND lastseen_timestamp <= ?;";
		$STH = $DBH->prepare($SQL);
    $STH->execute(array($pid,$dev_id,"sms",$fromYear,$toYear));
		$return = false;
		$phoneArray = array();
    $data = "";
		foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
      array_push($phoneArray,$row['id']);
		  $return = true;
		}
    echo regionCounter($phoneArray);
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
/*
  Takes an array of phoneNumbers and checks the first 3 or 4 digits(depends on which region) of each phoneNumber to determine the region, when a region is found its counter
  value is incremented
*/
function regionCounter($phoneArray){
  $regionArray = array("Jamaica" => 0,"Anguilla" => 0,"Antigua"=> 0,"Aruba"=> 0,"BVI"=> 0,"Barbados"=> 0,"Bermuda"=> 0,"Bonaire"=> 0,"Cayman"=> 0,"Dominica"=> 0,
                      "ElSalvador"=> 0,"FWI-FrenchGuiana"=> 0,"FWI-Guadeloupe"=> 0,"FWI-Martinique"=> 0,"Fiji"=> 0,"Grenada"=> 0,"Guyana"=> 0,"Haiti"=> 0,
                      "Honduras"=> 0,"Nauru"=> 0,"PNG"=> 0,"Panama"=> 0,"Samoa"=> 0,"StKitts"=> 0,"StLucia"=> 0,"StVincent"=> 0,"Suriname"=> 0,"Tonga"=> 0,
                      "Trinidad"=> 0,"Turks+Caicos"=> 0,"Vanuatu"=> 0);
  foreach($phoneArray as $phoneNumber){
    switch($phoneNumber){
      case substr($phoneNumber,0,4) == "1876":
        $regionArray["Jamaica"]++;
      break;
      case substr($phoneNumber,0,4) == "1264":
        $regionArray["Anguilla"]++;
      break;
      case substr($phoneNumber,0,4) == "1268":
        $regionArray["Antigua"]++;
      break;
      case substr($phoneNumber,0,3) == "297":
        $regionArray["Aruba"]++;
      break;
      case substr($phoneNumber,0,4) == "1284":
        $regionArray["BVI"]++;
      break;
      case substr($phoneNumber,0,4) == "1246":
        $regionArray["Barbados"]++;
      break;
      case substr($phoneNumber,0,4) == "1441":
        $regionArray["Bermuda"]++;
      break;
      case substr($phoneNumber,0,3) == "599":
        $regionArray["Bonaire"]++;
      break;
      case substr($phoneNumber,0,4) == "1345":
        $regionArray["Cayman"]++;
      break;
      case substr($phoneNumber,0,4) == "1767":
        $regionArray["Dominica"]++;
      break;
      case substr($phoneNumber,0,3) == "503":
        $regionArray["ElSalvador"]++;
      break;
      case substr($phoneNumber,0,3) == "594":
        $regionArray["FWI-FrenchGuiana"]++;
      break;
      case substr($phoneNumber,0,3) == "590":
        $regionArray["FWI-Guadeloupe"]++;
      break;
      case substr($phoneNumber,0,3) == "596":
        $regionArray["FWI-Martinique"]++;
      break;
      case substr($phoneNumber,0,3) == "679":
        $regionArray["Fiji"]++;
      break;
      case substr($phoneNumber,0,4) == "1473":
        $regionArray["Grenada"]++;
      break;
      case substr($phoneNumber,0,3) == "592":
        $regionArray["Guyana"]++;
      break;
      case substr($phoneNumber,0,3) == "509":
        $regionArray["Haiti"]++;
      break;
      case substr($phoneNumber,0,3) == "504":
        $regionArray["Honduras"]++;
      break;
      case substr($phoneNumber,0,3) == "674":
        $regionArray["Nauru"]++;
      break;
      case substr($phoneNumber,0,3) == "675":
        $regionArray["PNG"]++;
      break;
      case substr($phoneNumber,0,3) == "507":
        $regionArray["Panama"]++;
      break;
      case substr($phoneNumber,0,3) == "685":
        $regionArray["Samoa"]++;
      break;
      case substr($phoneNumber,0,4) == "1869":
        $regionArray["StKitts"]++;
      break;
      case substr($phoneNumber,0,4) == "1758":
        $regionArray["StLucia"]++;
      break;
      case substr($phoneNumber,0,4) == "1784":
        $regionArray["StVincent"]++;
      break;
      case substr($phoneNumber,0,3) == "597":
        $regionArray["Suriname"]++;
      break;
      case substr($phoneNumber,0,3) == "676":
        $regionArray["Tonga"]++;
      break;
      case substr($phoneNumber,0,4) == "1868":
        $regionArray["Trinidad"]++;
      break;
      case substr($phoneNumber,0,4) == "1649":
        $regionArray["Turks+Caicos"]++;
      break;
      case substr($phoneNumber,0,3) == "678":
        $regionArray["Vanuatu"]++;
      break;
    }
  }
  //Add response code
  $regionArray["response"] = 1;
  return json_encode($regionArray);
}
 ?>
