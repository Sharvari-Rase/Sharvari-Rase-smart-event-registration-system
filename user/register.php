<?php include("../db.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>User Registration</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

.glass{
    background:rgba(255,255,255,0.2);
    backdrop-filter:blur(15px);
    border-radius:20px;
    padding:30px;
    width:100%;
    max-width:420px;
    box-shadow:0 20px 40px rgba(0,0,0,0.4);
    color:#fff;
}

.form-control{
    border-radius:12px;
}

.input-group-text{
    background:#fff;
    border-radius:12px 0 0 12px;
}

.btn-custom{
    border-radius:30px;
    font-weight:600;
}
</style>
</head>

<body>

<div class="glass">

<h3 class="text-center mb-3">
<i class="fas fa-user-plus"></i> User Registration
</h3>
<p class="text-center small">Create your account to register for events</p>

<form method="post">

<!-- NAME -->
<div class="form-group">
<div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text"><i class="fas fa-user"></i></span>
</div>
<input type="text" name="name" class="form-control" placeholder="Full Name" required>
</div>
</div>

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

<button name="register" class="btn btn-success btn-block btn-custom">
Register Now
</button>

<p class="text-center mt-3 small">
Already registered?  
<a href="login.php" class="text-white font-weight-bold">Login</a>
</p>

</form>

<?php
if(isset($_POST['register'])){
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    // Check duplicate email
    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check)>0){
        echo "<div class='alert alert-danger mt-3'>Email already registered!</div>";
    }else{
        $q = mysqli_query($conn,"INSERT INTO users(name,email,password) VALUES('$name','$email','$pass')");
        if($q){
            echo "<div class='alert alert-success mt-3'>Registration successful! <a href='login.php'>Login Now</a></div>";
        }
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
