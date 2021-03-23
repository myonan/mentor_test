<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
include 'functions.php';
// Connect to MySQL database
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

<?=template_header('Read')?>

<div class="content read">
	<h2>Read Entries</h2>
	<a href="create.php" class="create-entry">Create Entry</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Subject</td>
                <td>Body</td>
                <td>Created</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($entries as $entry): ?>
            <tr>
                <td><?=$entry['id']?></td>
                <td><?=$entry['subj']?></td>
                <td><?=$entry['body']?></td>
                <td><?=$entry['created']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$entry['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$entry['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
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
</div>

<?=template_footer()?>