<?php

class Client
{

    protected $table = 'CLIENT';

    private $nom;
    private $prenom;
    private $adresse;
    private $telephone;
    private $email;
    private $hashed_password;
    private $passport_id;
    private $cin_id;
    private $conn;

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

    public function setPassportId($passport_id)
    {
        $this->passport_id = $passport_id;
    }

    public function getPassportId()
    {
        return $this->passport_id;
    }

    public function setCinId($cin_id)
    {
        $this->cin_id = $cin_id;
    }

    public function getCinId()
    {
        return $this->cin_id;
    }

    public function isEmailExists($email)
    {
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }

    public function isTelephoneExists($email)
    {
        $sql = "SELECT * FROM $this->table WHERE telephone = :telephone";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }

    public function isPassportIdExists($passport_id)
    {
        $sql = "SELECT * FROM $this->table WHERE passport_id = :passport_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':passport_id', $passport_id);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }

    public function isCinIdExists($cin_id)
    {
        $sql = "SELECT * FROM $this->table WHERE cin_id = :cin_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cin_id', $cin_id);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }

    public function save()
    {
        try {
            $sql = "INSERT INTO $this->table (nom, prenom, adresse, telephone, email, hashed_password, passport_id, cin_id) VALUES (:nom, :prenom, :adresse, :telephone, :email, :hashed_password, :passport_id, :cin_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':adresse', $this->adresse);
            $stmt->bindParam(':telephone', $this->telephone);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':hashed_password', $this->hashed_password);
            $stmt->bindParam(':passport_id', $this->passport_id);
            $stmt->bindParam(':cin_id', $this->cin_id);
            if ($stmt->execute()) {
                return $this->isEmailExists($this->email)['ID_CLIENT'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch();
        

        if ($data) {
            if (password_verify($password, $data['HASHED_PASSWORD'])) {
                return $data['ID_CLIENT'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function isLogged()
    {
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            return true;
        } else {
            return false;
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}
