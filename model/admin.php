<?php

class Admin
{

    protected $table = 'CLIENT';

    protected $nom;
    protected $prenom;
    protected $adresse;
    protected $telephone;
    protected $email;
    protected $hashed_password;
    protected $is_admin;
    protected $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setHashedPassword($hashed_password)
    {
        $this->hashed_password = $hashed_password;
    }

    public function getHashedPassword()
    {
        return $this->hashed_password;
    }


    public function setIs_admin($is_admin)
    {
        $this->is_admin = $is_admin;
    }

    public function getIs_admin()
    {
        return $this->is_admin;
    }


    public function save()
    {
        $query = "INSERT INTO " . $this->table . " (nom, prenom, telephone, email, hashed_password, is_admin) VALUES (:nom, :prenom, :telephone, :email, :hashed_password, :is_admin)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':hashed_password', $this->hashed_password);
        $stmt->bindParam(':is_admin', $this->is_admin);
        return $stmt->execute();
    }

    
    public function __destruct()
    {
        $this->conn = null;
    }
}
