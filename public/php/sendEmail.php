<?php
if(isset($_POST["lotto"]){
        // $to = "sunil.t.udhayakumar@gmail.com";
         $to = "rasheed_andrews@live.com";
         $subject = "This is subject";
         
         $message = "<b>Lotto# : "+$_POST["lotto"]+"</b>";
         
         $header = "From:abc@somedomain.com \r\n";
         $header .= "Cc:afgh@somedomain.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true ) {
            echo 1;
         }else {
            echo 0;
         }
}
      ?>