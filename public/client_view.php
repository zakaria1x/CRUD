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