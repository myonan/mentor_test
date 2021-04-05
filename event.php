<?php
session_start();
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $unique_id = isset($_POST['unique_id']) && !empty($_POST['unique_id']) && $_POST['unique_id'] != 'auto' ? $_POST['unique_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $id = $_SESSION['id'];
    $description= isset($_POST['description']) ? $_POST['description'] : '';
    $startdt = isset($_POST['startdt']) ? $_POST['startdt'] : '';
    $enddt = isset($_POST['enddt']) ? $_POST['enddt'] : date('Y-m-d H:i:s');
    // Insert new record into the entries table
    $stmt = $pdo->prepare('INSERT INTO calendar VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$unique_id, $id, $description, $startdt, $enddt]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=event_header('Create')?>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
<div class="content update">
	<h2>Create Event</h2>
    <form action="event.php" method="post">
        <!-- <input type="text" name="id" placeholder="26" value="auto" id="id"> -->
        <label for="description">Description</label>
        <input type="text" name="description" placeholder="What is going on?" id="description">
        <label for="startdt">Start Date</label>
        <input type="date" name="startdt" id="dateinput" >
        <label for="enddt">End Date</label>
        <input type="date" name="enddt" id="dateinput" >
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=entry_footer()?>