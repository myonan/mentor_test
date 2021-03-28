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
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Mentor Journal</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
  
  </head>
  <body>
      <div class="header">
      <nav class="navtop">
			<div>
				<h1>Mentor Journal</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>
    </div>

    <div class="row">
      <div class="side">
        <div style="height:60px;"><a href="read.php"><i class="fas fa-user-circle"></i>Journal</a></div><br>
        <div style="height:60px;">Goals</div><br>
        <a href="mailto:<?=$mentor_email?>"><div style="height:60px;">Email</div></a><br>
	      <a href="calendar.php"><div style="height:60px;">Calendar</div></a>
      </div>

      <div class="main">
        <h2>RECENT JOURNAL ENTRIES</h2>
        <h5>March 12, 2021</h5>
        
        <p>Some text..</p>
        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>

        <br>
      <div class="quote">
        <h1>INSPIRATIONAL </h1>
        <h3>"DON'T GIVE UP"</h3>
      </div>
      
        <br>
      
        <h2>MENTOR INFORMATION</h2>
        <h5><?=$mentor_name?></h5>
        <p><?=$mentor_email?></p>
      </div>
    </div>

    <div class="footer">
      <h2>Footer</h2>
    </div>
  </body>
</html>
