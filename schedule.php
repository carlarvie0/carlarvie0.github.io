<?php
session_start();

include("conn/connection.php");
include("user/functions.php");

$user_data = check_login($conn);


// Get current date and time
$current_datetime = date('Y-m-d H:i:s');

// Query to count events
$count_query = "SELECT COUNT(*) AS event_count FROM events WHERE event_date >= '$current_datetime'";
$count_result = $conn->query($count_query);
$count_row = $count_result->fetch_assoc();
$event_count = $count_row['event_count'];

// Query to fetch events that are not expired
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
        .navbar-nav{
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-right: 20px;
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
        .calendar-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .day {
            width: calc(100% / 7);
            padding: 20px 0;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .day:hover {
            background-color: #BED7DC;
            color: #333;
            border-radius: 50%;
        }
        .day.active {
            background-color: #007bff;
            color: white;
            border-radius: 50%;
        }
        #eventForm {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        button.btn-secondary {
            background-color: #007bff;
            border: none;
            color: #fff;
            transition: background-color 0.3s ease;
        }
        button.btn-secondary:hover {
            background-color: #0056b3;
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
            <li class="nav-item ">
                <a class="nav-link" href="index.php">Dashboard</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="calendar.php">Calendar</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="schedule.php">Add Schedule</a>
            </li>
            <li class="nav-item ">
            <a class="nav-link" href="about.php">About</a>
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
    <div id="eventForm">
        <h2>Add Event</h2>
        <form id="addEventForm" method="POST" action="conn/add_event.php">
            <div class="form-group">
                <label for="eventName">Event Name</label>
                <input type="text" class="form-control" id="eventName" name="eventName" required>
            </div>
            <div class="form-group">
                <label for="eventDate">Event Date</label>
                <input type="date" class="form-control" id="eventDate" name="eventDate" required>
            </div>
            <div class="form-group">
                <label for="eventTime">Event Time</label>
                <input type="time" class="form-control" id="eventTime" name="eventTime" required>
            </div>
            <div class="form-group">
                <label for="eventDescription">Event Description</label>
                <textarea class="form-control" id="eventDescription" name="eventDescription" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-secondary">Add Event</button>
        </form>
    </div>
</div>


<script>
    <?php if(isset($_SESSION['success_message'])) { ?>
        alert("<?php echo $_SESSION['success_message']; ?>");
    <?php 
        unset($_SESSION['success_message']);
    } ?>
    </script>


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
                            <i class="fab fa-facebook-f mr-1"></i> CarlArvie Avanzado
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</html>
