<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = '107.180.1.16:3306';
    $DATABASE_USER = 'group82021';
    $DATABASE_PASS = '2021group8';
    $DATABASE_NAME = '2021group8';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
    
}

date_default_timezone_set('MST');

function calendar_header($title) {
    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <link href="entries.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>
        <body>
        <nav class="navtop">
            <div>
                <h1>Mentor Journal</h1>
                <a href="home.php"><i class="fas fa-home"></i>Home</a>
                <a href="event.php"><i class="fas fa-calendar-plus"></i> Add Event</a></div><br>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </nav>
    EOT;
    }
    function calendar_footer() {
    echo <<<EOT
        </body>
    </html>
    EOT;
    }

function event_header($title) {
        echo <<<EOT
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <title>$title</title>
                <link href="entries.css" rel="stylesheet" type="text/css">
                <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
            </head>
            <body>
            <nav class="navtop">
                <div>
                    <h1>Mentor Journal</h1>
                    <a href="home.php"><i class="fas fa-home"></i>Home</a>
                    <a href="calendar.php"><i class="fas fa-calendar"></i>Calendar</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                </div>
            </nav>
        EOT;
        }
function event_footer() {
    echo <<<EOT
        </body>
    </html>
    EOT;
    }
    

function entry_header($title) {
    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <link href="entries.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>
        <body>
        <nav class="navtop">
            <div>
                <h1>Mentor Journal</h1>
                <a href="home.php"><i class="fas fa-home"></i>Home</a>
                <a href="read.php"><i class="fas fa-address-book"></i>Entry Log</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </nav>
    EOT;
    }
    function entry_footer() {
    echo <<<EOT
        </body>
    </html>
    EOT;
    }

function template_header($title) {
    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <link href="entries.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>
        <body>
        <nav class="navtop">
            <div>
                <h1>Mentor Journal</h1>
                <a href="home.php"><i class="fas fa-home"></i>Home</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </nav>
    EOT;
    }
    function template_footer() {
    echo <<<EOT
        </body>
    </html>
    EOT;
    }
    
    function home_header($title) {
        echo <<<EOT
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <title>$title</title>
                <link href="entries.css" rel="stylesheet" type="text/css">
                <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
            </head>
            <body>
            <nav class="navtop">
                <div>
                    <h1>Mentor Journal</h1>
                    <a class="btn-toggle" href="#"><i class="fas fa-lightbulb"></i></a>
                    <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                </div>
            </nav>
        EOT;
        }
        function home_footer() {
        echo <<<EOT
            </body>
        </html>
        EOT;
        }
    
    function home_read() {
        $pdo = pdo_connect_mysql();
        // Get the page via GET request (URL param: page), if non exists default the page to 1
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        // Number of records to show on each page
        $records_per_page = 5;
        $user_id = $_SESSION['id'];

        $stmt = $pdo->prepare("SELECT * FROM entries WHERE id=?");
        $stmt->execute([$user_id]);
        // Fetch the records so we can display them in our template.
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $num_entries = $pdo->query('SELECT COUNT(*) FROM entries')->fetchColumn();
    }
    ?>