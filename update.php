<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the entry id exists, for example update.php?id=1 will get the entry with the id of 1
if (isset($_GET['unique_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $unique_id = isset($_POST['unique_id']) ? $_POST['unique_id'] : NULL;
        $body = isset($_POST['body']) ? $_POST['body'] : '';
        $subj = isset($_POST['subj']) ? $_POST['subj'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE entries SET subj = ?, body = ?, created = ? WHERE unique_id = ?');
        $stmt->execute([$subj, $body, $created, $_GET['unique_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the entry from the entrys table
    $stmt = $pdo->prepare('SELECT * FROM entries WHERE unique_id = ?');
    $stmt->execute([$_GET['unique_id']]);
    $entry = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$entry) {
        exit('entry doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=entry_header('Read')?>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
<div class="content update">
	<h2>Update Entry</h2>
    <form action="update.php?unique_id=<?=$entry['unique_id']?>" method="post">
        <!-- <label for="id">ID</label> -->
        <label for="name">Subject</label>
        <!-- <input type="text" name="id" placeholder="1" value="<?=$entry['id']?>" id="id"> -->
        <input type="text" name="subj" placeholder="What did I do that day?" value="<?=$entry['subj']?>" id="subj">
        <label for="Body">Body</label>
        <input type="text" name="body" placeholder="Describe what I did." value="<?=$entry['body']?>" id="body">
        <label for="created">Updated Date</label>
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=entry_footer()?>