<?php

include("../db.php");
if(!isset($_SESSION['user_id'])) header("Location: login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
    min-height: 100vh;
    background: linear-gradient(135deg,#1f4068,#2980b9);
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI', sans-serif;
    color: #fff;
}
.dashboard-container {
    text-align: center;
    width: 100%;
    max-width: 900px;
    padding: 30px;
}
.dashboard-container h2 {
    font-weight: 700;
    margin-bottom: 30px;
    text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
}
.card-link {
    text-decoration: none;
}
.card {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    transition: 0.4s;
    color: #fff;
}
.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}
.card i {
    font-size: 40px;
    margin-bottom: 15px;
}
.card h4 {
    font-weight: 600;
}
.row {
    gap: 20px;
}
@media(max-width: 600px){
    .row {
        flex-direction: column;
    }
}
</style>
</head>
<body>

<div class="dashboard-container">
    <h2>Welcome, User!</h2>
    <div class="row d-flex justify-content-center">

        <a href="events.php" class="card-link col-md-3 col-sm-6">
            <div class="card p-4">
                <i class="fa-solid fa-calendar-days"></i>
                <h4>View Events</h4>
            </div>
        </a>

        <a href="my_events.php" class="card-link col-md-3 col-sm-6">
            <div class="card p-4">
                <i class="fa-solid fa-ticket"></i>
                <h4>My Registrations</h4>
            </div>
        </a>

        <a href="logout.php" class="card-link col-md-3 col-sm-6">
            <div class="card p-4">
                <i class="fa-solid fa-right-from-bracket"></i>
                <h4>Logout</h4>
            </div>
        </a>

    </div>
</div>

</body>
</html>
