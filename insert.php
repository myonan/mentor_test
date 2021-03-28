<?php
/* Database credentials. Assuming you are running MySQL
server with default setting */
define('DB_SERVER', '107.180.1.16:3306');
define('DB_USERNAME', 'group82021');
define('DB_PASSWORD', '2021group8');
define('DB_NAME', '2021group8');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Escape user inputs for security
$first_name = mysqli_real_escape_string($link, $_REQUEST['username']);
$last_name = mysqli_real_escape_string($link, $_REQUEST['password']);
$email = mysqli_real_escape_string($link, $_REQUEST['email']);
// Mentor info
$mentor_name = mysqli_real_escape_string($link, $_REQUEST['mentorname']);
$mentor_email = mysqli_real_escape_string($link, $_REQUEST['mentoremail']);
 
// Attempt insert query execution
$sql = "INSERT INTO accounts (username, password, email, mentor_name, mentor_email) VALUES ('$first_name', '$last_name', '$email', '$mentor_name', '$mentor_email')";
if(mysqli_query($link, $sql)){
    header("location: index.php");
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>