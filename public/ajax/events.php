<?php
// List of events
$json = array();

 // Query that retrieves events
$query = "SELECT * FROM rv_events ORDER BY id";

 // connection to the database
try {
	$db = new PDO('mysql:host=localhost;dbname=58', 'evan', '3v0lve2oo9!');
} catch(Exception $e) {
	exit('Unable to connect to database.');
}
 // Execute the query
$result = $db->query($query) or die(print_r($db->errorInfo()));

 // sending the encoded result to success page
echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));

?>
