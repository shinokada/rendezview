<?php
$id = $_POST['id'];
try {
	$db = new PDO('mysql:host=localhost;dbname=58', 'evan', '3v0lve2oo9!');
} catch(Exception $e) {
	exit('Unable to connect to database.');
}
$sql = "DELETE from rv_events WHERE id=".$id;
$q = $db->prepare($sql);
$q->execute();
?>
