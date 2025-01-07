<?php

require_once 'admin.php';


class Client extends Admin
{
    private $passport_id;
    private $cin_id;

    public function __construct($db)
    {
        parent::__construct($db);
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
            $sql = "INSERT INTO $this->table (nom, prenom, adresse, telephone, email, hashed_password, passport_id, cin_id, is_admin) VALUES (:nom, :prenom, :adresse, :telephone, :email, :hashed_password, :passport_id, :cin_id, :is_admin)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':adresse', $this->adresse);
            $stmt->bindParam(':telephone', $this->telephone);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':hashed_password', $this->hashed_password);
            $stmt->bindParam(':passport_id', $this->passport_id);
            $stmt->bindParam(':cin_id', $this->cin_id);
            $stmt->bindParam(':is_admin', $this->is_admin);
            
            if ($stmt->execute()) {
                return $this->isEmailExists($this->email)['ID_CLIENT'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
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
                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['ID_CLIENT'] = $data['ID_CLIENT'];
                $_SESSION['is_admin'] = $data['IS_ADMIN'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public static function isLogged()
    {
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            return true;
        } else {
            return false;
        }
    }

    public static function logout()
    {
        session_start();
        session_destroy();
        header('Location: login.php');
    }

    public function getClientById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE ID_CLIENT = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }


    public function __destruct()
    {
        $this->conn = null;
    }
}
