<?php
include './config/database.php';

$sql = "SELECT * FROM CLIENT";
$stmt = $pdo->query($sql);
$records = $stmt->fetchAll();
?>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($records as $record): ?>
        <tr>
            <td><?= $record['id'] ?></td>
            <td><?= $record['name'] ?></td>
            <td><?= $record['email'] ?></td>
            <td>
                <a href="views/update.php?id=<?= $record['id'] ?>">Edit</a>
                <a href="views/delete.php?id=<?= $record['id'] ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>




