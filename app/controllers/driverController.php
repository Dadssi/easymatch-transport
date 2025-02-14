<?php
require_once __DIR__ . '/../models/driverModel.php';
require_once __DIR__ . '/../models/AnnouncementModel.php';

class DriverController {
    private $driverModel;

    public function __construct($db) {
        // Inject the PDO connection into the model
        $this->driverModel = new DriverModel($db);
    }

    private function jsonResponse($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit();
    }

    public function getVehicles() {
        
        $driver_id = $_SESSION['user_id'] ?? null;
        if (!$driver_id) {
            $this->jsonResponse(['error' => 'Not authenticated'], 401);
        }
        // Delegate fetching vehicles to the model
        $vehicles = $this->driverModel->getVehiclesByDriver($driver_id);
        $this->jsonResponse($vehicles, 200);
    }

    public function createVehicle() {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $this->jsonResponse(['error' => 'Invalid input'], 400);
        }
        $driver_id = $_SESSION['user_id'] ?? null;
        if (!$driver_id) {
            $this->jsonResponse(['error' => 'Not authenticated'], 401);
        }
        if (!isset($input['vehicle_type'], $input['carry_size'])) {
            $this->jsonResponse(['error' => 'Missing required fields'], 400);
        }
        // Call the model method to create a vehicle
        $vehicle_id = $this->driverModel->createVehicle($driver_id, $input['vehicle_type'], $input['carry_size']);
        if (is_numeric($vehicle_id)) {
            $this->jsonResponse(['message' => 'Vehicle created successfully', 'vehicle_id' => $vehicle_id], 201);
        } else {
            $this->jsonResponse(['error' => $vehicle_id], 500);
        }
    }

    public function createAnnouncement() {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $this->jsonResponse(['error' => 'Invalid input'], 400);
        }
    
        // Validate required fields
        $requiredFields = ['driver_id', 'vehicle_id', 'available_from', 'available_until', 'cities'];
        foreach ($requiredFields as $field) {
            if (!isset($input[$field])) {
                $this->jsonResponse(['error' => "Missing field: $field"], 400);
            }
        }
    
        // Retrieve the vehicle type using vehicle_id
        $vehicle_type = $this->driverModel->getVehicleType($input['vehicle_id']);
        if (!$vehicle_type) {
            $this->jsonResponse(['error' => 'Invalid vehicle'], 400);
        }
    
        // Delegate announcement creation to the AnnouncementModel
        $announcementModel = new AnnouncementModel($this->driverModel->getDb());
        $announcementModel->driver_id = $input['driver_id'];
        $announcementModel->vehicle_type = $vehicle_type;
        $announcementModel->available_from = $input['available_from'];
        $announcementModel->available_until = $input['available_until'];
    
        try {
            $announcementId = $announcementModel->create($input['cities']);
            $this->jsonResponse(['message' => 'Announcement created successfully', 'announcement_id' => $announcementId], 201);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }
    

    public function updateAnnouncement($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $this->jsonResponse(['error' => 'Invalid input'], 400);
        }

        $fields = ['driver_id', 'vehicle_id', 'available_from', 'available_until', 'cities'];
        $announcementModel = new AnnouncementModel($this->driverModel->getDb());
        $announcementModel->id = $id;

        try {
            $announcementModel->initialize($id);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 404);
        }

        foreach ($fields as $field) {
            if (isset($input[$field])) {
                $announcementModel->$field = $input[$field];
            }
        }

        if ($announcementModel->update()) {
            $this->jsonResponse(['message' => 'Announcement updated successfully'], 200);
        } else {
            $this->jsonResponse(['error' => 'Failed to update announcement'], 500);
        }
    }

    public function deleteAnnouncement($id) {
        $announcementModel = new AnnouncementModel($this->driverModel->getDb());
        try {
            $announcementModel->initialize($id);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 404);
        }
        if ($announcementModel->delete()) {
            $this->jsonResponse(['message' => 'Announcement deleted successfully'], 200);
        } else {
            $this->jsonResponse(['error' => 'Failed to delete announcement'], 500);
        }
    }

    public function getAnnouncement($id) {
        $announcementModel = new AnnouncementModel($this->driverModel->getDb());
        try {
            $announcement = $announcementModel->read($id);
            if (!$announcement) {
                $this->jsonResponse(['error' => 'Announcement not found'], 404);
            }
            $this->jsonResponse($announcement, 200);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function getAllAnnouncements() {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['driver_id'])) {
            $this->jsonResponse(['error' => 'Driver ID is required'], 400);
        }
        $driver_id = $input['driver_id'];
        $announcements = $this->driverModel->loadAnnouncements($driver_id);
        $announcementsData = array_map(function ($announcement) {
            return $announcement->toArray();
        }, $announcements);
        $this->jsonResponse($announcementsData, 200);
    }

    public function dashboard(){
        require __DIR__ . '/../views/driverDashboard.html';
    }


    public function getallDrivers(){
        $drivers = $this->driverModel->getAllDrivers();
        $this->jsonResponse($drivers);
    }

    public function getPackges(){
        $packages = $this->driverModel->getPackages();
        $this->jsonResponse($packages);
    }
}
?>
