<?php

class Reservation
{
    protected $table = 'RESERVATION';

    private $client_id;
    private $date_debut;
    private $date_fin;
    private $statut = 'en attente';
    private $conn = null;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    public function setDateDebut($date_debut)
    {
        $this->date_debut = $date_debut;
    }

    public function setDateFin($date_fin)
    {
        $this->date_fin = $date_fin;
    }

    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    public function getDateDebut()
    {
        return $this->date_debut;
    }

    public function getDateFin()
    {
        return $this->date_fin;
    }

    public function getStatut()
    {
        return $this->statut;
    }

    public function save()
    {
        $query = "INSERT INTO " . $this->table . " (date_debut, date_fin, statut, id_client) VALUES (TO_DATE(:date_debut, 'YYYY-MM-DD'), TO_DATE(:date_fin, 'YYYY-MM-DD'), :statut, :client_id)";
        $stmt = $this->conn->prepare($query);
        $this->date_debut = date('Y-m-d', strtotime($this->date_debut));
        $this->date_fin = date('Y-m-d', strtotime($this->date_fin));
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin', $this->date_fin);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':client_id', $this->client_id);
        return $stmt->execute();
    }


    public function getReservations()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getReservationById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

}
