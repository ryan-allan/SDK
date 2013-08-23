<a href="/1.0/README.md">Back To Skycore SDK v1.0 Main Page</a>


<h2>Skycore SDK v1.0 Documentation</h2>

<strong>Synopsis:</strong>
This SDK will allow for implementation of the Skycore API via instantiation of an object of the Skycore class and passing 
an array containing the proper parameters to the makeAPI_Call function.  One can then assign the return value of this
function to an object and access any of the data from the response via this object.

A current list of the calls and their parameters can be found <a href="https://github.com/SkycoreMobile/API/blob/master/1.3/CONTENTS/METHODS/API_METHODS.md">here</a> .

<h6>The following examples work in conjunction with the <a href="/1.0/source_code/skycore_sdk_example.php">skycore_sdk_example.php</a> file for optimal understanding of the SDK functionalities</h6>

<h3>Format Examples:</h3>

<strong>Include the SDK and initialize your API Key and URL</strong>
<pre>
include ('skycore_sdk.php');

$key = "<strong>YOUR_API_KEY_HERE</strong>";
$url = '<strong>API_URL_HERE</strong>';
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
	'email' => '$_GET["email"]',
	'campaignref' => '805',
	'passdata' => array(
		'barcodevalue' => '1234',
		'barcodetext' => '5678'
	)
);
</pre>

<strong>Build Example Request 3:</strong>
<pre>
$duration1 = 'slide duration="' . $_GET["duration1"] .'"';
$duration2 = 'slide duration="' . $_GET["duration2"] .'"';

$request = array(
	'action' => 'saveMMS',
	'subject' => 'testMMS',
	'content' => array(
		'name' => $_GET["name"],
		'sequence' => array(
			$duration1 => array(
				'image' => array(
					'url' => $_GET["url1"]
				),
				'text' => 'Some Text'
			),
			$duration2 => array(
				'image' => array(
					'url' => $_GET["url2"]
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

<strong>Build a Skycore Object</strong>
<pre>
$skycore = new Skycore($key);
</pre>

<strong>Send a request to the object and get it's response</strong>
<pre>
$skycoreResponse = $skycore->makeAPI_Call($request);
</pre>

<strong>Display the whole response</strong>
<pre>
print_r ($skycoreResponse);
</pre>

<strong>Display the status of the request (Failure/Success)</strong>
<pre>
echo $skycoreResponse->STATUS;
</pre>

<strong>How to display error data (or any data)</strong>
<pre>
echo $skycoreResponse->ERRORCODE;
echo $skycoreResponse->ERRORINFO;
</pre>
