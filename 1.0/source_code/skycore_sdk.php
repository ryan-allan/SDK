<?php
/*
Skycore SDK v1.0
--------------------------------------------------
This SDK will allow for implementation of the Skycore API and Storing of Skycore Postbacks via instantiation of an object of the Skycore class and passing 
the proper parameters to the respective function.  

To make an API call: You must create an array and pass it to the makeAPI_Call function [See Examples Below], one can then assign the return value of this
function to an object and access any of the data from the response via this assigned object.

To store a Postback: You must configure the proper parameters [See Examples Below].  The method will return true if it was completed 
or false if it failed to make the connection.
--------------------------------------------------
A current list of the API calls, Postback Formats and their parameters can be found here at https://github.com/SkycoreMobile/API/blob/master/1.3/README.md .
--------------------------------------------------        
API Call Format Example:
--------------------------------------------------
$key = "YOUR_API_KEY_HERE";
$url = 'API_URL_HERE';
        
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

$skycore = new Skycore($key, $url);
$skycoreResponse = $skycore->makeAPI_Call($request);
echo $skycoreResponse->STATUS;
--------------------------------------------------
Postback Store Format Example:
--------------------------------------------------
//---THE POSTBACK LINK SHOULD POINT TO THIS DOCUMENT-----------------------------
//-------API ACCESS INFO-------
$key = "YOUR API KEY HERE";
$url = 'API URL HERE';  

//-------POSTBACK STORING INFO------
$dbHost = 'YOUR HOST NAME HERE';
$dbUser = 'USER NAME HERE';
$dbPW = 'PASSWORD HERE';
$db = 'DATABASE NAME HERE';
$dbTable = 'TABLE NAME HERE';
$dbSQL = 'SQL TYPE HERE';

//Build a skycore object
$skycore = new Skycore_API_SDK($key, $url);

//Capture the Postback
$SkycorePostback = $_POST['XML'];

//-------Store Postback--------
$skycore->storePostback($SkycorePostback, $dbHost, $dbUser, $dbPW, $db, $dbTable, $dbSQL);
--------------------------------------------------
*/

