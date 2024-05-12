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
    <title>Delete Event</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(241, 238, 220);
            padding: 20px;
        }
        .message {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .success-message {
            color: #28a745;
        }
        .error-message {
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="message">
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
            $id = $_GET["id"];
            $sql = "DELETE FROM events WHERE event_id = $id";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='success-message'>Event deleted successfully</p>";
            } else {
                echo "<p class='error-message'>Error deleting event: " . $conn->error . "</p>";
            }
        }

        $conn->close();
        ?>
    </div>
</div>

<script>
    setTimeout(function() {
        window.location.href = 'all_events.php'; 
    }, 2000);
</script>



</body>
</html>
