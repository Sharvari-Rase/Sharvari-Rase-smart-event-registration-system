<?php
include("../db.php");

$error = "";

if(isset($_POST['login'])){
    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $p = mysqli_real_escape_string($conn, $_POST['password']); // plain password

    // Fetch admin record
    $res = mysqli_query($conn, "SELECT * FROM admin WHERE username='$u' LIMIT 1");

    if(mysqli_num_rows($res) == 1){
        $row = mysqli_fetch_assoc($res);

        // ✅ PLAIN PASSWORD CHECK (FIXED)
        if($p == $row['password']){
            $_SESSION['admin'] = $u;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid admin username or password";
        }
    } else {
        $error = "Invalid admin username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#1f4068,#2980b9);
}

.admin-card{
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(15px);
    border-radius:20px;
    padding:40px 30px;
    width:100%;
    max-width:400px;
    box-shadow:0 8px 32px rgba(0,0,0,0.2);
    text-align:center;
}

.admin-card h3{
    color:#fff;
    font-weight:700;
    margin-bottom:25px;
}

.input-group-text{
    background:rgba(255,255,255,0.3);
    border:none;
    color:#fff;
}

.form-control{
    background:rgba(255,255,255,0.2);
    border:none;
    color:#fff;
}

.form-control::placeholder{
    color:#eee;
}

.btn-admin{
    background:#ff4b2b;
    color:#fff;
    font-weight:600;
    border-radius:50px;
}

.btn-admin:hover{
    background:#ff416c;
}

.alert{
    background:rgba(255,0,0,0.25);
    color:#fff;
    border:none;
}
</style>
</head>

<body>

<div class="admin-card">
    <h3><i class="fa-solid fa-user-shield"></i> Admin Login</h3>

    <?php if($error!=""){ ?>
        <div class="alert"><?php echo $error; ?></div>
    <?php } ?>

    <form method="post">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
            </div>
            <input type="text" name="username" class="form-control" placeholder="Admin Username" required>
        </div>

        <div class="input-group mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Admin Password" required>
            <div class="input-group-append">
                <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer;">
                    <i class="fa fa-eye"></i>
                </span>
            </div>
        </div>

        <button name="login" class="btn btn-admin btn-block">
            <i class="fa-solid fa-right-to-bracket"></i> Login
        </button>

    </form>
</div>

<script>
function togglePassword(){
    let p = document.getElementById("password");
    p.type = (p.type === "password") ? "text" : "password";
}
</script>

</body>
</html>
