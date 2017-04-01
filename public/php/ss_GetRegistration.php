<?php
/*
  Gets all the registration fields from the session and returns it as
  a JSON object - lets us know what fields were selected by the developer so we can generate sample code with the selected fields
*/
session_start();
$jsonSessionData = json_encode(array('id' => $_SESSION["id"],
                                    'password' => $_SESSION["password"],
                                    'address' => $_SESSION["address"],
                                    'phone' => $_SESSION["phone"],
                                    'state' => $_SESSION["state"],
                                    'trn' => $_SESSION["trn"],
                                    'fax' => $_SESSION["fax"],
                                    'religion' => $_SESSION["religion"],
                                    'cfield1' => $_SESSION["cfield1"],
                                    'cfield2' => $_SESSION["cfield2"],
                                    'cfield3' => $_SESSION["cfield3"],
                                    'cfield4' => $_SESSION["cfield4"],
                                    'cfield5' => $_SESSION["cfield5"],
                                    'cfield6' => $_SESSION["cfield6"],
                                    'cfield7' => $_SESSION["cfield7"],
                                    'cfield8' => $_SESSION["cfield8"],
                                    'cfield9' => $_SESSION["cfield9"],
                                    'cfield10' => $_SESSION["cfield10"],
                                    'cfield11' => $_SESSION["cfield11"],
                                    'cfield12' => $_SESSION["cfield12"],
                                  ));
echo $jsonSessionData;
?>
