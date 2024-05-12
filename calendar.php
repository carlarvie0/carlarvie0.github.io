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

$sql = "SELECT DATE(event_date) AS event_date FROM events";
$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row['event_date'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #F1EEDC;
            font-family: 'Arial', sans-serif;
        }
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
        .calendar-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .day {
            width: calc(100% / 7);
            padding: 15px 0;
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
        .navigation {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            align-items: center;
        }
        .month {
            font-size: 1.5rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        .weekdays {
            display: flex;
            justify-content: space-around;
            background-color: #F0F0F0;
            padding: 10px 0;
            font-weight: bold;
            border-radius: 10px;
        }
        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-gap: 0;
        }
        .day {
            width: 100%;
            text-align: center;
            padding: 20px 0;
            border-right: 1px solid #CCCCCC;
            border-bottom: 1px solid #CCCCCC;
            line-height: 40px;
        }
        .event-day {
            background-color: green !important;
            color: white !important;
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
            <li class="nav-item active">
                <a class="nav-link" href="calendar.php">Calendar</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="schedule.php">Add Schedule</a>
            </li>
            <li class="nav-item">
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

<button class="btn btn-primary" onclick="redirectToAllEvents()" style=" margin-top: 10px; padding: 10px 20px; font-size: 16px;">All Events</button>
<div class="calendar-container">
    <div class="calendar">
        <div class="navigation">
            <button class="btn btn-primary" onclick="previousMonth()">Previous Month</button>
            <div class="month" id="monthYear">
            </div>
            <button class="btn btn-primary" onclick="nextMonth()">Next Month</button>

        </div>
        <div class="weekdays">
            <div class="day">Sun</div>
            <div class="day">Mon</div>
            <div class="day">Tue</div>
            <div class="day">Wed</div>
            <div class="day">Thu</div>
            <div class="day">Fri</div>
            <div class="day">Sat</div>
        </div>
        <div class="days" id="daysContainer">
        </div>
    </div>
</div>

<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="eventDetails">
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('event-day')) {
        const selectedDate = `${currentYear}-${padNumber(currentMonth + 1)}-${padNumber(e.target.textContent)}`;
        fetchEventInformation(selectedDate);
    }
});

function fetchEventInformation(selectedDate) {
    $('#eventDetails').html('<p>Loading...</p>');
    fetch('get_event_info.php?date=' + selectedDate)
        .then(response => response.json())
        .then(data => {
            const eventDetails = document.getElementById('eventDetails');
            eventDetails.innerHTML = '';
            if (data.length > 0) {
                data.forEach(event => {
                    const eventInfo = document.createElement('div');
                    eventInfo.innerHTML = `<p><strong>Name:</strong> ${event.event_name}</p>
                                           <p><strong>Date:</strong> ${event.event_date}</p>
                                           <p><strong>Time:</strong> ${event.event_time}</p>
                                           <p><strong>Description:</strong> ${event.event_description}</p>`;
                    eventDetails.appendChild(eventInfo);
                });
            } else {
                eventDetails.textContent = 'No events found for this date.';
            }
            $('#eventModal').modal('show');
        })
        .catch(error => {
            console.error('Error fetching event information:', error);
            $('#eventDetails').html('<p>Error fetching data.</p>');
        });
}

function deleteEvent(eventId) {
    const selectedDate = $('#event_date').val(); 
    const dayElement = document.querySelector(`.day[event-date="${selectedDate}"]`);
    if (dayElement) {
        dayElement.classList.remove('event-day');
    }
}

    let currentMonth, currentYear;
    let events = <?php echo json_encode($events); ?>;

    function generateCalendar() {
        const today = new Date();
        currentMonth = today.getMonth();
        currentYear = today.getFullYear();
        updateCalendar();
    }

    function redirectToAllEvents() {
    window.location.href = 'all_events.php';
}

    function updateCalendar() {
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay(); 

        document.getElementById('monthYear').innerText = `${getMonthName(currentMonth)} ${currentYear}`;

        const daysContainer = document.getElementById('daysContainer');
        daysContainer.innerHTML = '';

        for (let i = 0; i < firstDayOfMonth; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.classList.add('day');
            daysContainer.appendChild(emptyDay);
        }

        for (let i = 1; i <= daysInMonth; i++) {
            const day = document.createElement('div');
            day.classList.add('day');
            day.textContent = i;

            if (events.includes(`${currentYear}-${padNumber(currentMonth + 1)}-${padNumber(i)}`)) {
                day.classList.add('event-day');
            }

            daysContainer.appendChild(day);
        }
    }

    function getMonthName(month) {
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return months[month];
    }

    function previousMonth() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateCalendar();
    }

    function nextMonth() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendar();
    }

    function padNumber(num) {
        return num.toString().padStart(2, '0');
    }

    window.onload = generateCalendar;
</script>

</body>

<footer class="footer mt-auto py-2">
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
