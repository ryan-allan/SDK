<a name="DocTop"><a href="/1.0/README.md">Back To Skycore SDK v1.0 Main Page</a>

<h2>Skycore SDK v1.0 Documentation</h2>

<strong>Synopsis:</strong>
This SDK will allow for implementation of the Skycore API and Storing of Skycore Postbacks via instantiation of an object of the Skycore class and passing 
the proper parameters to the respective function.  

**A current list of the API calls, Postback Formats and their parameters can be found 
<a href="https://github.com/SkycoreMobile/API/blob/master/1.3/README.md">here</a> .**

<strong>To make an API call:</strong> You must create an array and pass it to the makeAPI_Call function [(See Examples Below)](#APICalls), one can then assign the return value of this function to an object and access any of the data from the response via this assigned object.<br>
<strong>Note:</strong> When making a request array one can ignore the REQUEST and API_KEY tags.

<strong>To store a Postback:</strong> You must configure the proper parameters and pass it to the storePostback function [(See Examples Below)](#PostbackStore).  The method will return true if it was completed 
or false if it failed to make the connection.  
<strong>Note:</strong> The storePostback function utilizes mysqli() or pg() functions to manipulate the database based on the SQL type you have set.

<h6>The following examples work in conjunction with these files for optimal understanding of the SDK functionalities:</h6>
<ul>
<li><a href="/1.0/source_code/skycore_sdk_API_Call_example.php">skycore_sdk_API_Call_example.php</a></li>
<li><a href="/1.0/source_code/skycore_sdk_postbackStore_example.php">skycore_sdk_postbackStore_example.php</a></li>
</ul>

<a name="APICalls"><h3>API Call Format and Usage Examples:</h3>

<strong>Finding the API Configs:</strong>
<img src='https://raw.github.com/ryan-allan/SDK/master/1.0/documentation/CantFindAPI_Configs.png'>

<strong>Include the SDK and initialize your API Key and URL:</strong>

<pre>
include ('skycore_sdk.php');
$key = "<strong>YOUR API KEY HERE</strong>";
$url = '<strong>YOUR API URL HERE</strong>';
</pre>

<strong>Build Example Request 1 from <a href="https://github.com/SkycoreMobile/API/blob/master/1.3/CONTENTS/METHODS/subscribe+unsubscribe.md">correlating XML</a>:</strong>

<pre>
$action = 'subscribe';
$campaginid = 'YOUR CAMPAIGN ID HERE';
$mobile = 'YOUR MOBILE HERE';
$request = array(
	'action'     => $subscribe
	'campaignid' => $campaignid,
	'mobile'     => $mobile
);
</pre>

<strong>Build Example Request 2 from <a href="https://github.com/SkycoreMobile/API/blob/master/1.3/CONTENTS/METHODS/sendPassInEmail.md">correlating XML</a>:</strong>
<pre>
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
</pre>

<strong>Build Example Request 3 from <a href="https://github.com/SkycoreMobile/API/blob/master/1.3/CONTENTS/METHODS/saveMMS.md">correlating XML</a>:</strong>
<pre>
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
</pre>

<strong>Build Example Request 4 from <a href="https://github.com/SkycoreMobile/API/blob/master/1.3/CONTENTS/METHODS/getEmailIds.md">correlating XML</a>:</strong><BR/>

<strong>Note:</strong> Any "get" requests will return the desired information in the response object.

<pre>
$action = 'getemailids';
$request = array(
	'action' => $action
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
$url = 'YOUR API URL HERE';  
</pre>

<strong>Configure Database Access Information</strong>
<pre>
$dbHost = 'YOUR HOST NAME HERE';
$dbUser = 'USER NAME HERE';
$dbPW = 'PASSWORD HERE';
$db = 'DATABASE NAME HERE';
$dbTable = 'TABLE NAME HERE';
$dbSQL = 'SQL TYPE HERE';
</pre>

<strong>Build a skycore object</strong>
<pre>
$skycore = new Skycore_API_SDK($key, $url);
</pre>

<strong>Grab The XML from the POST fields</strong>
<pre>
$HTTP_RAW_POST_DATA = file_get_contents("php://input");
if ($_POST['xml'] == '' && $_GET['action']==''  && $_POST['action']=='' && $HTTP_RAW_POST_DATA!='')	{
	$_POST['xml'] = $HTTP_RAW_POST_DATA;
}
$SkycorePostback = $_POST['xml'];
</pre>
<strong>Store the Postback</strong>
<pre>
$skycore->storePostback($SkycorePostback, $dbHost, $dbUser, $dbPW, $db, $dbTable, $dbSQL);
</pre>

<strong>What will the table look like?</strong>
<img src='https://raw.github.com/ryan-allan/SDK/master/1.0/documentation/DB_Example.png'>
[Back To The Top](#DocTop)
