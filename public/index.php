<?php

require_once '../model/Client.php';
require_once '../model/Reservation.php';
require_once '../config/db.php';

$db = new Database();
$connection = $db->getConnection();


$isAuthenticated = Client::isLogged();
if (!$isAuthenticated) {
    header('Location: infoPersonnelles.php');
} else {
    $reservation = new Reservation($connection);
    $reservations = $reservation->getReservationsByClientId($_SESSION['ID_CLIENT']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Welcome</title>
</head>

<body>

    <?php
    if ($_SESSION['is_admin'] === "T") {
        include 'admin_view.php';
    } else {
        include 'client_view.php';
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>