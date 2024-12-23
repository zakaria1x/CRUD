<?php
require_once '../model/Client.php';
require_once '../config/db.php';

$db = new Database();
$client = new Client($db->getConnection());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client->setEmail($_POST['email']);
    session_start();

    $status = $client->login($client->getEmail(), $_POST['password']);
    if ($status) {
        $_SESSION['client_id'] = $status;
        $_SESSION['email'] = $client->getEmail();
        $_SESSION['logged_in'] = true;
        header('Location: Reservation.php?client_id=' . $status);
    } else {
        die('Login failed');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<div class="container">
    <h2>Login</h2>
        <form method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <from>
    </form>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
