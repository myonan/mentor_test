<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
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
$stmt = $con->prepare('SELECT password, email, mentor_name, mentor_email FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $mentor_name, $mentor_email);
$stmt->fetch();
$stmt->close();
?>

<?=template_header('Home')?>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username: </td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						
						<td>Password: </td>
						<td><?=$password?></td>
					</tr>
					<tr>
						<td>Email: </td>
						<td><?=$email?></td>
					</tr>
				</table>
				<p>Your mentor details are below:</p>
				<table>
					<tr>
						<td>Name: </td>
						<td><?=$mentor_name?></td>
					</tr>
					<tr>
						<td>Email: </td>
						<td><?=$mentor_email?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
<?=template_footer('')?>

<!-- hello  -->