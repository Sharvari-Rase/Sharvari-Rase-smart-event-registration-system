<?php
include("../db.php");
if(!isset($_SESSION['admin'])) header("Location: admin_login.php");

if(isset($_POST['add'])){

    $title = $_POST['title'];
    $desc  = $_POST['description'];
    $date  = $_POST['event_date'];
    $limit = $_POST['seats'];

    $image = $_FILES['event_image']['name'];
    $tmp   = $_FILES['event_image']['tmp_name'];

    move_uploaded_file($tmp, "../uploads/".$image);

    mysqli_query($conn,"INSERT INTO events
    (title, description, event_date, total_seats, event_image)
    VALUES
    ('$title','$desc','$date','$limit','$image')");

    echo "<div class='alert alert-success mt-3 text-center'>✅ Event Added Successfully</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Event</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script>
function previewImage(event){
    var reader = new FileReader();
    reader.onload = function(){
        document.getElementById('imgPreview').src = reader.result;
        document.getElementById('imgPreview').style.display = "block";
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-7">

<div class="card shadow-lg">

    <div class="card-header bg-success text-white text-center">
        <h4 class="mb-0">➕ Add New Event</h4>
    </div>

    <div class="card-body">

        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

            <div class="form-group">
                <label>📌 <b>Event Title</b></label>
                <input type="text" name="title" class="form-control" required>
                <div class="invalid-feedback">Please enter event title</div>
            </div>

            <div class="form-group">
                <label>📝 <b>Event Description</b></label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
                <div class="invalid-feedback">Please enter description</div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>📅 <b>Event Date</b></label>
                    <input type="date" name="event_date" class="form-control" required>
                    <div class="invalid-feedback">Select date</div>
                </div>

                <div class="form-group col-md-6">
                    <label>👥 <b>Total Seats</b></label>
                    <input type="number" name="seats" class="form-control" required>
                    <div class="invalid-feedback">Enter seats</div>
                </div>
            </div>

            <div class="form-group">
                <label>🖼 <b>Event Image</b></label>
                <input type="file" name="event_image" class="form-control-file"
                       onchange="previewImage(event)" required>
                <div class="invalid-feedback d-block">Upload image</div>

                <img id="imgPreview" src="" class="mt-3 rounded shadow"
                     style="display:none; width:100%; max-height:200px; object-fit:cover;">
            </div>

            <hr>

            <div class="text-center">
                <button name="add" class="btn btn-success px-4">
                    ✔ Add Event
                </button>
                <a href="admin_dashboard.php" class="btn btn-secondary px-4 ml-2">
                    ⬅ Back
                </a>
            </div>

        </form>

    </div>
</div>

</div>
</div>
</div>

<script>
(function () {
  'use strict';
  window.addEventListener('load', function () {
    var forms = document.getElementsByClassName('needs-validation');
    Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

</body>
</html>
