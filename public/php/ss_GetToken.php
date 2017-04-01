<?php
/*
  Gets the token and redirect url from the session and returns it as
  a JSON object - will be used on auth sample page as the token and redirect_url will be Inserted into the sample html code
*/
session_start();
if(isset($_SESSION["token"]) && isset($_SESSION["redirect_url"])){
  $jsonSessionData = json_encode(array('response' => 1,'token' => $_SESSION["token"],'redirect_url' => $_SESSION["redirect_url"]));
  echo $jsonSessionData;
} else{
  echo json_encode(array('response' => -1,'message' => 'Some session fields are not set for token'));
}
?>
