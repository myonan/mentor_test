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
    $subj = isset($_POST['subj']) ? $_POST['subj'] : '';
    $body = isset($_POST['body']) ? $_POST['body'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    // Insert new record into the entries table
    $stmt = $pdo->prepare('INSERT INTO entries VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$unique_id, $id, $subj, $body, $created]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=entry_header('Create')?>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
<div class="content update">
	<h2>Create Entry</h2>
    <form action="create.php" method="post">
        <!-- <input type="text" name="id" placeholder="26" value="auto" id="id"> -->
        <label for="subj">Subject</label>
        <input type="text" name="subj" placeholder="What did I do today?" id="subj">
        <label for="body">Body</label>
        <input type="text" name="body" placeholder="I ate an apple!" id="body">
        <label for="created">Date Created</label>
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=entry_footer()?>