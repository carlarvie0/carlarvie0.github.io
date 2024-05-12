<?php
session_start();

include("conn/connection.php");
include("user/functions.php");

$user_data = check_login($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    $event_name = $_POST["event_name"];
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];
    $event_description = $_POST["event_description"];

    $update_query = "UPDATE events SET event_name='$event_name', event_date='$event_date', event_time='$event_time', event_description='$event_description' WHERE event_id=$id";
    if ($conn->query($update_query) === TRUE) {
        echo "Event updated successfully";
    } else {
        echo "Error updating event: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script>
    setTimeout(function() {
        window.location.href = 'all_events.php'; 
    }, 1000);
</script>
</body>
</html>