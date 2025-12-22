<?php include("../db.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>All Events</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script>
function searchEvents() {
    var input = document.getElementById("searchInput").value.toLowerCase();
    var rows = document.getElementById("eventTable").getElementsByTagName("tr");

    for (var i = 1; i < rows.length; i++) {
        var show = false;
        var cells = rows[i].getElementsByTagName("td");
        for (var j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(input)) {
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
            <h4 class="mb-0">📅 All Events</h4>
            <input type="text" id="searchInput" onkeyup="searchEvents()" 
                   class="form-control w-25" placeholder="Search event...">
        </div>

        <div class="card-body">

            <table class="table table-hover table-bordered text-center" id="eventTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Image</th>
                        <th>Event Title</th>
                        <th>Date</th>
                        <th>Seats</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $res=mysqli_query($conn,"SELECT * FROM events");
                while($row=mysqli_fetch_assoc($res)){
                ?>
                    <tr>
                        <td>
                            <img src="../uploads/<?= $row['event_image'] ?>" 
                                 width="70" height="50"
                                 class="rounded shadow-sm">
                        </td>
                        <td><?= $row['title'] ?></td>
                        <td><?= date("d M Y", strtotime($row['event_date'])) ?></td>
                        <td>
                            <span class="badge badge-info p-2">
                                <?= $row['total_seats'] ?>
                            </span>
                        </td>
                        <td>
                            <a href="delete_event.php?id=<?= $row['id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this event?');">
                                🗑 Delete
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
