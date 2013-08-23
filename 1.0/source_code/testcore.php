<form action="testcore.php" method="get">
Your number must be of the format 1-XXX-XXX-XXXX (excluding hyphens) :<input type="text" name="mobile">
Enter Name:<input type="text" name="name">
Enter Duration:<input type="text" name="duration">
Enter Image URL :<input type="text" name="url">
<input type="submit" name="submit" value="Submit">
</form>

<?php

include ('skycore_sdk.php');
//-------Dev Key-------
$key = "YOUR_API_KEY_HERE";
$url = 'API_URL_HERE';

//-------Simple Test-------

/*
$request = array(
	'action'	 => 'subscribe',
	'campaignid' => '1605',
	'mobile'     => $_GET["mobile"]
);
*/

//-------Multidimensional Test-------
/*
$request = array(
	'action' => 'sendPassInEmail',
	'emailid' => '42876',
	'email' => 'ryan.allen@skycore.com',
	'campaignref' => '805',
	'passdata' => array(
		'barcodevalue' => '1234',
		'barcodetext' => '5678'
	)
);

*/
//-------saveMMS Test-------

$duration = 'slide duration="' . $_GET["duration"] .'"';

$request = array(
	'action' => 'saveMMS',
	'subject' => 'testMMS2',
	'content' => array(
		'name' => $_GET["name"],
		'sequence' => array(
			$duration => array(
				'image' => array(
					'url' => $_GET["url"]
				),
				'text' => 'Some Text'
			),
			'slide1' => array(
				'image' => array(
					'url' => $_GET["url"]
				),
				'text' => 'Some Text'
			)
		)
	)
);


//-------getEmailIds Test-------
/*
	$request = array(
		'action' => 'getemailids'
	);
*/	

//Build a skycore object
$skycore = new Skycore($key, $url);

//Send a request to the object and get it's response
$skycoreResponse = $skycore->makeAPI_Call($request);

//Show the whol response
//print_r ($skycoreResponse);

//Access a piece of data in the response
echo $skycoreResponse->STATUS;
//echo $skycoreResponse->ERRORCODE;
//echo $skycoreResponse->ERRORINFO;
//echo $skycoreResponse->EMAILIDS;

?>
