<?php

class PackageModel {
    private $db;
    public $id;
    public $sender_id;
    public $announcement_id;
    public $package_size;
    public $pickup_city;
    public $dropoff_city;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->db = $db;
    }

    public function initialize($id) {
        if (!$this->read($id)) {
            throw new Exception("Package not found.");
        }
    }

    public function create() {
        $sql = "INSERT INTO sender_requests (sender_id, announcement_id, package_size, pickup_city, dropoff_city, status) 
                VALUES (:sender_id, :announcement_id, :package_size, :pickup_city, :dropoff_city, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':sender_id' => $this->sender_id,
            ':announcement_id' => $this->announcement_id,
            ':package_size' => $this->package_size,
            ':pickup_city' => $this->pickup_city,
            ':dropoff_city' => $this->dropoff_city,
            ':status' => $this->status
        ]);
        
        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function read($id) {
        $sql = "SELECT request_id, sender_id, announcement_id, package_size, pickup_city, dropoff_city, status, created_at FROM sender_requests WHERE request_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $package = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($package) {
            // Map request_id to id since that's how it's defined in the class
            $this->id = $package['request_id'];
            
            // Set all other attributes
            $this->sender_id = $package['sender_id'];
            $this->announcement_id = $package['announcement_id'];
            $this->package_size = $package['package_size'];
            $this->pickup_city = $package['pickup_city'];
            $this->dropoff_city = $package['dropoff_city'];
            $this->status = $package['status'];
            $this->created_at = $package['created_at'];
    
            return $package;
        } else {
            return false;
        }
    }

    public function update() {
        $sql = "UPDATE sender_requests SET sender_id = :sender_id, announcement_id = :announcement_id, package_size = :package_size, 
                pickup_city = :pickup_city, dropoff_city = :dropoff_city, status = :status WHERE request_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':sender_id' => $this->sender_id,
            ':announcement_id' => $this->announcement_id,
            ':package_size' => $this->package_size,
            ':pickup_city' => $this->pickup_city,
            ':dropoff_city' => $this->dropoff_city,
            ':status' => $this->status,
            ':id' => $this->id
        ]);
    }

    public function delete() {
        $sql = "DELETE FROM sender_requests WHERE request_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $this->id]);
    }

    public static function getPackages($db) {
        $sql = "SELECT request_id FROM sender_requests";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
