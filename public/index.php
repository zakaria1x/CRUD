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

    <h1>Welcome to our Riad</h1>
    <h2 class="mt-5">Your reservations</h2>
    <?php if ($reservations) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Date de début</th>
                    <th scope="col">Date de fin</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Chambre</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation) : ?>
                    <tr>
                        <th scope="row"><?php echo $reservation['ID_RESERVATION']; ?></th>
                        <td><?php echo $reservation['DATE_DEBUT']; ?></td>
                        <td><?php echo $reservation['DATE_FIN']; ?></td>
                        <td><?php echo $reservation['STATUT']; ?></td>
                        <td>
                            <a href="chambre.php?id=<?php echo $reservation['ID_RESERVATION']; ?>">
                                Choisir une chambre
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>You have no reservations</p>
    <?php endif; ?>
    <p>
        <a href="infoPersonnelles.php" class="btn btn-primary">Réserver une chambre</a>
    </p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>