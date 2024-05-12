<?php
session_start(); // Start the session
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $conn->real_escape_string($_POST['eventName']);
    $eventDate = $conn->real_escape_string($_POST['eventDate']);
    $eventTime = $conn->real_escape_string($_POST['eventTime']);
    $eventDescription = $conn->real_escape_string($_POST['eventDescription']);

    $sql = "INSERT INTO events (event_name, event_date, event_time, event_description) VALUES ('$eventName', '$eventDate', '$eventTime', '$eventDescription')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Event added successfully"; // Set success message in session
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

header("Location: ../schedule.php"); // Redirect back to index.php
?>
