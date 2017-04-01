<?php
session_start();
if(isset($_POST["token"]) && isset($_POST["redirect_url"])){
  setSession();
} else{
  echo json_encode(array('response' => -1,'message' => 'Missing fields sent to server'));
}
/*
  sets the token and redirect url in a session, will be used on auth sample page as the token and redirect_url will be Inserted into the sample html code
*/
function setSession(){
  $_SESSION["token"] = $_POST["token"];
  $_SESSION["redirect_url"] = $_POST["redirect_url"];
  if(isset($_SESSION["token"]) && isset($_SESSION["redirect_url"])){
      echo json_encode(array('response' => 1));
    } else{
      echo json_encode(array('response' => -1,'message' => 'Could not set all session fields'));
    }
  }
?>
