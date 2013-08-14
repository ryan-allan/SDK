//Test Textfield and Button
<form action="testcore.php" method="get">
Your number must be of the format 1-XXX-XXX-XXXX (excluding hyphens) :<input type="text" name="number">
<input type="submit" name="submit" value="Subscribe">
</form>


<?php

include ('skycore_sdk.php');

$key = ""; //Enter a working key here.
$campid = "1605";
$number = $_GET["number"];

$skycore = new Skycore($key);
$skycore->subscribe($number, $campid);

?>
