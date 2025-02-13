<?php

class Demande {
    private $conn;
    private $table_name = "packages";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function countDemandes() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}