<?php
include("../db.php");
if(!isset($_SESSION['user_id'])) header("Location: login.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>Events</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
body {
    background: linear-gradient(135deg, #74ebd5, #ACB6E5);
    font-family: 'Segoe UI', sans-serif;
    padding-top: 40px;
}

/* Page title */
h3 {
    text-align: center;
    margin-bottom: 30px;
    color: #fff;
    font-size: 2.5rem;
    text-shadow: 2px 2px 5px rgba(0,0,0,0.3);
}

/* Card design */
.card {
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    transition: 0.3s;
    position: relative;
    overflow: hidden;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}

/* Ribbon for new event */
.ribbon {
    width: 150px;
    height: 30px;
    background: #ff5e57;
    color: #fff;
    text-align: center;
    line-height: 30px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: -45px;
    transform: rotate(45deg);
    box-shadow: 0 3px 10px rgba(0,0,0,0.3);
    font-size: 0.85rem;
}

/* Event title */
.card h5 {
    font-weight: 700;
    color: #333;
}

/* Event description */
.card p {
    font-size: 0.95rem;
    color: #555;
}

/* Badges */
.badge {
    font-size: 0.9rem;
    padding: 0.5em 0.8em;
    border-radius: 50px;
}

/* Buttons */
.btn-primary {
    border-radius: 50px;
    font-weight: 600;
    transition: 0.3s;
}
.btn-primary:hover {
    transform: scale(1.05);
}

/* Responsive spacing */
@media(max-width: 767px){
    .card { margin: 20px auto; }
}
</style>
</head>
<body>

<div class="container">
<h3><i class="fas fa-calendar-alt"></i> Available Events</h3>

<?php
$events=mysqli_query($conn,"SELECT * FROM events");

while($e=mysqli_fetch_assoc($events)){

$eid=$e['id'];
$uid=$_SESSION['user_id'];

$count=mysqli_query($conn,"SELECT COUNT(*) as total FROM registrations WHERE event_id=$eid AND status!='Rejected'");
$data=mysqli_fetch_assoc($count);

$seats_left=$e['total_seats'] - $data['total'];

$check=mysqli_query($conn,"SELECT * FROM registrations WHERE user_id=$uid AND event_id=$eid");
$already=mysqli_num_rows($check);

// Determine badge color
if($already){
    $badge = '<span class="badge badge-info"><i class="fas fa-check"></i> Already Registered</span>';
} elseif($seats_left<=0){
    $badge = '<span class="badge badge-danger"><i class="fas fa-times"></i> Seats Full</span>';
} elseif($seats_left <=5){
    $badge = '<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Few Seats Left</span>';
} else {
    $badge = '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Seats Available</span>';
}

// Ribbon
$event_date = strtotime($e['event_date']);
$today = strtotime(date('Y-m-d'));
$ribbon = ($today - $event_date <= 7*86400) ? '<div class="ribbon">NEW</div>' : '';
?>

<div class="card mt-3">
    <?= $ribbon ?>
    <div class="card-body">
        <h5><i class="fas fa-star text-warning"></i> <?= $e['title'] ?></h5>
        <p><?= $e['description'] ?></p>
        <p><b>Date:</b> <i class="fas fa-calendar-alt"></i> <?= $e['event_date'] ?></p>
        <p><b>Seats Left:</b> <i class="fas fa-chair"></i> <?= $seats_left ?></p>
        <?= $badge ?>

        <?php if(!$already && $seats_left>0){ ?>
        <form method="post" class="mt-2">
            <input type="hidden" name="event_id" value="<?= $eid ?>">
            <button name="register" class="btn btn-primary btn-block">
                <i class="fas fa-ticket-alt"></i> Register
            </button>
        </form>
        <?php } ?>
    </div>
</div>

<?php } ?>

<?php
if(isset($_POST['register'])){
    $eid=$_POST['event_id'];
    $uid=$_SESSION['user_id'];

    mysqli_query($conn,"INSERT INTO registrations(user_id,event_id) VALUES('$uid','$eid')");
    echo "<script>alert('Registration Successful');window.location='events.php';</script>";
}
?>

<!-- ✅ Back Button Bottom with Space -->
<div class="text-center mt-5 mb-5">
    <button class="btn btn-dark px-4" onclick="history.back()">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
