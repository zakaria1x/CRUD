<?php

require_once '../model/Client.php';
require_once '../model/Concerne.php';
require_once '../model/Chambres.php';
require_once '../model/Reservation.php';
require_once '../config/db.php';

$db = new Database();

$connection = $db->getConnection();

$isAuthenticated = Client::isLogged();

if (!$isAuthenticated) {
    header('Location: login.php');
}


if ($db) {
    $concerne = new Concerne($connection);
    $chambre = new Chambres($connection);
    $reservation = new Reservation($connection);
    $client = new Client($connection);
    $chambresAndReservation = $concerne->joinChambresAndReservations();
} else {
    echo 'Database connection failed';
}

// Group reservations by reservation ID
$reservationsById = [];
foreach ($chambresAndReservation as $chambreAndReservation) {
    $reservationId = $chambreAndReservation['ID_RESERVATION'];
    if (!isset($reservationsById[$reservationId])) {
        $reservationsById[$reservationId] = [
            'DATE_DEBUT' => $chambreAndReservation['DATE_DEBUT'],
            'DATE_FIN' => $chambreAndReservation['DATE_FIN'],
            'STATUT' => $chambreAndReservation['STATUT'],
            'ID_CLIENT' => $chambreAndReservation['ID_CLIENT'],
            'NOM' => $client->getClientById($chambreAndReservation['ID_CLIENT'])['NOM'],
            'CHAMBRES' => []
        ];
    }
    $reservationsById[$reservationId]['CHAMBRES'][] = $chambreAndReservation;
}

?>


<table border="1">
    <?php if ($reservationsById) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Date de début</th>
                    <th scope="col">Date de fin</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Client</th>
                    <th scope="col">
                        Chambres
                    </th>
                    <th scope="col">Total Chambres</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservationsById as $reservationId => $reservation) : ?>
                    <tr>
                        <td><?php echo $reservation['DATE_DEBUT']; ?></td>
                        <td><?php echo $reservation['DATE_FIN']; ?></td>
                        <td><?php echo $reservation['STATUT']; ?></td>
                        <td><?php echo $reservation['NOM']; ?></td>
                        <td>
                            <?php foreach ($reservation['CHAMBRES'] as $chambre) : ?>
                                Type: <?php echo $chambre['TYPE']; ?>, 
                                Tarif: <?php echo $chambre['TARIF']; ?>, 
                                Etat: <?php echo $chambre['ETAT']; ?><br>
                            <?php endforeach; ?>
                        </td>
                        <td><?php echo count($reservation['CHAMBRES']); ?></td>
                        <td>
                            <a href="approuver.php?id=<?php echo $reservationId; ?>">Approuver</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>You have no reservations</p>
    <?php endif; ?>
</table>