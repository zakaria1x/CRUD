<?php


class Client {

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function select()
    {
        $sql = "SELECT * FROM CLIENT";
        $result = $this->conn->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }
        return $records;
    }

    public function insert($name, $email)
    {
        $sql = "INSERT INTO CLIENT (name, email) VALUES ('$name', '$email')";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $name, $email)
    {
        $sql = "UPDATE CLIENT SET name = '$name', email = '$email' WHERE id = $id";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM CLIENT WHERE id = $id";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

}