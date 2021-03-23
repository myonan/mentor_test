<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the entry id exists, for example update.php?id=1 will get the entry with the id of 1
if (isset($_GET['unique_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $unique_id = isset($_POST['unique_id']) ? $_POST['unique_id'] : NULL;
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $subj = isset($_POST['subj']) ? $_POST['subj'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE entries SET uniques_id = ? id = ?, subj = ?, body = ?, created = ? WHERE unique_id = ?');
        $stmt->execute([$id, $subj, $body, $created, $_GET['unique_id']]);
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