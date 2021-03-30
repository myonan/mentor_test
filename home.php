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
<?=home_header('Home')?>
    <link href="style.css" rel="stylesheet" type="text/css" />
  
  <!-- </head>
  <body>
      <div class="header">
      <nav class="navtop">
			<div>
				<h1>Mentor Journal</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav> -->
		<div class="content">
			<!-- <h2>Home Page</h2> -->
			<p>Welcome back, <?=$_SESSION['name']?>!</p>
    </div>

    <div class="row">
      <div class="side">
        <div style="height:60px;"><a href="read.php"><i class="fas fa-address-book"></i> Journal</a></div><br>
        <!-- <div style="height:60px;">Goals</div><br> -->
        <div style="height:60px;"><a href="mailto:<?=$mentor_email?>"><i class="fas fa-envelope"></i> Email</a></div><br>
	      <div style="height:60px;"><a href="Calendar.php"><i class="fas fa-calendar"></i> Calendar</a></div><br>
      </div>

      <div class="main">
        <h2>RECENT JOURNAL ENTRIES</h2>
        <table>
        <thead>
            <tr>
                <!-- <td>#</td> -->
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($entries as $entry): ?>
            <tr>
                <td><?=$entry['subj']?></td>
                <td><?=$entry['body']?></td>
                <td><?=$entry['created']?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_entries): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
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

    <?=home_footer('Home')?>
