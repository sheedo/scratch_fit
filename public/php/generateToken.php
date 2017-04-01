<?php
/*
  Generates a random alphanumeric string, chooses a random number between 1 and length of string(40) and
  selects a character from the $characters varaible, each character is concatenated to make the 40 character
  long string
*/
function generateRandomString($length = 40) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
echo generateRandomString();
 ?>
