<?php

include("../db.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>User Login</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
body{
    min-height:100vh;
    background: linear-gradient(135deg,#667eea,#764ba2,#43cea2);
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'Segoe UI',sans-serif;
}

.login-card{
    background:rgba(255,255,255,0.18);
    backdrop-filter:blur(15px);
    border-radius:20px;
    padding:35px;
    width:100%;
    max-width:420px;
    box-shadow:0 20px 45px rgba(0,0,0,0.4);
    color:#fff;
}

.form-control{
    border-radius:12px;
}

.input-group-text{
    background:#fff;
    border-radius:12px 0 0 12px;
}

.btn-login{
    border-radius:30px;
    font-weight:600;
    padding:10px;
}

</style>
</head>

<body>

<div class="login-card">

<h3 class="text-center mb-2">
<i class="fas fa-user-lock"></i> User Login
</h3>

<p class="text-center small mb-4">
Login to access your event dashboard
</p>

<form method="post">

<!-- EMAIL -->
<div class="form-group">
<div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text"><i class="fas fa-envelope"></i></span>
</div>
<input type="email" name="email" class="form-control" placeholder="Email Address" required>
</div>
</div>

<!-- PASSWORD -->
<div class="form-group">
<div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text"><i class="fas fa-lock"></i></span>
</div>
<input type="password" name="password" id="pass" class="form-control" placeholder="Password" required>
<div class="input-group-append">
<span class="input-group-text" onclick="togglePass()" style="cursor:pointer">
<i class="fas fa-eye"></i>
</span>
</div>
</div>
</div>

<button name="login" class="btn btn-primary btn-block btn-login">
Login
</button>

<p class="text-center mt-3 small">
Don't have an account?
<a href="register.php" class="text-white font-weight-bold">Register Now</a>
</p>

</form>

<?php
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $res = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$pass'");
    if(mysqli_num_rows($res)==1){
        $row = mysqli_fetch_assoc($res);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];

        echo "<script>window.location='dashboard.php';</script>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Invalid Email or Password</div>";
    }
}
?>

</div>

<script>
function togglePass(){
    var p = document.getElementById("pass");
    p.type = (p.type === "password") ? "text" : "password";
}
</script>

</body>
</html>
