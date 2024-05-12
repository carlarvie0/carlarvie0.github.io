
<?php

session_start();

	include("conn/connection.php");
	include("user/functions.php");

	$user_data = check_login($conn);

$current_datetime = date('Y-m-d H:i:s');

$count_query = "SELECT COUNT(*) AS event_count FROM events WHERE event_date >= '$current_datetime'";
$count_result = $conn->query($count_query);
$count_row = $count_result->fetch_assoc();
$event_count = $count_row['event_count'];

$events_query = "SELECT * FROM events WHERE event_date >= '$current_datetime'";
$events_result = $conn->query($events_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
    
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #333;
        }
        body {
            background-color: #F1EEDC;
            font-family: 'Arial', sans-serif;
        }
        .navbar-nav{
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-right: 20px;
        }
        .navbar-light .navbar-nav .nav-link {
            color: #333;
        }
        .navbar-light .navbar-nav .nav-link:hover {
            color: #007bff;
        }
        .navbar-light .navbar-nav .nav-item.active .nav-link {
            color: #007bff;
            border-bottom: 2px solid #B3C8CF;
        }
        .navbar-light .navbar-toggler-icon {
            background-color: #333;
        }
        .dropdown-menu {
            background-color: #E5DDC5;
        }
        .dropdown-item {
            color: #333;
        }
        .dropdown-item:hover {
            background-color: #B3C8CF;
            color: #007bff;
        }
        .btn-nav {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 18px;
            line-height: 18px;
            padding: 0;
            cursor: pointer;
        }
        .btn-nav:hover {
            background-color: #0056b3;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .list-group-item {
            background-color: #F8F9FA;
            border: none;
            padding: 15px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Scheduling System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Dashboard</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="calendar.php">Calendar</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="schedule.php">Add Schedule</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </a>
                <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="user/logout.php">Logout</a>
                </div>
            </li>
            Hello, <?php echo $user_data['username']; ?>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Event Count</h5>
                    <p class="card-text"><?php echo $event_count; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Upcoming Events</h5>
                    <ul class="list-group">
                        <?php
                        if ($events_result->num_rows > 0) {
                            while ($row = $events_result->fetch_assoc()) {
                                echo "<li class='list-group-item'>";
                                echo "<strong>Event Name:</strong> " . $row['event_name'] . "<br>";
                                echo "<strong>Date:</strong> " . $row['event_date'] . "<br>";
                                echo "<strong>Time:</strong> " . $row['event_time'] . "<br>";
                                echo "<strong>Description:</strong> " . $row['event_description'];
                                echo "</li>";
                            }
                        } else {
                            echo "<li class='list-group-item'>No upcoming events found</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

<footer class="footer mt-auto py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0 text-muted">Developed by <strong>Avanzado Carl Arvie L.</strong></p>
            </div>
            <div class="col-md-6">
                <ul class="list-inline text-md-right mb-0">
                    <li class="list-inline-item mr-4">
                        <a href="mailto:carlarvie0@gmail.com" class="text-decoration-none text-muted" target="_blank">
                            <i class="fas fa-envelope mr-1"></i> carlarvie0@gmail.com
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://www.facebook.com/carl.arvie.3" class="text-decoration-none text-muted" target="_blank">
                            <i class="fab fa-facebook-f mr-1"></i> FB: CarlArvie Avanzado
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</html>

<?php
$conn->close();
?>
