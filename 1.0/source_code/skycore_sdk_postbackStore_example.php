<?php
include ('skycore_sdk.php');

//-------API ACCESS INFO-------
$key = 'YOUR API KEY HERE';
$url = 'YOUR API URL HERE';  

//-------DATABASE STORING INFO------

$dbHost = 'YOUR HOST NAME HERE';
$dbUser = 'USER NAME HERE';
$dbPW = 'PASSWORD HERE';
$db = 'DATABASE NAME HERE';
$dbTable = 'TABLE NAME HERE';
$dbSQL = 'SQL TYPE HERE'; //Types: 'MySQL' / 'PSQL'

//Build a skycore object
$skycore = new Skycore_API_SDK($key, $url);

//Grab the postback

$HTTP_RAW_POST_DATA = file_get_contents("php://input");
if ($_POST['xml'] == '' && $_GET['action']==''  && $_POST['action']=='' && $HTTP_RAW_POST_DATA!='')	{
	$_POST['xml'] = $HTTP_RAW_POST_DATA;
}
$SkycorePostback = $_POST['xml'];

//Example XML For Testing
//--------------------------------------------
/*
$SkycorePostback = 
<<<XML
<POSTBACK>
  <NOTIFICATION>
    <ORIGIN>MMS_MO</ORIGIN>
    <CODE>N401</CODE>
    <FROM>13217949521</FROM>
    <TO>74700</TO>
    <KEYWORD>all</KEYWORD>
    <TRACKINGID>MMS_MO_iLnCRrL6</TRACKINGID>
    <SPID>0001470</SPID>
    <TIMESTAMP>2014-02-03T11:19:49-05:00</TIMESTAMP>
    <CONTENT>
      <FILE>example1.com</FILE>
      <FILE>example2.com</FILE>
      <FILE>example3.com</FILE>
    </CONTENT>
  </NOTIFICATION>
</POSTBACK>
XML;
*/
//--------------------------------------------
//---------------Store Postback---------------
$skycore->storePostback($SkycorePostback, $dbHost, $dbUser, $dbPW, $db, $dbTable, $dbSQL);
?>