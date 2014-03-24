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

//---------------Store Postback---------------
$skycore->storePostback($SkycorePostback, $dbHost, $dbUser, $dbPW, $db, $dbTable, $dbSQL);
?>
