<?php
/*
  Gets all the authentication options from the session and returns it as
  a JSON object - lets us know what cards to show on the auth page - what social cards should be shown or/and should registration card be shown
*/
session_start();
if(isset($_SESSION["emailReg"]) &&
    isset($_SESSION["sms"]) &&
      isset($_SESSION["facebookSocial"]) &&
        isset($_SESSION["googleSocial"]) &&
          isset($_SESSION["linkedinSocial"]) &&
            isset($_SESSION["instagramSocial"])){
              $jsonSessionData = json_encode(array('response' => 1,
                                                  'emailReg' => $_SESSION["emailReg"],
                                                  'sms' => $_SESSION['sms'],
                                                  'facebookSocial' => $_SESSION["facebookSocial"],
                                                  'googleSocial' => $_SESSION["googleSocial"],
                                                  'linkedinSocial' => $_SESSION["linkedinSocial"],
                                                  'instagramSocial' => $_SESSION["instagramSocial"],
                                                ));
              echo $jsonSessionData;
            } else{
              echo json_encode(array('response' => -1,'message' => 'Some session fields are not set for authentication select'));
            }
?>
