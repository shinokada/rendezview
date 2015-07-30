<?php
// Values received via ajax
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

// insert the records
$sql = "INSERT INTO rv_events (title, start, end) VALUES (:title, :start, :end )";
$q = $db->prepare($sql);
$q->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end));
?>
