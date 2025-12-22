<?php
include("../db.php");
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    min-height:100vh;
    background: linear-gradient(135deg, #f4f7fb, #e9eef5); /* LIGHT PROFESSIONAL */
    font-family:'Segoe UI',sans-serif;
    color:#212529;
}

/* Navbar */
.navbar{
    background:rgba(0,0,0,0.65)!important;
    backdrop-filter: blur(10px);
}

/* Glass container */
.glass{
    background:rgba(255,255,255,0.75);
    backdrop-filter: blur(12px);
    border-radius:20px;
    padding:30px;
    box-shadow:0 15px 40px rgba(0,0,0,0.15);
}

/* Cards */
.admin-card{
    background:#ffffff;
    border-radius:18px;
    padding:30px;
    text-align:center;
    transition:0.4s;
    cursor:pointer;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
}
.admin-card:hover{
    transform:translateY(-8px) scale(1.02);
    box-shadow:0 15px 30px rgba(0,0,0,0.2);
}
.admin-card i{
    font-size:40px;
    margin-bottom:15px;
}
.admin-card h5{
    font-weight:700;
}

/* Footer */
.footer{
    text-align:center;
    color:#666;
    margin-top:30px;
    font-size:14px;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark px-4">
    <span class="navbar-brand font-weight-bold">
        <i class="fa-solid fa-user-shield"></i> Admin Panel
    </span>
    <div>
        <span class="mr-3 text-white">Welcome, <b><?php echo $_SESSION['admin']; ?></b></span>
        <a href="logout.php" class="btn btn-danger btn-sm">
            <i class="fa fa-sign-out-alt"></i> Logout
        </a>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-5">
    <div class="glass">

        <h3 class="mb-4 text-center">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </h3>

        <div class="row">

            <!-- ADD EVENT -->
            <div class="col-md-4 mb-4">
                <div class="admin-card" onclick="location.href='add_event.php'">
                    <i class="fa fa-calendar-plus text-success"></i>
                    <h5>Add New Event</h5>
                    <p>Create and publish new events</p>
                </div>
            </div>

            <!-- MANAGE EVENTS -->
            <div class="col-md-4 mb-4">
                <div class="admin-card" onclick="location.href='view_events.php'">
                    <i class="fa fa-list-check text-info"></i>
                    <h5>Manage Events</h5>
                    <p>Edit / delete existing events</p>
                </div>
            </div>

            <!-- VIEW PARTICIPANTS -->
            <div class="col-md-4 mb-4">
                <div class="admin-card" onclick="location.href='view_participants.php'">
                    <i class="fa fa-users text-warning"></i>
                    <h5>Participants</h5>
                    <p>View registered participants</p>
                </div>
            </div>

        </div>
    </div>

    <div class="footer">
        © 2025 | Online Event Registration System | Admin Module
    </div>
</div>

</body>
</html>
