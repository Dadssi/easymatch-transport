<?php
class Announcement {
    private $db;
    
    
    public $id;
    public $driver_id;
    public $vehicle_category_id;
    public $total_volume;
    public $available_volume;
    public $departure_city;
    public $arrival_city;
    public $departure_date;
    public $status;
    public $created_at;
    
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    
    public function create() {
        $sql = "INSERT INTO driver_announcements 
                (driver_id, vehicle_category_id, total_volume, available_volume, departure_city, arrival_city, departure_date, status)
                VALUES 
                (:driver_id, :vehicle_category_id, :total_volume, :available_volume, :departure_city, :arrival_city, :departure_date, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':driver_id', $this->driver_id);
        $stmt->bindParam(':vehicle_category_id', $this->vehicle_category_id);
        $stmt->bindParam(':total_volume', $this->total_volume);
        $stmt->bindParam(':available_volume', $this->available_volume);
        $stmt->bindParam(':departure_city', $this->departure_city);
        $stmt->bindParam(':arrival_city', $this->arrival_city);
        $stmt->bindParam(':departure_date', $this->departure_date);
        $stmt->bindParam(':status', $this->status);
        
        if ($stmt->execute()) {
            $this->id = $this->db->lastInsertId();
            return $this->id;
        }
        return false;
    }
    
    
    public function read($id) {
        $sql = "SELECT * FROM driver_announcements WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $announcement = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($announcement) {
            $this->id = $announcement['id'];
            $this->driver_id = $announcement['driver_id'];
            $this->vehicle_category_id = $announcement['vehicle_category_id'];
            $this->total_volume = $announcement['total_volume'];
            $this->available_volume = $announcement['available_volume'];
            $this->departure_city = $announcement['departure_city'];
            $this->arrival_city = $announcement['arrival_city'];
            $this->departure_date = $announcement['departure_date'];
            $this->status = $announcement['status'];
            $this->created_at = $announcement['created_at'];
            return $announcement;
        }
        return false;
    }
    
    
    public function initialize($id) {
        if (!$this->read($id)) {
            throw new Exception("Announcement not found.");
        }
    }
    

    public function update() {
        $sql = "UPDATE driver_announcements SET 
                    driver_id = :driver_id,
                    vehicle_category_id = :vehicle_category_id,
                    total_volume = :total_volume,
                    available_volume = :available_volume,
                    departure_city = :departure_city,
                    arrival_city = :arrival_city,
                    departure_date = :departure_date,
                    status = :status
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':driver_id', $this->driver_id);
        $stmt->bindParam(':vehicle_category_id', $this->vehicle_category_id);
        $stmt->bindParam(':total_volume', $this->total_volume);
        $stmt->bindParam(':available_volume', $this->available_volume);
        $stmt->bindParam(':departure_city', $this->departure_city);
        $stmt->bindParam(':arrival_city', $this->arrival_city);
        $stmt->bindParam(':departure_date', $this->departure_date);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }
    
   
    public function delete() {
        $sql = "DELETE FROM driver_announcements WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
    

    public static function getAllAnnouncements($db) {
        $sql = "SELECT * FROM driver_announcements";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function addStops(array $stops) {
        if (!$this->id) {
            throw new Exception("Announcement ID is not set.");
        }
        $sql = "INSERT INTO announcement_stops (announcement_id, stop_order, city) VALUES (:announcement_id, :stop_order, :city)";
        $stmt = $this->db->prepare($sql);
        
        foreach ($stops as $index => $city) {
            $stop_order = $index + 1; // order starts at 1
            $stmt->bindValue(':announcement_id', $this->id);
            $stmt->bindValue(':stop_order', $stop_order);
            $stmt->bindValue(':city', $city);
            $stmt->execute();
        }
        return true;
    }
    
    
    public function getStops() {
        if (!$this->id) {
            throw new Exception("Announcement ID is not set.");
        }
        $sql = "SELECT * FROM announcement_stops WHERE announcement_id = :announcement_id ORDER BY stop_order ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':announcement_id', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStops(array $stops) {
        
        $sql = "DELETE FROM announcement_stops WHERE announcement_id = :announcement_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':announcement_id', $this->id);
        $stmt->execute();
        
        // Add new stops if provided
        if (count($stops) > 0) {
            $this->addStops($stops);
        }
    }

    public static function getAnnouncementsByDriver($db, $driver_id) {
        $sql = "SELECT * FROM driver_announcements WHERE driver_id = :driver_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':driver_id', $driver_id);
        $stmt->execute();
        $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // For each announcement, retrieve its stops
        foreach ($announcements as &$announcement) {
            $instance = new Announcement($db);
            $instance->initialize($announcement['id']);
            $announcement['stops'] = $instance->getStops();
        }
        return $announcements;
    }
    
}
?>
