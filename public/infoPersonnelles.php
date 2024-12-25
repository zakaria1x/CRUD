<?php

require_once '../model/Client.php';
require_once '../model/Reservation.php';
require_once '../config/db.php';

$db = new Database();

if(Client::isLogged()){
    header('Location: Reservation.php');
}

if ($db) {
    $client = new Client($db->getConnection());

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $client->setNom($_POST['nom']);
        $client->setPrenom($_POST['prenom']);
        $client->setAdresse($_POST['adresse']);
        $client->setTelephone($_POST['telephone']);
        $client->setEmail($_POST['email']);
        $client->setPassportId($_POST['passport_id']);
        $client->setCinId($_POST['cin_id']);
        $client->setHashedPassword($_POST['password']);

        $hash = password_hash($client->getHashedPassword(), PASSWORD_DEFAULT);
        $client->setHashedPassword($hash);

        $client->save();
        if ($id) {
            header('Location: login.php');
        } else {
            header('Location: login.php?error=something went wrong');
        }
    }
} else {
    die('Database connection failed');
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
        <h2>Réserver une chambre</h2>
        <h3>Informations personnelles</h3>
        <form method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom">
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom">
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse">
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" default="email@test.com">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="passport_id" class="form-label
            ">Numéro de passeport</label>
                <input type="text" class="form-control" id="passport_id" name="passport_id">
            </div>
            <div class="mb-3">
                <label for="cin_id" class="form-label">Numéro de CIN</label>
                <input type="text" class="form-control" id="cin_id" name="cin_id">
            </div>
            <button type="submit" class="btn btn-primary">passer à la réservation</button>
        </form>
        <p>Vous avez déjà un compte? <a href="login.php">Connectez-vous</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>