<?php 
include("../db.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Participants</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script>
function searchTable() {
    var input = document.getElementById("searchInput");
    var filter = input.value.toLowerCase();
    var rows = document.getElementById("regTable").getElementsByTagName("tr");

    for (var i = 1; i < rows.length; i++) {
        var show = false;
        var cells = rows[i].getElementsByTagName("td");
        for (var j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(filter)) {
                show = true;
            }
        }
        rows[i].style.display = show ? "" : "none";
    }
}
</script>
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📋 Event Registrations</h4>
            <input type="text" id="searchInput" onkeyup="searchTable()" 
                   class="form-control w-25" placeholder="Search...">
        </div>

        <div class="card-body">

            <table class="table table-hover table-bordered text-center" id="regTable">
                <thead class="thead-dark">
                    <tr>
                        <th>User Name</th>
                        <th>Event Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $q=mysqli_query($conn,"
                SELECT registrations.id, users.name, events.title, registrations.status
                FROM registrations
                JOIN users ON registrations.user_id=users.id
                JOIN events ON registrations.event_id=events.id
                ");

                while($r=mysqli_fetch_assoc($q)){

                    // status badge color (display only)
                    if($r['status']=="Approved")
                        $badge="success";
                    else if($r['status']=="Rejected")
                        $badge="danger";
                    else
                        $badge="warning";
                ?>
                    <tr>
                        <td><?= $r['name'] ?></td>
                        <td><?= $r['title'] ?></td>
                        <td>
                            <span class="badge badge-<?= $badge ?> p-2">
                                <?= $r['status'] ?>
                            </span>
                        </td>
                        <td>
                            <a href="approve.php?id=<?= $r['id'] ?>" class="btn btn-success btn-sm mr-1">
                                ✔ Approve
                            </a>
                            <a href="reject.php?id=<?= $r['id'] ?>" class="btn btn-danger btn-sm">
                                ✖ Reject
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <div class="text-right">
                <a href="admin_dashboard.php" class="btn btn-secondary">
                    ⬅ Back to Dashboard
                </a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
