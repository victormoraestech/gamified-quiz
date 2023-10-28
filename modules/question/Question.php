<?php 

class Question {
    private $pdo;
    private $table = "Question";
    public function __construct(){
        $this->pdo = new Mysql();
    }
    public function create($sql){
        $this->pdo->insert($this->table, $sql);
    }
    public function select($sql){
        return $this->pdo->select($this->table, $sql);
    }
    public function selectById($sql, $condition){
        return $this->pdo->selectById($this->table, $sql, $condition);
    }
    public function update($sql, $conditions){
        $this->pdo->update($this->table, $sql, $conditions);
    }
    public function delete($conditions){
        $this->pdo->delete($this->table, $conditions);
    }
    public function getTable(){
        return $this->table;
    }
    public function getPdo(){
        return $this->pdo;
    }
}?>