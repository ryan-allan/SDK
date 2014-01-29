<?php
include ('skycore_sdk.php');
     
//-------API ACCESS INFO-------
$key = "YOUR API KEY HERE";
$url = 'API URL HERE';  

//-------POSTBACK STORING INFO------
$dbHost = 'YOUR HOST NAME HERE';
$dbUser = 'USER NAME HERE';
$dbPW = 'PASSWORD HERE';
$db = 'DATABASE NAME HERE';
$dbTable = 'TABLE NAME HERE';

//Build a skycore object
$skycore = new Skycore_API_SDK($key, $url);

//Grab the postback
$SkycorePostback = $_POST['XML'];

//Example XML For Testing
//--------------------------------------------
/*
$SkycorePostback = 
<<<XML
<POSTBACK>
<ORIGIN>MMS_MT</ORIGIN>
<CODE>N333</CODE>
<STATUS>Message Sent</STATUS>
<TO>16503334444</TO>
<TRACKINGID>U01TXzgwNjc4</TRACKINGID>
<SPID>2221470</SPID>
<TIMESTAMP>2014-11-05T05:41:08-05:00</TIMESTAMP>
</POSTBACK>
XML;
*/
//--------------------------------------------

//-------Store Postback--------
$skycore->storePostback($SkycorePostback, $dbHost, $dbUser, $dbPW, $db, $dbTable);
?>
