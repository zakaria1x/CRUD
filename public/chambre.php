<?php

require_once '../model/Client.php';
require_once '../model/Chambres.php';
require_once '../config/db.php';
require_once '../model/Concerne.php';

$db = new Database();
$connection = $db->getConnection();

$isAuthenticated = Client::isLogged();

if (!$isAuthenticated) {
    header('Location: login.php');
}


if ($db) {
    $chambre = new Chambres($connection);
    $concerne = new Concerne($connection);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $chambre->setType($_POST['type']);
        $chambre->setTarif($_POST['tarif']);
        $chambre->setEtat('disponible');
        $chamberId = $chambre->save();
        if ($chamberId) {
            $concerne->setIdReservation($_GET['id']);
            $concerne->setIdChambre($chamberId);
            if ($concerne->save()) {
                header('Location: index.php');
            } else {
                die('Erreur lors de la réservation');
            }
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver une chambre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container mt-5">
        <h1>Réserver une chambre</h1>
        <form method="POST">
            <div class="mb-3">
                <select name="type" id="type" class="form-select">
                    <option value="simple">Simple</option>
                    <option value="double">Double</option>
                    <option value="suite">Suite</option>
                </select>
            </div>
            <div class="mb-3">
                <select name="tarif" id="tarif" class="form-select">
                    <option value="100">199</option>
                    <option value="200">500</option>
                    <option value="300">2000</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Réserver</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>