<?php
session_start();
if(isset($_POST["emailReg"]) &&
    isset($_POST["sms"]) &&
      isset($_POST["facebookSocial"]) &&
        isset($_POST["googleSocial"]) &&
          isset($_POST["linkedinSocial"]) &&
            isset($_POST["instagramSocial"])){
              setSession();
    } else{
      echo json_encode(array('response' => -1,'message' => 'Missing fields sent to server'));
    }
/*
  Set all the authentication options in session so that we can know what options the developer selected
*/
function setSession(){
  $_SESSION["emailReg"] = $_POST["emailReg"];
  $_SESSION["sms"] = $_POST["sms"];
  $_SESSION["facebookSocial"] = $_POST["facebookSocial"];
  $_SESSION["googleSocial"] = $_POST["googleSocial"];
  $_SESSION["linkedinSocial"] = $_POST["linkedinSocial"];
  $_SESSION["instagramSocial"] = $_POST["instagramSocial"];

  if(isset($_SESSION["emailReg"]) &&
      isset($_SESSION["sms"]) &&
        isset($_SESSION["facebookSocial"]) &&
          isset($_SESSION["googleSocial"]) &&
            isset($_SESSION["linkedinSocial"]) &&
              isset($_SESSION["instagramSocial"])){
                echo json_encode(array('response' => 1));
              } else{
                echo json_encode(array('response' => -1,'message' => 'Could not set all session fields'));
              }
  }
?>
