<a name="DocTop"><a href="/1.0/README.md">Back To Skycore SDK v1.0 Main Page</a>

<h2>Skycore SDK v1.0 Documentation</h2>

<strong>Synopsis:</strong>
This SDK will allow for implementation of the Skycore API and Storing of Skycore Postbacks via instantiation of an object of the Skycore class and passing 
the proper parameters to the respective function.  

<strong>To make an API call:</strong> You must create an array and pass it to the makeAPI_Call function [(See Examples Below)](#APICalls), one can then assign the return value of this function to an object and access any of the data from the response via this assigned object.<br>
<strong>Note:</strong> When making a request array one can ignore the [<REQUEST></REQUEST>] and "<API_KEY></API_KEY>" tags.

<strong>To store a Postback:</strong> You must configure the proper parameters and pass it to the storePostback function [(See Examples Below)](#PostbackStore).  The method will return true if it was completed 
or false if it failed to make the connection.  
<strong>Note:</strong> The storePostback function utilizes mysqli() functions to manipulate the database.

**A current list of the API calls, Postback Formats and their parameters can be found 
<a href="https://github.com/SkycoreMobile/API/blob/master/1.3/README.md">here</a> .**

<h6>The following examples work in conjunction with these files for optimal understanding of the SDK functionalities:</h6>
<ul>
<li><a href="/1.0/source_code/skycore_sdk_API_Call_example.php">skycore_sdk_API_Call_example.php</a></li>
<li><a href="/1.0/source_code/skycore_sdk_postbackStore_example.php">skycore_sdk_postbackStore_example.php</a></li>
</ul>

<a name="APICalls"><h3>API Call Format and Usage Examples:</h3>

<strong>Finding the API Configs:</strong>
<img src='https://raw.github.com/ryan-allan/SDK/master/1.0/documentation/CantFindAPI_Configs.png'>

<strong>General format to map the XML example to a request array</strong>
<img src='https://raw.github.com/ryan-allan/SDK/master/1.0/documentation/XML_To_Array_Example.png'>

<strong>Include the SDK and initialize your API Key and URL:</strong>

<pre>
include ('skycore_sdk.php');
$key = "<strong>YOUR API KEY HERE</strong>";
$url = '<strong>API URL HERE</strong>';
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

<strong>Build Example Request 4:</strong><BR/>

<strong>Note:</strong> Any "get" requests will return the desired information in the response object.

<pre>
$request = array(
	'action' => 'getemailids'
);
</pre>	

<strong>Build a Skycore Object</strong>
<pre>
$skycore = new Skycore_API_SDK($key);
</pre>

<strong>Send a request to the object and get it's response</strong>
<pre>
$skycoreResponse = $skycore->makeAPI_Call($request);
</pre>

<strong>Display the whole response</strong>
<pre>
print_r ($skycoreResponse);
</pre>

<h4>How to display/access data from the response object:</h4>

<strong>Basic Format:</strong>
$skycoreResponse->DESIRED_INFO_TAG;

<strong>Example 1:</strong>
Display the status of the request (Failure/Success)
<pre>
echo $skycoreResponse->STATUS;
</pre>

<strong>Example 2:</strong>
For Error Information (If the status returns as 'Failure'):
<pre>
echo $skycoreResponse->ERRORCODE;
echo $skycoreResponse->ERRORINFO;
</pre>

<strong>Example 3:</strong>
For the 'Example 4' "get" request:
<pre>
echo $skycoreResponse->EMAILIDS;
</pre>

[Back To The Top](#DocTop)

<a name="PostbackStore"><h3>Postback Store Example:</h3>
<strong>Include the SDK</strong>
<pre>
include ('skycore_sdk.php');
</pre>

<strong>Configure API Info</strong>  
<pre>
$key = "YOUR API KEY HERE";
$url = 'API URL HERE';  
</pre>

<strong>Configure Database Access Information</strong>
<pre>
$dbHost = 'YOUR HOST NAME HERE';
$dbUser = 'USER NAME HERE';
$dbPW = 'PASSWORD HERE';
$db = 'DATABASE NAME HERE';
$dbTable = 'TABLE NAME HERE';
</pre>

<strong>Build a skycore object</strong>
<pre>
$skycore = new Skycore_API_SDK($key, $url);
</pre>

<strong>Grab The XML from the POST fields</strong>
<pre>
$SkycorePostback = $_POST['XML'];
</pre>
<strong>Store the Postback</strong>
<pre>
$skycore->storePostback($SkycorePostback, $dbHost, $dbUser, $dbPW, $db, $dbTable);
</pre>

<strong>What will the table look like?</strong>
<img src='https://raw.github.com/ryan-allan/SDK/master/1.0/documentation/DB_Example.png'>
[Back To The Top](#DocTop)
