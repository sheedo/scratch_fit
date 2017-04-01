<?php
//Global Totals
$_totalSignUpsDaily = 0;
$_totalDailyUsers = 0;

if(isset($_POST["pid"]) && isset($_POST["dev_id"])) {
  $pid = $_POST["pid"];
	$dev_id = $_POST["dev_id"];
  getTotalSignUpsByDayPerRegion();
  // getTotalSignUpsByDay($pid,$dev_id);
  // getTotalDailyUsers($pid,$dev_id);
  // echo "sign : ".$_totalSignUpsDaily." daily ".$_totalDailyUsers;
} else {
	header("Location:../index.html");
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

function getTotalSignUpsByDay($pid,$dev_id) {
	try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "SELECT count(*) FROM cust_global WHERE pid = ? AND dev_id = ? AND cast(created_timestamp as date) = current_date;";
		$STH = $DBH->prepare($SQL);
		$STH->execute(array($pid,$dev_id));
		$return = false;
		$data = "";
		foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
      $data = $row;
		  $return = true;
		}
		if($return) {
      global $_totalSignUpsDaily;
      $_totalSignUpsDaily = $data["count"];
		}
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function getTotalDailyUsers($pid,$dev_id){
  try {
    $DBH = DBC('postgres'); //enter db name
    $SQL = "SELECT count(*) FROM cust_global WHERE pid = ? AND dev_id = ? AND cast(lastseen_timestamp as date) = current_date;";
    $STH = $DBH->prepare($SQL);
    $STH->execute(array($pid,$dev_id));
    $return = false;
    $data = "";
    foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
      $data = $row;
      $return = true;
    }
    if($return) {
      // global $_totalDailyUsers;
      // $_totalDailyUsers = $data["count"];

    }
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
}

function getTotalSignUpsByDayPerRegion(){
  try {
		$DBH = DBC('postgres'); //enter db name
		$SQL = "SELECT id FROM cust_global WHERE pid = ? AND dev_id = ? AND login_code = ? AND cast(created_timestamp as date) = current_date;";
		$STH = $DBH->prepare($SQL);
		// $STH->execute(array($pid,$dev_id,"sms"));
    $STH->execute(array("30","3","sms"));
		$return = false;
		$phoneArray = array();
		foreach ($STH->fetchAll(PDO::FETCH_ASSOC) as $row) {
      array_push($phoneArray,$row['id']);
      // $jsonData .= $row['id'].' ';
		  $return = true;
		}
		if($return) {
      regionCounter($phoneArray);
      // echo $jsonData;
		} else {
      echo "no data";
		}
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

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
  echo json_encode($regionArray);
}

function insertSummary($pid,$dev_id,$total){
    try {
      $DBH = DBC('postgres'); //enter db name
      $SQL = "INSERT into summary(pid,dev_id,date,totaldailyusers) VALUES(?,?,?,?);";
      $STH = $DBH->prepare($SQL);
      $return = $STH->execute(array($pid,$dev_id,date("Y-m-d"),$total));
      if($return) {
        echo 1;
      } else {
        echo 0;
      }
    } catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
?>
