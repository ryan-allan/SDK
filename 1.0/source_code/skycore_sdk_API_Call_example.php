<?php
include ('skycore_sdk.php');
	
//-------API ACCESS INFO-------
$key = "YOUR API KEY HERE";
$url = 'API URL HERE';

//-------Subscribe-------
/*
$action = 'subscribe';
$campaginid = 'YOUR CAMPAIGN ID HERE';
$mobile = 'YOUR MOBILE HERE';
$request = array(
	'action'     => $action,
	'campaignid' => $campaignid,
	'mobile'     => $mobile
);
*/

//-------Send Pass In Email-------
/*
$action = 'sendPassInEmail';
$emailid = 'YOUR EMAIL ID HERE';
$email = 'YOUR EMAIL HERE';
$campaignref = 'YOUR CAMPAIGN REF HERE';
$passdata = array(
		'barcodevalue' => '1234',
		'barcodetext'  => '5678'
	);
$request = array(
	'action'      => $action,
	'emailid'     => $emailid,
	'email'       => $email,
	'campaignref' => $campaignref,
	'passdata'    => $passdata
);
*/

//-------Save MMS-------
/*
$action = 'saveMMS';
$subject = 'THE SUBJECT HERE';
$name = 'THE NAME HERE';
$slide1 = array(
        	'image' => array(
            		'url' => 'image.example.com'
        	),
        	'audio' => array(
            		'url' => 'audio.example.com'
        	),
        	'text' => 'Some Text',
        	'duration' => '5'
    	);
$slide2 = array(
        	'image' => array(
            		'url' => 'image.example.com'
        	),
        	'audio' => array(
            		'url' => 'audio.example.com'
		 ),
        	'text' => 'Some Text',
        	'duration' => '10'
    	);
$request = array(
    	'action'  => $action,
  	'subject' => $subject,
    	'name' => $name,
    	'slide' => $slide1,
    	'slide' => $slide2
);
*/

//-------Get Email ID's-------
/*
$action = 'getemailids';
$request = array(
	'action' => $action
);
*/	

//Build a skycore object
$skycore = new Skycore_API_SDK($key, $url);

//Send a request to the object and get it's response
$skycoreResponse = $skycore->makeAPI_Call($request);

//Print out the whole response
//print_r ($skycoreResponse);

//----Ways to access different pieces of data in the response
//-----------------------------------------------------------

//----Retrieve the status of the response
//echo $skycoreResponse->STATUS;

//----Retrieve Error Info if the status returns as "Failure"
//echo $skycoreResponse->ERRORCODE;
//echo $skycoreResponse->ERRORINFO;

//----Retrive the Email ID's
//echo $skycoreResponse->EMAILIDS;

?>
