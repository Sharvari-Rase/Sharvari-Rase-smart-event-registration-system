<?php

session_start();

$conn = mysqli_connect("localhost:3307", "root", "", "event_system");

if (!$conn) {
    die("Database Connection Failed");
}

?>
