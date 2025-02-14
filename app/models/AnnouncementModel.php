<?php
class AnnouncementModel {
    private $db;
    public $id;
    public $driver_id;
    public $vehicle_type; 
    public $available_from;
    public $available_until;
   

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($cities) {
       
        if (!isset($this->driver_id, $this->vehicle_type, $this->available_from, $this->available_until)) {
            throw new Exception("Missing required fields");
        }

        try {
            
            $this->db->beginTransaction();

            
            $stmt = $this->db->prepare("
                INSERT INTO driver_announcements 
                (driver_id, vehicle_type, available_from, available_until) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $this->driver_id,
                $this->vehicle_type,
                $this->available_from,
                $this->available_until
            ]);
            
            $announcement_id = $this->db->lastInsertId();

            
            $cityStmt = $this->db->prepare("
                INSERT INTO announcement_cities 
                (announcement_id, city, sequence) 
                VALUES (?, ?, ?)
            ");

            foreach ($cities as $index => $city) {
                $cityStmt->execute([$announcement_id, $city, $index]);
            }

            
            $this->db->commit();
            return $announcement_id;

        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Announcement creation failed: " . $e->getMessage());
        }
    }

    public function read($id) {
        $sql = "SELECT announcement_id, driver_id, vehicle_type, available_from, available_until FROM driver_announcements WHERE announcement_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $this->id = $data['announcement_id'];
            $this->driver_id = $data['driver_id'];
            $this->vehicle_type = $data['vehicle_type'];
            $this->available_from = $data['available_from'];
            $this->available_until = $data['available_until'];
            $data['cities'] = $this->getRoutePoints($id);
            return $data;
        } else {
            return false;
        }
    }

    public function initialize($id) {
        if (!$this->read($id)) {
            throw new Exception("Announcement not found.");
        }
    }

    private function getRoutePoints(int $announcementId): array {
        $sql = "SELECT city 
                FROM announcement_cities 
                WHERE announcement_id = ? 
                ORDER BY sequence ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$announcementId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function update() {
        $sql = "UPDATE driver_announcements SET driver_id = ?, vehicle_type = ?, available_from = ?, available_until = ? WHERE announcement_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->driver_id, $this->vehicle_type, $this->available_from, $this->available_until, $this->id]);
        return $stmt->rowCount() > 0;
    }

    public function delete() {
        
        $sqlSelect = "SELECT route_id FROM driver_announcements WHERE announcement_id = ?";
        $stmtSelect = $this->db->prepare($sqlSelect);
        $stmtSelect->execute([$this->id]);
        $data = $stmtSelect->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            throw new Exception('Announcement not found');
        }
        $route_id = $data['route_id'];

        
        $sqlDeleteAnnouncement = "DELETE FROM driver_announcements WHERE announcement_id = ?";
        $stmtDeleteAnnouncement = $this->db->prepare($sqlDeleteAnnouncement);
        $stmtDeleteAnnouncement->execute([$this->id]);

        
        $sqlDeleteRoutePoints = "DELETE FROM route_points WHERE route_id = ?";
        $stmtDeleteRoutePoints = $this->db->prepare($sqlDeleteRoutePoints);
        $stmtDeleteRoutePoints->execute([$route_id]);

        
        $sqlDeleteRoute = "DELETE FROM routes WHERE route_id = ?";
        $stmtDeleteRoute = $this->db->prepare($sqlDeleteRoute);
        $stmtDeleteRoute->execute([$route_id]);

        return true;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'driver_id' => $this->driver_id,
            'vehicle_type' => $this->vehicle_type,
            'available_from' => $this->available_from,
            'available_until' => $this->available_until,
            'cities' => $this->getRoutePoints($this->id),
        ];
    }

    public static function getAnnouncementsByDriver($db, $driver_id) {
        $sql = "SELECT announcement_id FROM driver_announcements WHERE driver_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$driver_id]);
        $announcements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $announcement = new AnnouncementModel($db);
            $announcement->initialize($row['announcement_id']);
            $announcements[] = $announcement;
        }
        return $announcements;
    }



    public function getAllAnnouncements(){
        $stmt = $this->db->prepare("SELECT * FROM driver_announcements");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllAnnoucementsCities(){
        $stmt = $this->db->prepare("SELECT * FROM announcement_cities");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>
