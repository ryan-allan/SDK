<?php
/*
Each form is matched with its respective array below.  You must de-comment the array to use it's respective form and 
keep the others commented.  To use multiple forms you may change the name of the arrays to request1, request2 etc...
and then send them to the skycore object 1 at a time.
*/
?>

------------------------------------SUBSCRIBE FORM-----------------------------------------------------------<BR/>
<form action="skycore_sdk_API_Call_example.php" method="get">

Enter your phone number:<input type="text" name="mobile"><BR/>
Format: 1-XXX-XXX-XXXX (excluding hyphens)<BR/>
							  
<input type="submit" name="submit" value="Subscribe">

</form>
-----------------------------------SEND PASS IN EMAIL FORM---------------------------------------------------<BR/>
<form action="skycore_sdk_API_Call_example.php" method="get">

Enter your Email:<input type="text" name="email"><BR/>
Format: example@example.com<BR/>
							  
<input type="submit" name="submit" value="Send Pass To Email">

</form>
-------------------------------------SAVE MMS FORM-----------------------------------------------------------<BR/>
<form action="skycore_sdk_API_Call_example.php" method="get">

Enter Name of the MMS:<input type="text" name="name"><BR/>
<strong>Slide 1 Information:</strong><BR/>
Enter Duration:<input type="text" name="duration1"><BR/>
Enter Image URL:<input type="text" name="url1"><BR/>
Enter Text:<input type="text" name="text1"><BR/>
<strong>Slide 2 Information:</strong><BR/>
Enter Duration:<input type="text" name="duration2"><BR/>
Enter Image URL:<input type="text" name="url2"><BR/>
Enter Text:<input type="text" name="text2"><BR/>
							  
<input type="submit" name="submit" value="Save MMS">

</form>
-------------------------------------------------------------------------------------------------------------<BR/>

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
