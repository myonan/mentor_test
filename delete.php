<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['unique_id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM entries WHERE unique_id = ?');
    $stmt->execute([$_GET['unique_id']]);
    $entry = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$entry) {
        exit('Entry doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM entries WHERE unique_id = ?');
            $stmt->execute([$_GET['unique_id']]);
            $msg = 'You have deleted the entry!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
<div class="content delete">
	<h2>Delete Entry <?=$entry['subj']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete entry "<?=$entry['subj']?>"?</p>
    <div class="yesno">
        <a href="delete.php?unique_id=<?=$entry['unique_id']?>&confirm=yes">Yes</a>
        <a href="delete.php?unique_id=<?=$entry['unique_id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>