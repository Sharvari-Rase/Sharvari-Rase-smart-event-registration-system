<?php
include("../db.php");
if(!isset($_SESSION['user_id'])) header("Location: login.php");

$id=$_GET['id'];
$uid=$_SESSION['user_id'];

mysqli_query($conn,"DELETE FROM registrations WHERE id=$id AND user_id=$uid");
header("Location: my_events.php");
?>
