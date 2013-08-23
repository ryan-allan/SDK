<a href="/1.0/README.md">Back To Skycore SDK v1.0 Main Page</a>


<h2>Skycore SDK v1.0 Documentation</h2>

This SDK will allow for implementation of the Skycore API via instantiation of a Skycore object and passing 
an array containing the proper parameters to the makeAPI_Call function. One can then assign the return value 
of this function to an object and access any of the data from the response via this object.

A current list of the calls and their parameters can be found <a href="https://github.com/SkycoreMobile/API/blob/master/1.3/CONTENTS/METHODS/API_METHODS.md">here</a> .

<h2>Format Examples:</h2>




<strong>Include the SDK and initialize your API Key</strong>
<pre>
include ('skycore_sdk.php');

$key = "YOUR_API_KEY_HERE";
</pre>

<strong>Build Example Request 1:</strong>
<pre>
$request = array(
	'action'	 => 'subscribe',
	'campaignid' => '1605',
	'mobile'     => $_GET["mobile"]
);
</pre>

<strong>Build Example Request 2:</strong>
<pre>
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
</pre>

<strong>Build Example Request 3:</strong>
<pre>
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
</pre>

<strong>Build Example Request 4:</strong>
<pre>
$request = array(
	'action' => 'getemailids'
);
</pre>	

<strong>Build a skycore object</strong>
<pre>
$skycore = new Skycore($key);
</pre>

<strong>Send a request to the object and get it's response</strong>
<pre>
$skycoreResponse = $skycore->makeAPI_Call($request);
</pre>

<strong>Show the whole response</strong>
<pre>
print_r ($skycoreResponse);
</pre>

<strong>Access a piece of data in the response</strong>
<pre>
echo $skycoreResponse->STATUS;
echo $skycoreResponse->ERRORCODE;
echo $skycoreResponse->ERRORINFO;
</pre>
