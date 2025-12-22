<?php 
include("../db.php");
if(!isset($_SESSION['user_id'])) header("Location: login.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Events</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
body {
    background: linear-gradient(135deg, #FFDEE9, #B5FFFC);
    font-family: 'Segoe UI', sans-serif;
    padding-top: 40px;
}

/* Page title */
h3 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
    font-size: 2rem;
    font-weight: bold;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
}

/* Card wrapper for table */
.card-table {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    background: #fff;
    transition: 0.3s;
}
.card-table:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.25);
}

/* Table styling */
.table {
    margin-bottom: 0;
}
.table th {
    background: #6c5ce7;
    color: #fff;
    font-weight: 600;
    text-align: center;
}
.table td {
    vertical-align: middle;
    text-align: center;
}

/* Striped effect */
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(108,92,231,0.05);
}

/* Status badges */
.badge {
    font-size: 0.9rem;
    padding: 0.5em 0.8em;
    border-radius: 50px;
}

/* Buttons */
.btn {
    border-radius: 50px;
    font-weight: 600;
    transition: 0.3s;
}
.btn:hover {
    transform: scale(1.05);
}

/* Back button */
.btn-secondary {
    background: #636e72;
    border: none;
}
.btn-secondary:hover {
    background: #2d3436;
}

/* Responsive */
@media(max-width: 767px){
    .table { font-size: 0.9rem; }
    .btn { font-size: 0.8rem; }
}
</style>
</head>
<body>

<div class="container">
<h3><i class="fas fa-calendar-check"></i> My Registered Events</h3>

<div class="card-table p-3">
<table class="table table-bordered table-hover table-striped text-center">
<tr>
<th>Event</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$uid=$_SESSION['user_id'];

$q=mysqli_query($conn,"
SELECT registrations.id, events.title, events.event_date, registrations.status
FROM registrations
JOIN events ON registrations.event_id=events.id
WHERE registrations.user_id=$uid
");

while($row=mysqli_fetch_assoc($q)){
$status=$row['status'];
$badge="secondary";
if($status=="Approved") $badge="success";
if($status=="Rejected") $badge="danger";
?>
<tr>
<td><i class="fas fa-star text-warning"></i> <?= $row['title'] ?></td>
<td><i class="fas fa-calendar-alt text-primary"></i> <?= $row['event_date'] ?></td>
<td><span class="badge badge-<?= $badge ?>"><?= $status ?></span></td>
<td>
<?php if($status=="Pending"){ ?>
<a href="cancel.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-times-circle"></i> Cancel</a>
<?php } else { echo "-"; } ?>
</td>
</tr>
<?php } ?>
</table>
</div>

<div class="text-center mt-3">
<a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
