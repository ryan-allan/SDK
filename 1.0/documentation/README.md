<h2>Skycore SDK v1.0 Documentation</h2>

This SDK will allow for implementation of the Skycore API via instantiation of a Skycore object and the passing of an array containing the proper parameters to the makeAPI_Call function.

A current list of the calls and their parameters can be found <a href="https://github.com/SkycoreMobile/API/blob/master/1.3/CONTENTS/METHODS/API_METHODS.md">here</a> .
	
<strong>Format Example:</strong>


	----------------------------------------
	$key = "YOUR_API_KEY_HERE";
	
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
	$skycore->makeAPI_Call($request);
	----------------------------------------
