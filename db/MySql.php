<?php

class Mysql
{

    private const MYSQL_HOST = "localhost";
    private const MYSQL_USER = "root";
    private const MYSQL_PASS = "";
    private const MYSQL_DB = "quiz";

    
    private $conn;


    public function __construct()
    {
        try {
            $this->conn =
                new PDO(
                    "mysql:host=" .
                        MYSQL::MYSQL_HOST . ";dbname=" . MYSQL::MYSQL_DB,
                        MYSQL::MYSQL_USER,
                        MYSQL::MYSQL_PASS
                );
        } catch (Error $err) {
            echo $err->getMessage();
        }
    }



    public function insert($table, $data) {
        $fields = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $query = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    public function select($table, $data, $conditions = null) {
        $query = "SELECT {$data} FROM {$table}";
    
        if ($conditions !== null && !empty($conditions)) {
            $query .= " WHERE " . key($conditions) . " = :" . key($conditions);
        }
    
        $stmt = $this->conn->prepare($query);
    
        if ($conditions !== null && !empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }
    
        $stmt->execute();
        // $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // return $resultado;
    }
    public function selectById($table, $data, $conditions){
        $sql = "select {$data} from {$table} where {$conditions}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $position = strpos($conditions, " ");
        $textField = substr($conditions, 0, $position);
        $arrayAssoc = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $value = $arrayAssoc[0][$textField];
        return $value;
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $conditions) {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= "{$key} = :{$key}, ";
        }
        $set = rtrim($set, ", ");

        $query = "UPDATE {$table} SET {$set} WHERE " . key($conditions) . " = :" . key($conditions);
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    public function delete($table, $conditions) {
        $query = "DELETE FROM {$table} WHERE " . key($conditions) . " = :" . key($conditions);
        $stmt = $this->conn->prepare($query);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }
    public function getConn(){
        return $this->conn;
    }
}
