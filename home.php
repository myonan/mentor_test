<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
include 'functions.php';

$DATABASE_HOST = '107.180.1.16:3306';
$DATABASE_USER = 'group82021';
$DATABASE_PASS = '2021group8';
$DATABASE_NAME = '2021group8';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT mentor_name, mentor_email FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($mentor_name, $mentor_email);
$stmt->fetch();
$stmt->close();

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

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Journal</title>

    <style>
      *{
        box-sizing: border-box;
      }
      
      .col-00 {width:      none;}
      .col-01 { width:   8.33%; }
      .col-02 { width:  16.66%; }
      .col-03 { width:  25.00%; }
      .col-04 { width:  33.33%; }
      .col-05 { width:  41.66%; }
      .col-06 { width:  50.00%; }
      .col-07 { width:  58.33%; }
      .col-08 { width:  66.66%; }
      .col-09 { width:  75.00%; }
      .col-10 { width:  83.33%; }
      .col-11 { width:  91.66%; }
      .col-12 { width: 100.00%; }

    body{
      color: rgb(121, 118, 118);
      background-color: #fff;
    }
      /* Dark theme colors */
    body.dark-theme {
      color: #eee;
      background-color: #121212;
    }

    /* Style the body */
    /* Styles for users who prefer dark mode */
    @media (prefers-color-scheme: dark) {
      /* defaults to dark theme */
        body {
        background-color: #121212;
        font-family: Arial, Helvetica, sans-serif;
        color: #eee;
        margin: 0;
        }
        /* Override dark mode with light mode styles if the user decides to swap */
        body.light-theme {
          color: rgb(121, 118, 118);
          background-color: #fff;
        }
    }

    .content{
      text-align: center;
    }

    .head{
      text-align: center;
      font-size: 20px;
    }

    .menu{
      display: inline;
      text-align: center;
    
    }

    .quote {
      text-align: center;
      font-family: "Lucida Console", "Courier New", monospace;
    }

    .foot {
      padding: 20px;
      text-align: center;
    }

      [class*="col-"] {
        float:              left;
        border-radius:      10px;
        padding:            2%;
      }

      .row::after {
        content:            "";
        clear:              both;
        display:            block;
      }

      body{
        font-family: "Lucida Console", "Courier New", monospace;
        font-size: 12px;
      }

      .lim {background-color: #00ff00;}
      .yel {background-color: #ffff00;}
      .cya {background-color: #00ffff;}
      .mag {background-color: #152028;}

      </style>
  
  </head>
  <body>
      <div class="row">
      <nav class="navtop">
			  <div class="head col-12 mag"><h1>My Portal</h1></div>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
        <div class="content">
          <h2>Home Page</h2>
          <p>Welcome back, <?=$_SESSION['name']?>!</p>
        </div>

    <button class="btn-toggle">Toggle Dark-Mode</button>

    <div class="row">
      <div class="menu col-02 mag">
        <div style="height:60px;"><a href="read.php"><i class="fas fa-user-circle"></i>Journal</a></div><br>
        <div style="height:60px;">Goals</div><br>
        <a href="mailto:<?=$mentor_email?>"><div style="height:60px;">Email</div></a><br>
	      <a href="calendar.php"><div style="height:60px;">Calendar</div></a>
      </div>

      <div class="main col-10 mag">
      <?php foreach ($entries as $entry): ?>
            <tr>
                <td><?=$entry['subj']?></td>
                <td><?=$entry['body']?></td>
                <td><?=$entry['created']?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    <div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_entries): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
      </div>

      <div class="quote col-10 mag">
        <h1>INSPIRATIONAL </h1>
        <h3>"DON'T GIVE UP"</h3>
      </div>
    </div>
      
    <div class="row">
      <div class="col-02">&nbsp;</div>
      <div class="contact col-10 mag">
          <h2>MENTOR INFORMATION</h2>
          <h5><?=$mentor_name?></h5>
          <p><?=$mentor_email?></p>
      </div>
    </div>

    <div class="row">
      <div class="foot col-12 mag">
        <h2>Footer</h2>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>
