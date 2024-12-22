<?php

require_once '../model/Client.php';
require_once '../model/Reservation.php';
require_once '../config/db.php';

$db = new Database();
$connection = $db->getConnection();

if ($db) {
    $reservation = new Reservation($connection);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $reservation->setChambreId($_POST['chambre_id']);

        $lastInsertedId = $client->save();
        if ($lastInsertedId) {
            header('Location: index.php?client_id=' . $lastInsertedId);
        } else {
            header('Location: index.php?error=something went wrong');
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
        <div class="mb-3">
            <label for="date_debut" class="form-label
            ">Date de début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut">
        </div>
        <div class="mb-3">
            <label for="date_fin" class="form-label">Date de fin</label>
            <input type="date" class="form-control" id="date_fin" name="date_fin">
        </div>

        <div class="mb-3">
            <label for="chambre_id" class="form-label
            ">Chambre</label>
            <select class="form-select" id="chambre_id" name="chambre_id">
                <option selected>Choisir une chambre</option>
                <option value="1">Chambre simple</option>
                <option value="2">Chambre double</option>
                <option value="3">Chambre triple</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Réserver</button>
    </form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
