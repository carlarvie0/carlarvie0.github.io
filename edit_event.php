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
    <title>Edit Event</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(241, 238, 220);
            padding: 20px;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        input[type="text"],
        input[type="date"],
        input[type="time"],
        textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<button class="btn btn-danger mt-4" onclick="window.location.href='all_events.php'">Back</button>

<div class="container">
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql = "SELECT * FROM events WHERE event_id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <h2>Edit Event</h2>
            <form action="updateevent.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row["event_id"]; ?>">
                <div class="form-group">
                    <label for="event_name">Event Name:</label>
                    <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo $row["event_name"]; ?>">
                </div>
                <div class="form-group">
                    <label for="event_date">Event Date:</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" value="<?php echo $row["event_date"]; ?>">
                </div>
                <div class="form-group">
                    <label for="event_time">Event Time:</label>
                    <input type="time" class="form-control" id="event_time" name="event_time" value="<?php echo $row["event_time"]; ?>">
                </div>
                <div class="form-group">
                    <label for="event_description">Event Description:</label>
                    <textarea class="form-control" id="event_description" name="event_description"><?php echo $row["event_description"]; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
            <?php
        } else {
            echo "Event not found";
        }
    }

    $conn->close();
    ?>
</div>


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
