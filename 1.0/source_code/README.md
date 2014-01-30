<a href="/1.0/README.md">Back To Skycore SDK v1.0 Main Page</a>

<h1>Skycore SDK Source Code Files</h1>

<strong><a href="/1.0/source_code/skycore_sdk.php">Click Here for the SDK Source Code</a></strong>.

The <a href="/1.0/source_code/skycore_sdk_API_Call_example.php">API Call Example</a> is a small and 
simple implementation of the SDK's makeAPI_Call method to help give new users a good idea of how the API calls work.  A user will need to add the API key and URL here:
<pre>
include ('skycore_sdk.php');
//-------API ACCESS INFO-------
$key = "<strong>YOUR API KEY HERE</strong>";
$url = '<strong>API URL HERE</strong>';
</pre>

The <a href="/1.0/source_code/skycore_sdk_postbackStore_example.php">Postback Store Example</a> is a small and 
simple implementation of the SDK's storePostback method to help give new users a good idea of how to store a postback using the SDK.  It comes with an optional/modifiable XML Postback example for testing.  A user will need to add the API key, URL, and Database Information here:
<pre>
include ('skycore_sdk.php');
//-------API ACCESS INFO-------
$key = "<strong>YOUR API KEY HERE</strong>";
$url = '<strong>API URL HERE</strong>';
//-------DATABASE STORING INFO------
$dbHost = '<strong>YOUR HOST NAME HERE</strong>';
$dbUser = '<strong>USER NAME HERE</strong>';
$dbPW = '<strong>PASSWORD HERE</strong>';
$db = '<strong>DATABASE NAME HERE</strong>';
$dbTable = '<strong>TABLE NAME HERE</strong>';
</pre>
