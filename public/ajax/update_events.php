<?php

/* Values received via ajax */
$id = $_POST['id'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

// connection to the database
try {
	$db = new PDO('mysql:host=localhost;dbname=58', 'evan', '3v0lve2oo9!');
} catch(Exception $e) {
	exit('Unable to connect to database.');
}
 // update the records
$sql = "UPDATE rv_events SET title=?, start=?, end=? WHERE id=?";
$q = $db->prepare($sql);
$q->execute(array($title,$start,$end,$id));
?>
