<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$user_id = $_SESSION['id'];

// Setting the timezone
date_default_timezone_set('America/Phoenix');

// Get previous and next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // This month
    $ym = date('Y-m');
}

// Checking the format
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// Today
$today = date('Y-m-j', time());
// Year and Month
$year = date('Y', $timestamp);
$month = date('m', $timestamp);

$stmt = $pdo->query("SELECT DAY(startdt) AS day, DATE_FORMAT(startdt, '%l%p') AS startt, DATE_FORMAT(enddt, '%l%p') AS endt, description FROM calendar WHERE (YEAR(startdt) = $year) AND (MONTH(startdt) = $month) AND id=$user_id");

$events = array();
while($row = $stmt->fetch()) {
   $events[$row['day']][] = $row['description']; // might have multiple events on one day, so store as an array of events
   $events[$row['day']][] = $row['startt'];
   $events[$row['day']][] = $row['endt'];
}

// For the H3 title
$html_title = date('Y / m', $timestamp);

// Create previous and next month link      mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

// Number of days in the month
$day_count = date('t', $timestamp);

// 0: Sunday, 1: Monday, 2: Tuesday, 3: Wednesday etc.
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));


// Create Calendar
$weeks = array();
$week = '';

// Add an empty cell
$week .= str_repeat('<td></td>', $str);

for ( $day = 1; $day <= $day_count; $day++, $str++) {

    $date = $ym . '-' . $day;

    if ($today == $date) {
        $week .= '<td class="today">' . $day;
        if(isset($events[$day])) {
            $week .= '<p>' . $events[$day][0] ." ". $events[$day][1] ." - ". $events[$day][2] . '</p>';
        }
    } else {
        $week .= '<td>' . $day;
        if(isset($events[$day])) {
            $week .= '<p>' . $events[$day][0] ." ". $events[$day][1] ." - ". $events[$day][2] . '</p>';
        }
    }
    $week .= '</td>';

    // End of the week or end of the month
    if ($str % 7 == 6 || $day == $day_count) {

        if ($day == $day_count) {
            // Add an empty cell
            $week .= str_repeat('<td></td>', 6 - ($str % 7));
        }

        $weeks[] = '<tr>' . $week . '</tr>';

        // Prepare for new week
        $week = '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mentor Journal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="entries.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <nav class="navtop">
            <div style="font-family: Lucida Console, Courier New, monospace">
                <h1 style="font-family: Lucida Console, Courier New, monospace">Mentor Journal</h1>
                <a href="home.php"><i class="fas fa-home"></i>Home</a>
                <a href="event.php"><i class="fas fa-calendar-plus"></i> Add Event</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </nav>
    <style>
        .container {
            box-sizing: border-box;
            font-family: "Lucida Console", "Courier New", monospace;
            margin-top: 80px;
        }
        h3 {
            margin-bottom: 30px;
        }
        th {
            height: 30px;
            text-align: center;
        }
        td {
            height: 100px;
            width: 100px;
        }
        p {
            font-size: 12px;
            background: lightgrey;
            color: black;
        }
        .today {
            background: grey;
        }
        th:nth-of-type(1), td:nth-of-type(1) {
            color: red;
        }
        th:nth-of-type(7), td:nth-of-type(7) {
            color: blue;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
        <table class="table table-bordered">
            <tr>
                <th>S</th>
                <th>M</th>
                <th>T</th>
                <th>W</th>
                <th>T</th>
                <th>F</th>
                <th>S</th>
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>
    </div>
</body>
</html>