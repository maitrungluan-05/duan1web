<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = '';
    private $dbname = 'dame';
    private $conn;
    private $stmt;

    function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function query($sql, $param = []) {
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute($param);
        return $this->stmt;
    }

    function getAll($sql, $param = []) {
        $statement = $this->query($sql, $param);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function getOne($sql, $param = []) {
        $statement = $this->query($sql, $param);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    function insert($sql, $param) {
        $this->query($sql, $param);
        return $this->conn->lastInsertId();
    }

    function delete($sql,$param){
        $this->query($sql,$param);
    }

    function update($sql,$param) {
        $this->query($sql,$param);
    }
    
    function __destruct(){
        unset($this->conn);
    }
}
?>
