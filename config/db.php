<?php
class Connection
{
    private $servername = "127.0.0.1";
    private $username = "user";
    private $password = "userpassword";
    private $dbname = "mydatabase";
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }


    public function select($sql)
    {
        $result = $this->conn->query($sql);
        $records = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }
        return $records;
    }


    public function insert($sql)
    {
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }


    public function update($sql)
    {
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }


    public function delete($sql)
    {
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }


    public function execute($sql)
    {
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function close()
    {
        $this->conn->close();
    }

}