<?php

require_once '../model/Client.php';
require_once '../model/Reservation.php';
require_once '../config/db.php';

$db = new Database();

$connection = $db->getConnection();

$isAuthenticated = Client::isLogged();

if (!$isAuthenticated) {
    header('Location: login.php');
}


if ($db) {
    $reservation = new Reservation($connection);
    $reservations = $reservation->approuverReservation($_GET['id']);
    header('Location: index.php');
} else {
    echo 'Database connection failed';
}
