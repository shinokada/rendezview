<?php
// Values received via ajax
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

// connection to the database
try {
	$db = new PDO('mysql:host=localhost;dbname=58', 'evan', '3v0lve2oo9!');
} catch(Exception $e) {
	exit('Unable to connect to database.');
}

// insert the records
$sql = "INSERT INTO rv_events (title, start, end) VALUES (:title, :start, :end )";
$q = $db->prepare($sql);
$q->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end));
?>
