<?php
class Database
{
    private $host = "127.0.0.1";
    private $port = "1521";
    private $sid = "FREE";
    private $username = 'SYSTEM';
    private $password = 'mypassword123';
    private $schemaName = 'C##raid'; // Updated schema name

    private $conn;

    public function __construct()
    {
        $this->conn = null;
        $dsn = "oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$this->host)(PORT=$this->port))(CONNECT_DATA=(SID=$this->sid)))";

        // check pdo_oci extension
        if (!extension_loaded('pdo_oci')) {
            die('pdo_oci extension is not loaded');
        }

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            // create a database and select it
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            $this->conn->exec("ALTER SESSION SET CURRENT_SCHEMA = $this->schemaName");

            $sqlFile = file_get_contents(__DIR__ . '/database.sql');
            $sqlStatements = explode(';', $sqlFile);

            foreach ($sqlStatements as $statement) {
                if (trim($statement) !== '') {
                    $this->conn->exec($statement);
                }
            }
            echo 'Connection established successfully <br>';
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function createSchema()
    {
        try {
            $this->conn->exec("CREATE USER $this->schemaName IDENTIFIED BY password");
            $this->conn->exec("GRANT ALL PRIVILEGES TO $this->schemaName");
            echo 'Schema created successfully <br>';
        } catch (PDOException $e) {
            die("Schema creation failed: " . $e->getMessage());
        }
    }

    public function down()
    {
        $sqlFile = file_get_contents(__DIR__ . '/drop.sql');
        $sqlStatements = explode('/', $sqlFile);

        foreach ($sqlStatements as $statement) {
            if (trim($statement) !== '') {
                $this->conn->exec($statement);
            }
        }
        echo 'Database dropped successfully <br>';
    }

    public function listTables()
    {
        $stmt = $this->conn->query("SELECT table_name FROM user_tables");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $tables;
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}
