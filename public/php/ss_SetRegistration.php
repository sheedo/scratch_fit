<?php
session_start();
setSession();
/*
  sets all the fields sent on the post request into a session, will be used later to know what fields were selected for regular registration
*/
function setSession(){
  $_SESSION["id"] = $_POST["id"];
  $_SESSION["password"] = $_POST["password"];
  $_SESSION["address"] = $_POST["address"];
  $_SESSION["phone"] = $_POST["phone"];
  $_SESSION["state"] = $_POST["state"];
  $_SESSION["trn"] = $_POST["trn"];
  $_SESSION["fax"] = $_POST["fax"];
  $_SESSION["religion"] = $_POST["religion"];

  $_SESSION["cfield1"] = $_POST["cfield1"];
  $_SESSION["cfield2"] = $_POST["cfield2"];
  $_SESSION["cfield3"] = $_POST["cfield3"];
  $_SESSION["cfield4"] = $_POST["cfield4"];
  $_SESSION["cfield5"] = $_POST["cfield5"];
  $_SESSION["cfield6"] = $_POST["cfield6"];
  $_SESSION["cfield7"] = $_POST["cfield7"];
  $_SESSION["cfield8"] = $_POST["cfield8"];
  $_SESSION["cfield9"] = $_POST["cfield9"];
  $_SESSION["cfield10"] = $_POST["cfield10"];
  $_SESSION["cfield11"] = $_POST["cfield11"];
  $_SESSION["cfield12"] = $_POST["cfield12"];
  $bool = true;
  //Checks that all fields sent in the post request is set in the session
  foreach($_POST as $key => $val){
    if(!isset($_SESSION[$key])){
      $bool = false;
      break;
    }
  }
  if($bool){
    echo json_encode(array('response' => 1));
  } else{
    echo json_encode(array('response' => -1,'message' => 'Could not set all session fields'));
  }
}
?>
