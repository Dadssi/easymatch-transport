<?php


require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/PackageModel.php';

class AdminController {
    private $adminModel;
    private $packageModel;

    public function __construct($db) {
        $this->adminModel = new AdminModel($db);
        $this->packageModel = new PackageModel($db);
    }

    
    private function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    
    public function deleteAnnouncement() {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['announcement_id'])) {
            $this->jsonResponse(['error' => 'Invalid input'], 400);
        }
        $announcement_id = $input['announcement_id'];
        try {
            $result = $this->adminModel->deleteAnnouncement($announcement_id);
            if ($result) {
                $this->jsonResponse(['message' => 'Announcement deleted successfully']);
            } else {
                $this->jsonResponse(['error' => 'Announcement deletion failed'], 500);
            }
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

  
    public function deleteUser() {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['user_id'])) {
            $this->jsonResponse(['error' => 'Invalid input'], 400);
        }
        $user_id = $input['user_id'];
        try {
            $result = $this->adminModel->deleteUser($user_id);
            if ($result) {
                $this->jsonResponse(['message' => 'User deleted successfully']);
            } else {
                $this->jsonResponse(['error' => 'User deletion failed'], 500);
            }
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    // Delete a package
    public function deletePackage() {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['package_id'])) {
            $this->jsonResponse(['error' => 'Invalid input'], 400);
        }
        $package_id = $input['package_id'];
        try {
            $result = $this->adminModel->deletePackage($package_id);
            if ($result) {
                $this->jsonResponse(['message' => 'Package deleted successfully']);
            } else {
                $this->jsonResponse(['error' => 'Package deletion failed'], 500);
            }
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    // Get overall detailed stats for users, packages, and announcements
    public function getStats() {
        try {
            $stats = $this->adminModel->getStats();
            $this->jsonResponse(['stats' => $stats]);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }


    public function getAllUsers() {
        try {
            $users = $this->adminModel->getAllUsers();
            $this->jsonResponse(['users' => $users]);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }


    public function getAllPackages() {
        try {
            $packages = $this->packageModel->getAllPackages();
            $this->jsonResponse(['packages' => $packages]);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }



    
    public function verifyDriver() {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['driver_id'])) {
            $this->jsonResponse(['error' => 'Invalid input'], 400);
        }
        $driver_id = $input['driver_id'];
        try {
            $result = $this->adminModel->verifyDriver($driver_id);
            if ($result) {
                $this->jsonResponse(['message' => 'Driver verified successfully']);
            } else {
                $this->jsonResponse(['error' => 'Driver verification failed'], 500);
            }
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }


    public function updatePackageStatus(){

        $input = json_decode(file_get_contents('php://input'), true);
        $request_id = $input['request_id'] ?? null;
        $status = $input['status'] ?? null;
        try {
            $result = $this->packageModel->updatePackageStatus($request_id, $status);
            if ($result) {
                $this->jsonResponse(['message' => 'Package status updated successfully']);
            } else {
                $this->jsonResponse(['error' => 'Failed to update package status'], 500);
            }
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function dashboard(){
        require __DIR__ . '/../views/adminDashboard.html';
    }


}