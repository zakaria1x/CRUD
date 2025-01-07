<?php

class Chambres
{
    protected $table = 'CHAMBRE';

    private $type;
    private $tarif;
    private $etat = 'disponible';
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    private function generateUuidV4()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0x0fff) | 0x4000, random_int(0, 0x3fff) | 0x8000, random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff));
    }


    public function setType($type)
    {
        $this->type = $type;
    }


    public function setTarif($tarif)
    {
        $this->tarif = $tarif;
    }


    public function setEtat($etat)
    {
        $this->etat = $etat;
    }



    public function getType()
    {
        return $this->type;
    }

    public function getTarif()
    {
        return $this->tarif;
    }

    public function getEtat()
    {
        return $this->etat;
    }


    public function getLastInsertedIdByUserId($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id_client = :id ORDER BY id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function save()
    {
        $query = "INSERT INTO " . $this->table . " (id_chambre, type, tarif, etat) VALUES (:id_chambre, :type, :tarif, :etat)";
        $id_chambre = $this->generateUuidV4();
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_chambre', $id_chambre);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':tarif', $this->tarif);
        $stmt->bindParam(':etat', $this->etat);
        if ($stmt->execute()) {
            return $id_chambre;
        } else {
            return false;
        }
    }

    public function getChambres()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
