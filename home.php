<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
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
        <div style="height:60px;">Journal</div><br>
        <div style="height:60px;">Goals</div><br>
        <div style="height:60px;">Email</div>
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
        <h5>Bob Smith</h5>
        <p>EMAIL: Bob.Smith@gmail.com <br>
          PHONE: 555-555-5555
        </p>
      </div>
    </div>

    <div class="footer">
      <h2>Footer</h2>
    </div>
  </body>
</html>