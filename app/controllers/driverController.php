<?php
require_once 'AnnouncementModel.php';

class DriverController {
    private $db;
    
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    
    private function jsonResponse($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit();
    }
    
   
    public function createAnnouncement() {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $this->jsonResponse(['error' => 'Invalid input'], 400);
        }
        
        
        $requiredFields = ['driver_id', 'vehicle_category_id', 'total_volume', 'available_volume', 'departure_city', 'arrival_city', 'departure_date', 'status'];
        foreach ($requiredFields as $field) {
            if (!isset($input[$field])) {
                $this->jsonResponse(['error' => "Missing field: $field"], 400);
            }
        }
        
        $announcement = new Announcement($this->db);
        $announcement->driver_id = $input['driver_id'];
        $announcement->vehicle_category_id = $input['vehicle_category_id'];
        $announcement->total_volume = $input['total_volume'];
        $announcement->available_volume = $input['available_volume'];
        $announcement->departure_city = $input['departure_city'];
        $announcement->arrival_city = $input['arrival_city'];
        $announcement->departure_date = $input['departure_date'];
        $announcement->status = $input['status'];
        
        $announcementId = $announcement->create();
        if (!$announcementId) {
            $this->jsonResponse(['error' => 'Announcement creation failed'], 500);
        }
        
        
        if (isset($input['stops']) && is_array($input['stops']) && count($input['stops']) > 0) {
            $announcement->addStops($input['stops']);
        }
        
        $this->jsonResponse(['message' => 'Announcement created successfully', 'announcement_id' => $announcementId], 201);
    }
    
   
    public function updateAnnouncement($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $this->jsonResponse(['error' => 'Invalid input'], 400);
        }
        
        $announcement = new Announcement($this->db);
        
        try {
            $announcement->initialize($id);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 404);
        }
        
        
        $fields = ['driver_id', 'vehicle_category_id', 'total_volume', 'available_volume', 'departure_city', 'arrival_city', 'departure_date', 'status'];
        foreach ($fields as $field) {
            if (isset($input[$field])) {
                $announcement->$field = $input[$field];
            }
        }
        
        if ($announcement->update()) {
            
            if (isset($input['stops']) && is_array($input['stops'])) {
                $announcement->updateStops($input['stops']);
            }
            $this->jsonResponse(['message' => 'Announcement updated successfully'], 200);
        } else {
            $this->jsonResponse(['error' => 'Failed to update announcement'], 500);
        }
    }
    
    
    public function deleteAnnouncement($id) {
        $announcement = new Announcement($this->db);
        if (!$announcement->read($id)) {
            $this->jsonResponse(['error' => 'Announcement not found'], 404);
        }
        if ($announcement->delete()) {
            $this->jsonResponse(['message' => 'Announcement deleted successfully'], 200);
        } else {
            $this->jsonResponse(['error' => 'Failed to delete announcement'], 500);
        }
    }

    public function getAnnouncement($id) {
        $announcement = new Announcement($this->db);
        $data = $announcement->read($id);
        if (!$data) {
            $this->jsonResponse(['error' => 'Announcement not found'], 404);
        }
        $data['stops'] = $announcement->getStops();
        $this->jsonResponse($data, 200);
    }
    
    public function getAllAnnouncements() {
        if (!isset($_GET['driver_id'])) {
            $this->jsonResponse(['error' => 'Driver ID is required'], 400);
        }
        $driver_id = $_GET['driver_id'];
        $announcements = Announcement::getAnnouncementsByDriver($this->db, $driver_id);
        $this->jsonResponse($announcements, 200);
    }
}

?>
