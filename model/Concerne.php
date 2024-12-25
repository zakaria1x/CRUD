<?php


class Concerne
{
    protected $table = 'CONCERNE';

    private $id_reservation;
    private $id_chambre;
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function setIdReservation($id_reservation)
    {
        $this->id_reservation = $id_reservation;
    }

    public function setIdChambre($id_chambre)
    {
        $this->id_chambre = $id_chambre;
    }


    public function save()
    {
        $query = "INSERT INTO " . $this->table . " (id_reservation, id_chambre) VALUES (:id_reservation, :id_chambre)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_reservation', $this->id_reservation);
        $stmt->bindParam(':id_chambre', $this->id_chambre);
        return $stmt->execute();
    }

}
?>