<h2>Skycore SDK v1.0 Documentation</h2>

This SDK will allow for implementation of the Skycore API via instantiation of a Skycore object and passing 
an array containing the proper parameters to the makeAPI_Call function.  One can then assign the return value of this
function to an object and access any of the data from the response via this object.
-----------------------------------------------------------------------------------------------------------------------
A current list of the calls and their parameters can be found <a href="https://github.com/SkycoreMobile/API/blob/master/1.3/CONTENTS/METHODS/API_METHODS.md">here</a> .
-----------------------------------------------------------------------------------------------------------------------	
<strong>Format Examples:</strong>



$key = "YOUR_API_KEY_HERE";
	
$request = array(
	'action' => 'saveMMS',
	'subject' => 'testMMS',
	'content' => array(
		'name' => 'testMMS',
		'sequence' => array(
			'slide duration="10"' => array(
				'image' => array(
					'url' => 'example.com'
				),
				'text' => 'Some Text'
			)
		)
	)
);

$skycore = new Skycore($key);
$skycoreResponse = $skycore->makeAPI_Call($request);
echo $skycoreResponse->STATUS;
--------------------------------------------------
	-----------------------------------------
