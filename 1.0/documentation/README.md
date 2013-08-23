<h2>Skycore SDK v1.0 Documentation</h2>

This SDK will allow for implementation of the Skycore API via instantiation of a Skycore object and passing 
an array containing the proper parameters to the makeAPI_Call function. One can then assign the return value 
of this function to an object and access any of the data from the response via this object.

A current list of the calls and their parameters can be found <a href="https://github.com/SkycoreMobile/API/blob/master/1.3/CONTENTS/METHODS/API_METHODS.md">here</a> .

<strong>Format Example:</strong>


<pre>

include ('skycore_sdk.php');

$key = "YOUR_API_KEY_HERE";

<strong>//Example 1</strong>
$request = array(
	'action'	 => 'subscribe',
	'campaignid' => '1605',
	'mobile'     => $_GET["mobile"]
);


<strong>//Example 2</strong>
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


<strong>//Example 3</strong>
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


<strong>//Example 4</strong>
$request = array(
	'action' => 'getemailids'
);
	

//Build a skycore object
$skycore = new Skycore($key);

//Send a request to the object and get it's response
$skycoreResponse = $skycore->makeAPI_Call($request);

//Show the whole response
//print_r ($skycoreResponse);

//Access a piece of data in the response
echo $skycoreResponse->STATUS;
//echo $skycoreResponse->ERRORCODE;
//echo $skycoreResponse->ERRORINFO;
//echo $skycoreResponse->EMAILIDS;

</pre>
