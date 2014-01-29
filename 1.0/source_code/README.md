<a href="/1.0/README.md">Back To Skycore SDK v1.0 Main Page</a>

<h1>Skycore SDK Source Code</h1>

<a href="/1.0/source_code/skycore_sdk.php">skycore_sdk.php</a> is the source code of the SDK.

<a href="/1.0/source_code/skycore_sdk_API_Call_example.php">API Call Example</a> is a small and 
simple implementation of the SDK's makeAPI_Call method to help give new users a good idea of how the SDK works.  A user will need to add the API key and URL here:
<pre>
include ('skycore_sdk.php');
//-------API ACCESS INFO-------
$key = "<strong>YOUR API KEY HERE</strong>";
$url = '<strong>API URL HERE</strong>';
</pre>

<a href="/1.0/source_code/skycore_sdk_postbackStore_example.php">Postback Store Example</a> is a small and 
simple implementation of the SDK's storePostback method to help give new users a good idea of how the SDK works.  A user will need to add the API key, URL, and Database Information here:
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
