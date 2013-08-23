<a href="/1.0/README.md">Back To Skycore SDK v1.0 Main Page</a>

<h1>Skycore SDK Source Code</h1>

<a href="/1.0/source_code/skycore_sdk.php">skycore_sdk.php</a> is the source code of the SDK.
One will need to add the API URL to the SDK here:
<pre>
	public function Skycore($key)	{

		$this->api_key = $key;
		$this->baseURL = '<strong>API_URL_HERE</strong>';
	}
</pre>

<a href="/1.0/source_code/testcore.php">testcore.php</a> is a small and simple implementation of the SDK to help give new users an idea of how the SDK works.
One will need to add the API key here:
<pre>
include ('skycore_sdk.php');
//-------Dev Key-------
$key = "<strong>YOUR_API_KEY_HERE</strong>";
</pre>
