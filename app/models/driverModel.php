<?php
require 'PackageModel.php';
require_once 'User.php';

class DriverModel extends User {
    private $announcements = [];
    private $packages = [];
    protected $db; 
    public function __construct($db) {
        parent::__construct($db);
        $this->db = $db;
        $this->announcements = [];
        $this->packages = [];
    }

    public function getDb() {
        return $this->db;
    }

    public function loadAnnouncements($driver_id) {
        $this->announcements = AnnouncementModel::getAnnouncementsByDriver($this->db, $driver_id);
        return $this->announcements;
    }

    public function getAnnouncements() {
        return $this->announcements;
    }

    public function loadPackages(){
        $Packages = PackageModel::getPackages();
        foreach ($Packages as $as){
            $Package = new PackageModel($this->db);
            $Package->intilize($as['id']);
            $this->packages[] = $Package;
        }
    }

    
    public function getVehiclesByDriver($driver_id) {
        $stmt = $this->db->prepare("SELECT vehicle_id, vehicle_type, carry_size FROM vehicles WHERE driver_id = ?");
        $stmt->execute([$driver_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function createVehicle($driver_id, $vehicle_type, $carry_size) {
        
        $stmt = $this->db->prepare("SELECT vehicle_id FROM vehicles WHERE driver_id = ?");
        $stmt->execute([$driver_id]);
        if ($stmt->rowCount() > 0) {
            return 'Driver already has a vehicle';
        }

        $stmt = $this->db->prepare("INSERT INTO vehicles (driver_id, vehicle_type, carry_size) VALUES (?, ?, ?)");
        if ($stmt->execute([$driver_id, $vehicle_type, $carry_size])) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function getVehicleType($vehicle_id) {
        $stmt = $this->db->prepare("SELECT vehicle_type FROM vehicles WHERE vehicle_id = ?");
        $stmt->execute([$vehicle_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['vehicle_type'] : null;
    }
    

    public function getPackages() {
        return $this->packages;
    }


    public function getAllDrivers() {
        $stmt = $this->db->prepare("SELECT user_id, first_name, last_name, email, isverified FROM users WHERE role = 'driver'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
