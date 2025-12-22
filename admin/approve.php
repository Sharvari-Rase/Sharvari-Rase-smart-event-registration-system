<?php
include("../db.php");

if(!isset($_GET['id'])){
    header("Location: view_participants.php");
    exit;
}

$id = intval($_GET['id']);
mysqli_query($conn,"UPDATE registrations SET status='Approved' WHERE id=$id");

header("Location: view_participants.php");
exit;
?>
