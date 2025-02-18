<?php 
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Sender.php';
require_once __DIR__ . '/../models/PackageModel.php';

class SenderController
{
    private $db;
    private $sender;

    public function __construct($pdo = null){
        $this->db = $pdo ? $pdo : Database::getInstance()->getConnection();
        $this->sender = new Sender($this->db);
    }
    private function jsonResponse($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit();
    }
    public function makereq(){
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $this->jsonResponse(['error' => 'Invalid input'], 400);
        }
        
        $sender_id      = $input['sender_id'] ?? null;
        $announcement_id = $input['announcement_id'] ?? null;
        $package_size   = $input['package_size'] ?? null;
        $pickup_city    = $input['pickup_city'] ?? null;
        $dropoff_city   = $input['dropoff_city'] ?? null;
        $status         = $input['status'] ?? 'pending';  

        if(!$sender_id || !$announcement_id || !$package_size || !$pickup_city || !$dropoff_city){
            throw new Exception("Missing required fields for package creation.");
        }

        
        $package = new PackageModel($this->db);
        $package->sender_id      = $sender_id;
        $package->announcement_id = $announcement_id;
        $package->package_size   = $package_size;
        $package->pickup_city    = $pickup_city;
        $package->dropoff_city   = $dropoff_city;
        $package->status         = $status;

        
        $newPackageId = $package->create();

        if($newPackageId === false) {
            throw new Exception("Failed to create package.");
        }

        $this->jsonResponse($package, 200);
        
    }

    public function getallreq(){
        $packages = $this->sender->getSenderRequests($_SESSION['user_id']);
        $this->jsonResponse($packages);
    }

    public function dashboard(){
        require __DIR__ . '/../views/senderDashboard.html';
    }

    public function changePackageStatus(){
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $this->jsonResponse(['error' => 'Invalid input'], 400);
        }
        $package_id = $input['package_id'] ?? null;
        $status = $input['status'] ?? null;

        if(!$package_id || !$status){
            throw new Exception("Missing required fields for package status update.");
        }

        $package = new PackageModel($this->db);
        $package->initialize($package_id);
        $package->status = $status;
        $package->update();

        $this->jsonResponse(['message' => 'Package status updated successfully'], 200);
    }


}
