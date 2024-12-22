<?php


class Reservation
{

    protected $table = 'reservations';

    private $client_id;
    private $chambre_id;
    private $date_debut;
    private $date_fin;
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function setChambreId($chambre_id)
    {
        $this->chambre_id = $chambre_id;
    }

    public function getChambreId()
    {
        return $this->chambre_id;
    }

    public function setDateDebut($date_debut)
    {
        $this->date_debut = $date_debut;
    }

    public function getDateDebut()
    {
        return $this->date_debut;
    }

    public function setDateFin($date_fin)
    {
        $this->date_fin = $date_fin;
    }

    public function getDateFin()
    {
        return $this->date_fin;
    }

    public function save()
    {
        $sql = "INSERT INTO $this->table (client_id, chambre_id, date_debut, date_fin) VALUES (:client_id, :chambre_id, :date_debut, :date_fin)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':client_id', $this->client_id);
        $stmt->bindParam(':chambre_id', $this->chambre_id);
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin', $this->date_fin);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function update($id)
    {
        $sql = "UPDATE $this->table SET client_id = :client_id, chambre_id = :chambre_id, date_debut = :date_debut, date_fin = :date_fin WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':client_id', $this->client_id);
        $stmt->bindParam(':chambre_id', $this->chambre_id);
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin', $this->date_fin);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }



}
