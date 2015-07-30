<?php
$id = $_POST['id'];
$sql = "DELETE from rv_events WHERE id=".$id;
$q = $db->prepare($sql);
$q->execute();
?>
