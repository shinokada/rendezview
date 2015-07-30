<?php

/* Values received via ajax */
$id = $_POST['id'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

 // update the records
$sql = "UPDATE rv_events SET title=?, start=?, end=? WHERE id=?";
$q = $db->prepare($sql);
$q->execute(array($title,$start,$end,$id));
?>