//----DO NOT EDIT BELOW THIS LINE----
//---------Class Starts Here---------
class Skycore_API_SDK        {
        //Skycore constructor variables
        //-----------------------------
        private $api_key,
                $baseURL;
        //innerArrayCheck variables
        //-------------------------
        private $innerXML_tag,
                $innerRequestInfo,
                $innerArrayData,
                $innerArrayCount,
                $buildTag,
                $buildTag2,
                $currentChar,
                $currentChar2,
                $counter2,
                $counter3,
                $counter4;
        //innerArrayCheck arrays
        //----------------------
        private $innerArray,
                $innerArray_tag = array();
        //makeAPI_Call variables
        //----------------------
        private $requestStatus,
                $requestVerification,
                $currentXML_tag, 
                $requestInfo, 
                $XML_Request, 
                $response,
                $counter1;
		//makeAPI_Call arrays
		//-------------------
        private $array_tag, 
                $XML_RequestArray = array();
		//storePostback variables
		//-----------------------
		private $SkycorePostback,
			$SkycorePostbackObject,
			$dbHost,
			$dbUser,
			$dbPW,
			$db,
			$dbTable,
			$dbColumn,
			$dbColumnInfo,
			$dbSQL,
			$element,
			$fileCounter,
			$result,
			$colCheck,
			$link,
			$query;		
        //Constructor
        //-----------
        public function Skycore_API_SDK($key, $url)        {
                $this->api_key = $key;
                $this->baseURL = $url;
        }
	//Function to construct a query
	//-----------------------------
	private function constructQuery($SkycorePostbackObject, $dbTable)	{
		$query = "INSERT INTO $dbTable (";
		foreach ($SkycorePostbackObject as $element) {
			$dbColumn = $element->getName();
			if($dbColumn == "NOTIFICATION")	{
				$query = $this->constructQuery($element, $dbTable);
				return $query;
			}
			//Convert TO/FROM tags to PHONE (TO/FROM are keywords in the SQL)
			if($dbColumn == "TO")	{
				$dbColumn = "PHONETO";
			}
			if($dbColumn == "FROM")	{
				$dbColumn = "PHONEFROM";
			}
			if($dbColumn == "CONTENT")	{
				$fileCounter = 0;
				while($element->FILE[$fileCounter] != null)	{
					$dbColumn = "FILE" . ($fileCounter + 1);
					$fileCounter++;
					$query = $query . $dbColumn . ",";
				}
			}
			else	{
				$query = $query . $dbColumn . ",";
			}
		}
		$query = substr($query, 0, strlen($query) - 1);
		$query = $query . ") VALUES ('";
		foreach ($SkycorePostbackObject as $element) {
			if($element->getName() == "CONTENT")	{
				$fileCounter = 0;
				while($element->FILE[$fileCounter] != null)	{
					$dbColumnInfo = $element->FILE[$fileCounter];
					$fileCounter++;
					$query = $query . $dbColumnInfo . "','";
				}
			}
			else	{
				$dbColumnInfo = trim($element);
				$query = $query . $dbColumnInfo . "','";
			}
		}
		$query = substr($query, 0, strlen($query) - 2);
		$query = $query . ")";
		return $query;
	}
	//Function to check for and build new columns
	//-------------------------------------------
	private function columnCheck($SkycorePostbackObject, $dbTable, $link, $dbSQL)	{
		foreach ($SkycorePostbackObject as $element) {
			$dbColumn = $element->getName();
			if($dbColumn == "NOTIFICATION")	{
				$this->columnCheck($element, $dbTable, $link, $dbSQL);
				return true;
			}
			//Convert TO/FROM tags to PHONE (TO/FROM are keywords in the SQL)
			if($dbColumn == "TO")	{
				$dbColumn = "PHONETO";
			}
			if($dbColumn == "FROM")	{
				$dbColumn = "PHONEFROM";
			}
			if($dbColumn == "CONTENT")	{
				$fileCounter = 0;
				while($element->FILE[$fileCounter] != null)	{
					$dbColumn = "FILE" . ($fileCounter + 1);
					switch($dbSQL)	{
						case 'MySQL':
							$colScan = mysqli_query($link, "SELECT $dbColumn FROM $dbTable");
							break;
						case 'PSQL':
							$colScan = pg_query($link, "SELECT $dbColumn FROM $dbTable");
							break;
						default:
							return false;
					}
					if (!$colScan){
						switch($dbSQL)	{
							case 'MySQL':
								mysqli_query($link, "ALTER TABLE $dbTable ADD $dbColumn VARCHAR(100)");
								//echo $dbColumn . ' has been added to the database';
								break;
							case 'PSQL':
								pg_query($link, "ALTER TABLE $dbTable ADD COLUMN $dbColumn VARCHAR(100)");
								//echo $dbColumn . ' has been added to the database';
								break;
							default:
								return false;
						}
					}
					$fileCounter++;
				}
			}
			else	{
				switch($dbSQL)	{
				case 'MySQL':
					$colScan = mysqli_query($link, "SELECT $dbColumn FROM $dbTable");
					break;
				case 'PSQL':
					$colScan = pg_query($link, "SELECT $dbColumn FROM $dbTable");
					break;
				default:
					return false;
				}
				//Build column if it does not already exist
				if (!$colScan){
					switch($dbSQL)	{
						case 'MySQL':
							mysqli_query($link, "ALTER TABLE $dbTable ADD $dbColumn VARCHAR(100)");
							//echo $dbColumn . ' has been added to the database';
							break;
						case 'PSQL':
							pg_query($link, "ALTER TABLE $dbTable ADD COLUMN $dbColumn VARCHAR(100)");
							//echo $dbColumn . ' has been added to the database';
							break;
						default:
							return false;
					}
				}
			}
		}
		return true;	
	}
	//Function to store a postback
	//----------------------------
	public function storePostback($SkycorePostback, $dbHost, $dbUser, $dbPW, $db, $dbTable, $dbSQL)	{
		//Convert to XML Object
		$SkycorePostbackObject = simplexml_load_string($SkycorePostback);
		//Check SQL Type
		switch($dbSQL)	{
			case 'MySQL':
				//Create Connection
				$link = mysqli_connect("$dbHost","$dbUser","","$db");
				//Check Connection
				if (mysqli_connect_errno()){
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
					return false;
				}
				//Check if the columns exist, if they do not, it will build it
				$this->columnCheck($SkycorePostbackObject, $dbTable, $link, $dbSQL);
				//Build the query
				$query = $this->constructQuery($SkycorePostbackObject, $dbTable);
				print_r($query);
				mysqli_query($link, $query);
				mysqli_close($link);
				return true;
				break;
			case 'PSQL':
				//Create Connection
				$link = pg_connect("host=$dbHost port=6432 dbname=$db user=$dbUser password=$dbPW") or die("Failed to connect to PostgreSQL");
				//Check Connection
				if(!$link)	{
					$result = pg_get_result($link);
					echo pg_result_error($result);
				}
				//Check if the columns exist
				$this->columnCheck($SkycorePostbackObject, $dbTable, $link, $dbSQL);
				//Build the query
				$query = $this->constructQuery($SkycorePostbackObject, $dbTable);
				//print_r($query);
				pg_query($link, $query);
				pg_close($link);
				return true;
				break;
			default:
				return false;
		}
	}
	//Function to handle multidimensional arrays
        //------------------------------------------
        private function innerArrayCheck($request, $currentXML_tag)        {
                //Initialize the main tag
                $innerArrayData = "<" . strtoupper($currentXML_tag) . ">";
                //Initialize the next array dimension
                $innerArray = $request[$currentXML_tag];
                //Get the number of elements in the array
                $innerArrayCount = count($request[$currentXML_tag]);
                //Build the XML for the inner array        
                for($counter2 = 0; $counter2 < $innerArrayCount; $counter2++)        {
                        //Turn an array key into an array of just that key
                        $innerArray_tag = array_keys($innerArray);
                        //Convert the $array_tag into a string to be used as an XML tag
                        $innerXML_tag = $innerArray_tag[$counter2];
                        //Check for additional arrays, recursively calls this function if they exist, and builds the XML from the innerArray.
                        if ("array" == gettype($innerArray[$innerXML_tag]))        {
                                $innerRequestInfo = $this->innerArrayCheck($innerArray, $innerXML_tag);
                                $innerArrayData = $innerArrayData . $innerRequestInfo;
                        }
                        else        {
                                $innerRequestInfo = $innerArray[$innerXML_tag];
                                //Add initial inner tag
                                $innerArrayData = $innerArrayData . "<" . strtoupper($innerXML_tag) . ">" . $innerRequestInfo;
                                //Strip any extra data from the closing inner tag
                                for ($counter3 = 0; $counter3 < strlen($innerXML_tag); $counter3++)  { 
                                        $currentChar = substr($innerXML_tag, $counter3, 1);
                                        if ($currentChar == " " || $currentChar == '\0')        {
                                                $counter3 = strlen($innerXML_tag);
                                                $innerXML_tag = $buildTag;
                                                echo $innerXML_tag;
                                        }
                                        else if ($counter3 == 0){
                                                $buildTag = $currentChar;
                                        }
                                        else        {
                                                $buildTag = $buildTag . $currentChar;
                                        }
                                } 
                                //Add the closing inner tag
                                $innerArrayData = $innerArrayData . "</" . strtoupper($innerXML_tag) . ">";
                                //Strip any extra data from the closing tag
                                for ($counter4 = 0; $counter4 < strlen($currentXML_tag); $counter4++)  { 
                                        $currentChar2 = substr($currentXML_tag, $counter4, 1);
                                        if ($currentChar2 == " " || $currentChar2 == '\0')        {
                                                $counter4 = strlen($currentXML_tag);
                                                $currentXML_tag = $buildTag2;
                                        }
                                        else if ($counter4 == 0){
                                                $buildTag2 = $currentChar2;
                                        }
                                        else        {
                                                $buildTag2 = $buildTag2 . $currentChar2;
                                        }
                                } 
                        }        
                }        
                //Add closing main tag
                $innerArrayData = $innerArrayData . "</" . strtoupper($currentXML_tag) . ">";
                //Return the data in XML format
                return $innerArrayData;
        }
        //Function for an API call
        //------------------------
        public function makeAPI_Call($request)        {
                $requestVerification = $request;
                $requestVerification['api_key'] = $this->api_key;        
                $requestStatus = $this->verifyRequest($requestVerification);
                if(gettype($requestStatus) != 'object')        {
                        $requestStatus = "
                        <RESPONSE>
                        <STATUS>Success</STATUS>
                        </RESPONSE>";
                        $requestStatus = simplexml_load_string($requestStatus);
                }
                if($requestStatus->STATUS == 'Failure')        {
                        return $requestStatus;
                        exit();
                }
                for($counter1 = 0;$counter1 < count($request); $counter1++)        {
                        if($counter1 == 0)        {
                                //Initialize the XML Request
                                $XML_Request = "<REQUEST>" . "<API_KEY>" . $this->api_key . "</API_KEY>";
                        }
                        //Turn an array key into an array of just that key
                        $array_tag = array_keys($request);
                        //Convert the $array_tag into a string to be used as an XML tag
                        $currentXML_tag = $array_tag[$counter1];
                        //Check for additional arrays
                        if ("array" == gettype($request[$currentXML_tag]))        {
                                $requestInfo = $this->innerArrayCheck($request, $currentXML_tag);
                                $XML_Request = $XML_Request . $requestInfo;
                        }
                        else        {
                                $requestInfo = $request[$currentXML_tag];
                                $XML_Request = $XML_Request . "<" . strtoupper($currentXML_tag) . ">" . $requestInfo . "</" . strtoupper($currentXML_tag) . ">";
                        }
                        if($counter1 == (count($request)) - 1)        {
                                //Complete the XML request
                                $XML_Request = $XML_Request . "</". "REQUEST" . ">";
                        }
                }
                //Build the request array
                $XML_RequestArray['XML']= $XML_Request;
                //print_r($XML_RequestArray);
                //Make the HTTPS request and return the response
                return $this->httpsRequest($XML_RequestArray);
        }
        //Function to make an HTTPS request
        //---------------------------------
        private function httpsRequest($XML_RequestArray)        {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->baseURL);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $XML_RequestArray);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                //set XML response
                $response = curl_exec($ch);
				//print_r($response);
                curl_close($ch);
                //Convert response to simple XML object
                $XML_Response = simplexml_load_string($response);
                //Return the response
                return $XML_Response;
        }
        //Function to verify the request before sending
        //---------------------------------------------
        private function verifyRequest ($content_values)        {
                //Generic Field Requirements
                if ($content_values['action']=="") {
                        return $this->ReportXMLError("E101", "'action' required/Invalid Action", $content_values);
                }

                if ($content_values['api_key']=="") {
                        return $this->ReportXMLError("E102", "'api_key' required", $content_values);
                }
                //Send SMS
                elseif (strtolower($content_values['action'])=='sendsms') {
                        if ($content_values['to']=="") {
                                return $this->ReportXMLError("E201", "The receiver number is required", $content_values);
                        }
        
                        if ($content_values['text'] =="") {
                                return $this->ReportXMLError("E712", "The 'text' is required", $content_values);
                        }
        
                        if ($content_values['from'] =="") {
                                return $this->ReportXMLError("E111", "Invalid shortcode", $content_values);
                        }
                }
                //Save MMS
                elseif (strtolower($content_values['action'])=='savemms') {
                        if ($content_values['content']['name']=="") {
                                return $this->ReportXMLError("E301", "The 'name' is required", $content_values);
                        }
                        //Take an the sequence as a numerically indexed array to work around the variation in slide tags
                        $numericArray = array_values($content_values['content']['sequence']);

                        if ($numericArray[0]=="" || $numericArray[0]==0) {
                                return $this->ReportXMLError("E302", "No slides", $content_values);
                        }
                        for ($i=0; $i<count($numericArray); $i++) {
                                if ($numericArray[$i]['image']['url']=="" && $numericArray[$i]['audio']['url']=="" && $numericArray[$i]['video']['url']=="" && $numericArray[$i]['text']['value']=="") {
                                        return $this->ReportXMLError("E303", "Slide ".$i." is empty", $content_values);
                                }
                        }
                }
                //Get Sending Statistics
                elseif (strtolower($content_values['action'])=='getsendingstatistics') {
                        if ($content_values['start_date'] =="") {
                                return $this->ReportXMLError("E506", "'start_date' is required", $content_values);
                        }
                        if ($content_values['end_date'] =="") {
                                return $this->ReportXMLError("E506", "'end_date' is required", $content_values);
                        }
                        $date_format='/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
                        preg_match($date_format, trim($content_values['start_date']), $matches);

                        if ($matches[0]!='') {
                                $content_values['start_timestamp'] = strtotime($content_values['start_date']);
            
                                if ($content_values['start_timestamp']===-1) {
                                        return $this->ReportXMLError("E508", "Invalid 'start_date' format", $content_values);
                                }
                        }
                        else {
                                return $this->ReportXMLError("E507", "Invalid 'start_date' format", $content_values);
                        }
                        preg_match($date_format, trim($content_values['end_date']), $matches);
                        if ($matches[0]!='') {
                                $content_values['end_timestamp'] = strtotime($content_values['end_date']);

                                if ($content_values['end_timestamp']===-1) {
                                        return $this->ReportXMLError("E508", "Invalid 'end_date' format", $content_values);
                                }
                        }
                        else {
                                return $this->ReportXMLError("E507", "Invalid 'end_date' format", $content_values);
                        }
                }
                //Send Saved MMS
                elseif (strtolower($content_values['action'])=='sendsavedmms') {
                        $MAX_NUMBERS_IN_LIST=100;
                        if ($content_values['mmsid'] =="") {
                                return $this->ReportXMLError("E620", "The 'mmsid' is required", $content_values);
                        }
                        if ($content_values['to'] =="") {
                                return $this->ReportXMLError("E621", "The 'to' is required", $content_values);
                        }
                        if (count($content_values['to'])>$MAX_NUMBERS_IN_LIST) {
                                return $this->ReportXMLError("E623", "The 'to' field can contain up to ".$MAX_NUMBERS_IN_LIST." numbers", $content_values);
                        }
        
                        if ($content_values['from'] =="") {
                                return $this->ReportXMLError("E111", "Invalid shortcode", $content_values);
                        }
                }
                //Send Saved MMS Campaign
                elseif (strtolower($content_values['action'])=='sendsavedmmscampaign') {
                        if ($content_values['mmsid'] =="") {
                                return $this->ReportXMLError("E620", "The 'mmsid' is required", $content_values);
                        }
                        if ($content_values['tocampaign'] =="") {
                                return $this->ReportXMLError("E624", "The 'tocampaign' is required", $content_values);
                        }
                }
                //Send Saved Email
                elseif (strtolower($content_values['action'])=='sendsavedemail') {
                        if ($content_values['emailid'] =="") {
                                return $this->ReportXMLError("E402", "Invalid emailid", $content_values);
                        }
                        if ($content_values['email'] =="") {
                                return $this->ReportXMLError("E401", "Invalid email", $content_values);
                        }
                }
                //Remove Inbox Content
                elseif (strtolower($content_values['action'])=='removemmsinboxcontent') {
                        if ($content_values['mmsinboxid'] =="") {
                                return $this->ReportXMLError("E640", "The 'mmsinboxid' is required", $content_values);
                        }
                }
                //Subscribe/Unsubscribe
                elseif (strtolower($content_values['action'])=='subscribe' || strtolower($content_values['action'])=='unsubscribe') {
                        if ($content_values['mobile']=="") {
                                return $this->ReportXMLError("E901", "The 'mobile' number is required", $content_values);
                        }
                        if ($content_values['campaignid']=="") {
                                return $this->ReportXMLError("E902", "The 'campaignid' is required", $content_values);
                        }
                }
                //Email subscribe/unsubscribe
                elseif (strtolower($content_values['action'])=='subscribeemail' || strtolower($content_values['action'])=='unsubscribeemail') {
                        if ($content_values['email']=="") {
                                return $this->ReportXMLError("E911", "The 'email' is required", $content_values);
                        }
                        if ($content_values['campaignid']=="") {
                                return $this->ReportXMLError("E912", "Invalid campaignid", $content_values);
                        }
                }
                //Create User
                elseif (strtolower($content_values['action'])=='createuser') {
                        if ( $content_values['newuser'] == "") {
                                return $this->ReportXMLError ( "E150", "The 'newuser' is required", $content_values );
                        }
                        if ( $content_values['newpass'] == "") {
                                return $this->ReportXMLError ( "E152", "The 'newpass' is required", $content_values );
                        }
                }
                //Create MMS Campaign
                elseif (strtolower($content_values['action'])=='createmmscampaign') {
                        if ( $content_values['campaignname'] == "" ) {
                                return $this->ReportXMLError ( "E170", "'campaignname' is required.", $content_values );
                        }
                        if ( $content_values['brandname'] == "" ) {
                                return $this->ReportXMLError ( "E171", "'brandname' is required.", $content_values );
                        }
                }
                //Create Email Campaign
                elseif (strtolower($content_values['action'])=='createemailcampaign') {
                        if ( $content_values['campaignname'] == "" ) {
                                return $this->ReportXMLError ( "E170", "'campaignname' is required.", $content_values );
                        }
                        if ( $content_values['brandname'] == "" ) {
                                return $this->ReportXMLError ( "E171", "'brandname' is required.", $content_values );
                        }
                        if ( $content_values['mailingaddress'] == "" ) {
                                return $this->ReportXMLError ( "E173", "'mailingaddress' is required.", $content_values );
                        }
                }
                //Send MMS Barcode
                elseif (strtolower($content_values['action'])=='sendmmsbarcode') {
                        if ($content_values['mmsid'] =="") {
                                return $this->ReportXMLError("E620", "The 'mmsid' is required", $content_values);
                        }
                        if ($content_values['to'] =="") {
                                return $this->ReportXMLError("E621", "The 'to' is required", $content_values);
                        }
                        if ($content_values['to']['barcodeid'] =="") {
                                return $this->ReportXMLError("E631", "The 'barcodeid' is required", $content_values);
                        }
                        if ($content_values['to']['from'] =="") {
                                return $this->ReportXMLError("E111", "Invalid shortcode", $content_values);
                        }
                }
                //Add Pass Data
                elseif (strtolower($content_values['action'])=='addpassdata') {
                        if ( empty ( $content_values ['passtemplateid'] ) ) {
                                return $this->ReportXMLError ( "E801", "The PassTemplateID is required", $content_values );
                        }
                }
                //Update Pass Data - *This will also update the pass*
                elseif (strtolower($content_values['action'])=='updatepass') {
                        if ( empty ( $content_values ['passdataid'] ) ) {
                                return $this->ReportXMLError ( "E807", "The PassDataID is required", $content_values );
                        }
                }
                //Delete Pass Data
                elseif (strtolower($content_values['action'])=='deletepassdata') {
                        if ( empty ( $content_values ['passdataid'] ) ) {
                                return $this->ReportXMLError ( "E807", "The PassDataID is required", $content_values );
                        }
                }
                //Send Pass in MMS
                elseif (strtolower($content_values['action'])=='sendpassinmms') {
                        if ($content_values['mmsid'] =="") {
                                return $this->ReportXMLError("E620", "The 'mmsid' is required", $content_values);
                        }
                        if ($content_values['to'] =="") {
                                return $this->ReportXMLError("E621", "The 'to' is required", $content_values);
                        }
                        if ($content_values['from'] =="") {
                                return $this->ReportXMLError("E111", "Invalid shortcode", $content_values);
                        }
                }
                //Send Pass in Email
                elseif (strtolower($content_values['action'])=='sendpassinemail') {
                        if ($content_values['emailid'] =="") {
                                return  $this->ReportXMLError("E402", "Invalid emailid", $content_values);
                        }
                        if ($content_values['email'] =="") {
                                return $this->ReportXMLError("E401", "Invalid email", $content_values);
                        }
                        if ($content_values['campaignref'] == "" ) {
                                return $this->ReportXMLError("E714", "Missing/Invalid CampaignID", $content_values );
                        }
                }
                //Generate Pass by Pass Data ID
                elseif (strtolower($content_values['action'])=='generatepassbyid') {
                        if ( empty ( $content_values ['passdataid'] ) ) {
                                return $this->ReportXMLError ( "E807", "The PassDataID is required", $content_values );
                        }
                }
                //Generate Pass 
                elseif (strtolower($content_values['action'])=='generatepass') {
                        if ( empty ( $content_values ['passtemplateid'] ) ) {
                                return $this->ReportXMLError ( "E801", "The PassTemplateID is required", $content_values );
                        }
                }
                //Get Pass Template
                elseif (strtolower($content_values['action'])=='getpasstemplate') {
                        if ( empty ( $content_values['mmsid'] ) && empty ( $content_values['emailid'] ) && empty ( $content_values['passtemplateid'] ) ) {
                                return $this->ReportXMLError("E827", "Invalid request. MmsID or emailID or passTemplateID is required.", $content_values);
                        }
                }
                //---------------------------Empty Conditionals------------------------------
                //Login User
                elseif (strtolower($content_values['action'])=='loginuser')        {
                        //Nothing Needed Here
                }
                //Get MMS ID's
                elseif(strtolower($content_values['action'])=='getmmsids')        {
                        //Nothing Needed Here
                }
                //Get Email ID's
                elseif(strtolower($content_values['action'])=='getemailids')        {
                        //Nothing Needed Here
                }
                //Get Email Campaigns
                elseif(strtolower($content_values['action'])=='getemailcampaigns')        {
                        //Nothing Needed Here
                }
                //Get Pass Template ID's
                elseif(strtolower($content_values['action'])=='getpasstemplateids')        {
                        //Nothing Needed Here
                }
                //---------------------------End Empty Conditionals------------------------------
                else {
                        return $this->ReportXMLError("E101", "'action' required/Invalid Action");
                }
        }
        //Function to report any errors found by the verifyRequest function
        //-----------------------------------------------------------------
        private function ReportXMLError($code, $description)        {
           //Build the error response
           $Error_Response = "
                <RESPONSE>
                <STATUS>Failure</STATUS>
                <ERRORCODE>".$code."</ERRORCODE>
                <ERRORINFO>".$description."</ERRORINFO>
                </RESPONSE>";
                //Convert response to simple XML object
                $XML_Response = simplexml_load_string($Error_Response);
                //return the response
                return $XML_Response;
        }
}
?>
