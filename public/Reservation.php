<?php

require_once '../config/db.php';
require_once '../model/Client.php';
require_once '../model/Reservation.php';

$db = new Database();

$connection = $db->getConnection();
$isAuthenticated = Client::isLogged();
if (!$isAuthenticated) {
    header('Location: login.php');
}

if ($db) {
    $reservation = new Reservation($connection);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $reservation->setClientId($_SESSION['ID_CLIENT']);
        $reservation->setDateDebut($_POST['date_debut']);
        $reservation->setDateFin($_POST['date_fin']);
        $reservation->setStatut('en attente');
        if ($reservation->save()) {
            header('Location: index.php');
        } else {
            die('Erreur lors de la réservation');
        }

    }
} else {
    echo 'Database connection failed';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver une chambre</title>
</head>
<body>


<div class="container">
    <h1>Réserver une chambre</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="date_debut" class="form-label
            ">Date de début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut">
        </div>
        <div class="mb-3">
            <label for="date_fin" class="form-label">Date de fin</label>
            <input type="date" class="form-control" id="date_fin" name="date_fin">
        </div>
        <button type="submit" class="btn btn-primary">Réserver</button>
    </form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
