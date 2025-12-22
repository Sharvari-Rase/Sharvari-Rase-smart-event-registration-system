<?php 
include("db.php");

/* Live Counters */
$event_count = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM events"))['total'];
$user_count  = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM users"))['total'];
$reg_count   = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM registrations"))['total'];

/* Slider Events */
$slider = mysqli_query($conn,"SELECT * FROM events WHERE event_image!='' ORDER BY event_date ASC LIMIT 3");

/* Upcoming Events */
$upcoming = mysqli_query($conn,"SELECT * FROM events ORDER BY event_date ASC LIMIT 3");

/* Next Event for Countdown */
$next_event = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM events ORDER BY event_date ASC LIMIT 1"));
$next_event_date = $next_event ? $next_event['event_date'] : null;
?>

<!DOCTYPE html>
<html>
<head>
<title>Smart Online Event Registration System</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* ----- GENERAL ----- */
body{
    font-family:'Segoe UI',sans-serif;
    scroll-behavior: smooth;
    background: linear-gradient(135deg,#667eea,#764ba2,#43cea2);
    color:#fff;
    margin:0;
    padding:0;
    transition: background 0.5s, color 0.5s;
}
body.light-mode{
    background: #f2f2f2;
    color:#333;
}

/* ----- NAVBAR ----- */
.navbar{
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(10px);
    transition: background 0.3s;
}
.navbar.light-mode{
    background: rgba(255,255,255,0.85);
}
.navbar a{
    color:#fff;
    font-weight:600;
    transition:0.3s;
}
.navbar.light-mode a{ color:#333; }
.navbar a:hover{
    color:#43cea2;
}

/* ----- GLASS HERO ----- */
.glass{
    background: linear-gradient(135deg, rgba(0,0,0,0.5), rgba(0,0,0,0.3));
    backdrop-filter: blur(20px);
    border-radius:25px;
    box-shadow:0 25px 45px rgba(0,0,0,0.3);
    color:#fff;
    text-align:center;
    padding:50px 20px;
    margin-top:80px;
    animation: fadeIn 1.5s ease-in-out;
}
body.light-mode .glass{ background: rgba(255,255,255,0.85); color:#333; }

/* ----- ANIMATION ----- */
@keyframes fadeIn{
    0%{ opacity:0; transform: translateY(-20px); }
    100%{ opacity:1; transform: translateY(0); }
}

/* ----- BUTTONS ----- */
.btn-custom{
    border-radius:50px;
    padding:10px 25px;
    font-weight:600;
    transition:0.4s;
}
.btn-custom:hover{
    transform: translateY(-3px);
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

/* ----- SLIDER ----- */
.carousel-inner{
    border-radius:20px;
    overflow:hidden;
    position:relative;
}
.carousel-item{
    height:380px;
}
.carousel-item img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition: transform 0.5s;
}
.carousel-item img:hover{
    transform: scale(1.05);
}
.slider-overlay{
    position:absolute;
    bottom:0;
    width:100%;
    background:linear-gradient(to top,rgba(0,0,0,0.7),transparent);
    padding:15px;
    text-align:center;
}
.slider-overlay h5{
    font-weight:700;
    text-shadow:2px 2px 10px rgba(0,0,0,0.7);
}
.slider-overlay p{
    font-size:0.95rem;
    margin-top:5px;
}

/* ----- COUNTERS ----- */
.counter{
    font-size:3rem;
    font-weight:900;
}
.counter::after{
    content:"";
    display:block;
    width:60px;
    height:3px;
    margin:8px auto 0;
    background: linear-gradient(90deg,#667eea,#43cea2);
    border-radius:2px;
}

/* ----- ROLE CARDS ----- */
.role-card{
    background:#fff;
    color:#333;
    border-radius:18px;
    transition:0.4s;
    padding:20px;
    text-align:center;
}
.role-card:hover{
    transform:translateY(-10px);
    box-shadow:0 18px 30px rgba(0,0,0,0.35);
}
.role-card i{
    display:inline-block;
    padding:15px;
    border-radius:50%;
    background: linear-gradient(45deg,#667eea,#43cea2);
    color:#fff;
    margin-bottom:15px;
    transition:0.4s;
}
.role-card:hover i{
    transform: rotate(10deg) scale(1.1);
}

/* ----- EVENT BOX ----- */
.event-box{
    background:#fff;
    color:#333;
    border-radius:15px;
    padding:15px;
    box-shadow:0 10px 20px rgba(0,0,0,0.2);
    transition:0.3s;
    position:relative;
}
.event-box:hover{
    transform: translateY(-5px);
    box-shadow:0 12px 25px rgba(0,0,0,0.25);
}

/* ----- ABOUT SECTION ----- */
.about-section, .contact-section{
    background: linear-gradient(135deg, rgba(0,0,0,0.5), rgba(0,0,0,0.3));
    backdrop-filter: blur(20px);
    border-radius:20px;
    padding:40px 30px;
    margin-top:40px;
    text-align:center;
}
body.light-mode .about-section, body.light-mode .contact-section{ background:#f2f2f2; color:#333; }

/* ----- CONTACT SECTION ----- */
.contact-section a:hover{ color:#43cea2; }

/* ----- FOOTER ----- */
footer{
    background: linear-gradient(135deg,#667eea,#764ba2);
    padding:15px 0;
    font-size:0.9rem;
    text-align:center;
}

/* ----- BACK TO TOP BUTTON ----- */
#backToTop{
    position:fixed;
    bottom:20px;
    right:20px;
    background:#43cea2;
    color:#fff;
    border:none;
    padding:10px 15px;
    border-radius:50px;
    cursor:pointer;
    display:none;
    z-index:99;
}
#backToTop:hover{ background:#667eea; }

/* ----- LIGHT MODE TOGGLE ----- */
#toggleMode{
    position:fixed;
    bottom:20px;
    left:20px;
    background:#fff;
    color:#333;
    border:none;
    padding:10px 15px;
    border-radius:50px;
    cursor:pointer;
    z-index:99;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}
#toggleMode:hover{ background:#43cea2; color:#fff; }

/* ----- RESPONSIVE ----- */
@media(max-width:768px){
    .carousel-item{ height:250px; }
    .glass h1{ font-size:2rem; }
    .counter{ font-size:2rem; }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top">
<div class="container">
<a class="navbar-brand" href="#">Event Registration</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav ml-auto">
<li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
<li class="nav-item"><a class="nav-link" href="#about">About</a></li>
<li class="nav-item"><a class="nav-link" href="#upcoming">Upcoming Events</a></li>
<li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
</ul>
</div>
</div>
</nav>

<div class="container py-5" id="home">

<div class="glass p-5 text-center">
<h1>Smart Online Event Registration System</h1>
<p class="lead">Digital platform for managing college workshops & events</p>

<!-- COUNTDOWN FOR NEXT EVENT -->
<?php if($next_event_date){ ?>
<div class="mt-3 mb-4">
<h5>Next Event: <?= $next_event['title'] ?></h5>
<p id="countdown" style="font-size:1.2rem;font-weight:bold;"></p>
</div>
<?php } ?>

<!-- IMAGE SLIDER -->
<div id="eventSlider" class="carousel slide carousel-fade mt-4" data-ride="carousel" data-interval="3000">
<ol class="carousel-indicators">
<?php $i=0; while($s=mysqli_fetch_assoc($slider)){ ?>
<li data-target="#eventSlider" data-slide-to="<?= $i ?>" class="<?= ($i==0)?'active':'' ?>"></li>
<?php $i++; } ?>
</ol>
<div class="carousel-inner">
<?php mysqli_data_seek($slider,0); $i=0; while($s=mysqli_fetch_assoc($slider)){ ?>
<div class="carousel-item <?= ($i==0)?'active':'' ?>">
<img src="uploads/<?= $s['event_image'] ?>" alt="<?= $s['title'] ?>">
<div class="slider-overlay">
<h5><?= $s['title'] ?></h5>
<p><?= substr($s['description'] ?? '',0,70) ?>...</p>
</div>
</div>
<?php $i++; } ?>
</div>
<a class="carousel-control-prev" href="#eventSlider" data-slide="prev"><span class="carousel-control-prev-icon"></span></a>
<a class="carousel-control-next" href="#eventSlider" data-slide="next"><span class="carousel-control-next-icon"></span></a>
</div>

<!-- COUNTERS -->
<div class="row mt-5 text-center">
<div class="col-md-4 mb-3"><div class="counter text-warning"><?= $event_count ?></div><p>Total Events</p></div>
<div class="col-md-4 mb-3"><div class="counter text-info"><?= $user_count ?></div><p>Registered Users</p></div>
<div class="col-md-4 mb-3"><div class="counter text-success"><?= $reg_count ?></div><p>Total Registrations</p></div>
</div>
</div>

<!-- ROLE CARDS -->
<div class="row mt-4 text-center">
<div class="col-md-4 mb-3">
<div class="role-card"><i class="fas fa-user-plus fa-2x"></i><h5>User Registration</h5><a href="user/register.php" class="btn btn-success btn-block btn-custom">Register</a></div>
</div>
<div class="col-md-4 mb-3">
<div class="role-card"><i class="fas fa-sign-in-alt fa-2x"></i><h5>User Login</h5><a href="user/login.php" class="btn btn-primary btn-block btn-custom">Login</a></div>
</div>
<div class="col-md-4 mb-3">
<div class="role-card"><i class="fas fa-user-shield fa-2x"></i><h5>Admin Panel</h5><a href="admin/admin_login.php" class="btn btn-dark btn-block btn-custom">Admin Login</a></div>
</div>
</div>

<hr style="background:#fff;opacity:0.4">

<!-- UPCOMING EVENTS WITH SEARCH -->
<div id="upcoming">
<h4 class="mt-4">Upcoming Events</h4>
<input type="text" id="searchEvents" class="form-control mb-3" placeholder="Search events...">
<div class="row mt-3" id="eventList">
<?php mysqli_data_seek($upcoming,0); while($e=mysqli_fetch_assoc($upcoming)){ ?>
<div class="col-md-4 mb-3 event-item">
<div class="event-box">
<h6><?= $e['title'] ?></h6>
<p>Date: <?= $e['event_date'] ?></p>
<p><?= substr($e['description'] ?? '', 0, 50) ?>...</p>
</div>
</div>
<?php } ?>
</div>
</div>

<!-- ABOUT SECTION -->
<div id="about" class="about-section">
<h4>About This System</h4>
<p>Smart Online Event Registration System is designed to simplify the management of college workshops and events.
Users can easily register and login to view and participate in upcoming events. Administrators can manage events and track registrations efficiently.</p>
<div class="row mt-4 text-center">
<div class="col-md-4 mb-3"><i class="fas fa-user-plus fa-2x mb-2"></i><h6>Easy Registration</h6><p class="feature-text">Register quickly with a simple user form and start participating in events.</p></div>
<div class="col-md-4 mb-3"><i class="fas fa-calendar-alt fa-2x mb-2"></i><h6>Upcoming Events</h6><p class="feature-text">Stay updated with the latest workshops and events organized by your college.</p></div>
<div class="col-md-4 mb-3"><i class="fas fa-chart-line fa-2x mb-2"></i><h6>Track Registrations</h6><p class="feature-text">Admin panel allows tracking of all registrations and event analytics efficiently.</p></div>
</div>
</div>

<!-- CONTACT SECTION -->
<div id="contact" class="contact-section">
<h4>Contact Us</h4>
<p>Email: <a href="mailto:info@collegeevents.com">info@collegeevents.com</a></p>
<p>Phone: <a href="tel:+919876543210">+91 98765 43210</a></p>
<p>Follow us:
<a href="#"><i class="fab fa-facebook-f mx-1"></i></a>
<a href="#"><i class="fab fa-twitter mx-1"></i></a>
<a href="#"><i class="fab fa-instagram mx-1"></i></a>
</p>
</div>

<!-- BACK TO TOP BUTTON -->
<button id="backToTop" onclick="scrollToTop()"><i class="fas fa-arrow-up"></i></button>
<!-- LIGHT MODE TOGGLE -->
<button id="toggleMode" onclick="toggleMode()"><i class="fas fa-adjust"></i></button>

<footer class="text-light mt-4">
© 2025 | Online Event Registration System | Developed By Sharvari Rase
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// COUNTER ANIMATION
$('.counter').each(function () {
  $(this).prop('Counter',0).animate({Counter: $(this).text()}, {
    duration: 2000,
    easing: 'swing',
    step: function (now){$(this).text(Math.ceil(now));}
  });
});

// BACK TO TOP BUTTON
window.onscroll = function(){
    if(document.body.scrollTop > 200 || document.documentElement.scrollTop > 200){
        document.getElementById("backToTop").style.display = "block";
    } else {
        document.getElementById("backToTop").style.display = "none";
    }
};
function scrollToTop(){ window.scrollTo({top:0, behavior:'smooth'}); }

// LIGHT/DARK MODE
function toggleMode(){
    document.body.classList.toggle("light-mode");
    document.querySelector(".navbar").classList.toggle("light-mode");
}

// UPCOMING EVENTS SEARCH
$("#searchEvents").on("keyup", function(){
    var value = $(this).val().toLowerCase();
    $(".event-item").filter(function(){
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});

// COUNTDOWN TIMER
<?php if($next_event_date){ ?>
var countDownDate = new Date("<?= $next_event_date ?>").getTime();
var x = setInterval(function(){
    var now = new Date().getTime();
    var distance = countDownDate - now;
    if(distance < 0){ document.getElementById("countdown").innerHTML = "Event Started!"; clearInterval(x); return; }
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000*60*60*24))/(1000*60*60));
    var minutes = Math.floor((distance % (1000*60*60))/(1000*60));
    var seconds = Math.floor((distance % (1000*60))/1000);
    document.getElementById("countdown").innerHTML = days+"d "+hours+"h "+minutes+"m "+seconds+"s";
},1000);
<?php } ?>
</script>

</body>
</html>