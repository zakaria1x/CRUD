<?php
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];
    $sql = "SELECT * FROM CLIENT WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $record = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE CLIENT SET name = :name, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'email' => $email, 'id' => $id]);

    header('Location: ../index.php');
}
?>

<form method="POST">
    <input type="hidden" name="id" value="<?= $record['id'] ?>">
    <input type="text" name="name" value="<?= $record['name'] ?>" required>
    <input type="email" name="email" value="<?= $record['email'] ?>" required>
    <button type="submit">Update</button>
</form>
