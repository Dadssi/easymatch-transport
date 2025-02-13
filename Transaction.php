<?php
include_once 'dbgraph.php';

class Transaction {
    private $conn;
    private $table_name = 'packages';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function countTransactions() {
        $query = "SELECT COUNT(*) AS total_transactions FROM {$this->table_name} WHERE status = 'delivered'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_transactions'];
    }
}
?>
