<?php
include("../db.php");

if(!isset($_GET['id'])){
    // id नसल्यास थेट redirect
    header("Location: view_events.php");
    exit;
}

$id = intval($_GET['id']);

// first delete child records
mysqli_query($conn, "DELETE FROM registrations WHERE event_id = $id");

// then delete parent event
mysqli_query($conn, "DELETE FROM events WHERE id = $id");

header("Location: view_events.php");
exit;
?>
