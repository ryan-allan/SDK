------------------------------------SUBSCRIBE FORM-----------------------------------------------------------<BR/>
<form action="skycore_sdk_example.php" method="get">

Enter your phone number:<input type="text" name="mobile"><BR/>
Format: 1-XXX-XXX-XXXX (excluding hyphens)<BR/>
							  
<input type="submit" name="submit" value="Subscribe">

</form>
-----------------------------------SEND PASS IN EMAIL FORM---------------------------------------------------<BR/>
<form action="skycore_sdk_example.php" method="get">

Enter your Email:<input type="text" name="email"><BR/>
Format: example@example.com<BR/>
							  
<input type="submit" name="submit" value="Send Pass To Email">

</form>
-------------------------------------SAVE MMS FORM-----------------------------------------------------------<BR/>
<form action="skycore_sdk_example.php" method="get">

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
$request = array(
	'action'	 => 'subscribe',
	'campaignid' => '1605',
	'mobile'     => $_GET["mobile"]
);
*/

//-------Send Pass In Email-------
/*
$request = array(
	'action' => 'sendPassInEmail',
	'emailid' => '42876',
	'email' => $_GET["email"],
	'campaignref' => '805',
	'passdata' => array(
		'barcodevalue' => '1234',
		'barcodetext' => '5678'
	)
);

*/

//-------Save MMS-------
/*
$durationSlide1 = 'slide duration="' . $_GET["duration1"] .'"';
$durationSlide2 = 'slide duration="' . $_GET["duration2"] .'"';

$request = array(
	'action' => 'saveMMS',
	'subject' => 'testMMS',
	'content' => array(
		'name' => $_GET["name"],
		'sequence' => array(
			$durationSlide1 => array(
				'image' => array(
					'url' => $_GET["url1"]
				),
				'text' => $_GET["text1"]
			),
			$durationSlide2 => array(
				'image' => array(
					'url' => $_GET["url2"]
				),
				'text' => $_GET["text2"]
			)
		)
	)
);
*/

//-------Get Email ID's-------
/*
	$request = array(
		'action' => 'getemailids'
	);
*/	

//Build a skycore object
$skycore = new Skycore_API_SDK($key, $url);

//Send a request to the object and get it's response
$skycoreResponse = $skycore->makeAPI_Call($request);

//Print out the whole response
print_r ($skycoreResponse);

//Access a piece of data in the response

//----Retrieve the status of the response
//echo $skycoreResponse->STATUS;

//----Retrieve Error Info if the status returns as "Failure"
//echo $skycoreResponse->ERRORCODE;
//echo $skycoreResponse->ERRORINFO;

//----Retrive the Email ID's----
//echo $skycoreResponse->EMAILIDS;

?>
