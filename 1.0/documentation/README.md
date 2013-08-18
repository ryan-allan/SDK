<h1>Skycore SDK Documentation</h1>

<h2>Skycore SDK v1.0</h2>

This SDK will allow for implementation of the Skycore API via instantiation of a Skycore object and passing an array containing the proper parameters to the makeAPI_Call function.
A current list of the calls and their parameters can be found here at https://github.com/SkycoreMobile/API .
	
	Format Example:
	----------------------------------------
	<pre>$key = "YOUR_API_KEY_HERE";
	
	$request = array(
		'action' => 'API_CALL_ACTION_HERE',
		'emailid' => '00000',
		'email' => 'example@example.com',
		'campaignref' => '000',
		'passdata' => array(
			'barcodevalue' => '0000',
			'barcodetext' => 'Some Text'
		)
	);

	$skycore = new Skycore($key);
	$skycore->makeAPI_Call($request);</pre>
	----------------------------------------
