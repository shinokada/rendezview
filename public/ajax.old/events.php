<?php
// List of events
$json = array();

 // Query that retrieves events
$query = "SELECT * FROM rv_events ORDER BY id";

 // Execute the query
$result = $db->query($query) or die(print_r($db->errorInfo()));

 // sending the encoded result to success page
echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));

?>
