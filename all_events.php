<?php
session_start();
	include("conn/connection.php");
    
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
    <title>Event Listing</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: rgb(241, 238, 220);
        }
        .event {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #fff;
        }
        .event h2 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #333; 
        }
        .event p {
            margin-bottom: 5px;
            color: #555;
        }
        .btn-group {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<button class="btn btn-primary mt-4" onclick="window.location.href='calendar.php'">Back to Calendar</button>

<div class="container">
    <h1 class="mb-4">Upcoming Events</h1>
    <?php

    $sql_upcoming = "SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC, event_time ASC";
    $result_upcoming = $conn->query($sql_upcoming);

    if ($result_upcoming && $result_upcoming->num_rows > 0) {
        while($row = $result_upcoming->fetch_assoc()) {
            echo "<div class='event'>";
            echo "<h2>" . $row["event_name"] . "</h2>";
            echo "<p>Date: " . $row["event_date"] . "</p>";
            echo "<p>Time: " . $row["event_time"] . "</p>";
            echo "<p>Description: " . $row["event_description"] . "</p>";
            echo "<div class='btn-group'>";
            echo "<a href='edit_event.php?id=" . $row["event_id"] . "' class='btn btn-primary mr-2'>Edit</a>";
            echo "<a href='delete_event.php?id=" . $row["event_id"] . "' class='btn btn-danger'>Delete</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p class='text-muted'>No upcoming events found.</p>";
    }

    $conn->close();
    ?>
</div>

<div class="container">
    <h1 class="mb-4">Finished Events</h1>
    <?php
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_finished = "SELECT * FROM events WHERE event_date < CURDATE() ORDER BY event_date DESC, event_time DESC";
    $result_finished = $conn->query($sql_finished);

    if ($result_finished && $result_finished->num_rows > 0) {
        while($row = $result_finished->fetch_assoc()) {
            echo "<div class='event'>";
            echo "<h2>" . $row["event_name"] . "</h2>";
            echo "<p>Date: " . $row["event_date"] . "</p>";
            echo "<p>Time: " . $row["event_time"] . "</p>";
            echo "<p>Description: " . $row["event_description"] . "</p>";
            echo "<div class='btn-group'>";
            echo "<a href='edit_event.php?id=" . $row["event_id"] . "' class='btn btn-primary mr-2'>Edit</a>";
            echo "<a href='delete_event.php?id=" . $row["event_id"] . "' class='btn btn-danger'>Delete</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p class='text-muted'>No finished events found.</p>";
    }

    $conn->close();
    ?>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
</body>
</html>
