<?php 


require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/Validation.php';
require_once __DIR__ . '/../utils/Mailer.php';
require_once __DIR__ . '/../models/AnnouncementModel.php';

class UserController {
    private $userModel;
    private $validator;
    private $mailer;
    private $AnnouncementModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
        $this->validator = new Validation();
        $this->mailer = new Mailer();
        $this->AnnouncementModel = new AnnouncementModel($pdo);
        SessionManager::startSession();
    }

    public function register() {
        try {
            $allowedFields = ['first_name', 'last_name', 'email', 'password', 'role'];
            $userData = $_POST;

            // Hash password
            $userData['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

            // Create user
            $userCreated = $this->userModel->createUser(
                $userData['first_name'],
                $userData['last_name'],
                $userData['password'],
                $userData['email'],
                $userData['role']
            );

            if ($userCreated) {
                $subject = "Email Validation";
                $message = "Please click the link below to validate your email address:\n";
                $message .= "http://example.com/validate?email=" . urlencode($userData['email']) . "&token=" . bin2hex(random_bytes(16));
                $this->mailer->notify($userData['email'], $subject, $message);

                $this->jsonResponse(['success' => true, 'message' => 'Registration successful. Please check your email to validate your account.']);
                header('Location: /user/login');
            } else {
                throw new Exception("Failed to register user.");
            }
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    public function login() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            Validation::required($data, ['email', 'password']);
            $email = Validation::email($data['email']);

           
            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($data['password'], $user['password'])) {
                SessionManager::set('user_id', $user['user_id']);
                SessionManager::set('role', $user['role']);

                $redirectPath = match ($user['role']) {
                    'admin' => '/admin/dashboard',
                    'driver' => '/driver/dashboard',
                    'sender' => '/sender/dashboard',
                    default => '/',
                };
                $this->jsonResponse(['success' => true, 'redirect' => $redirectPath]);

            } else {
                throw new Exception("Invalid credentials ". $email . " " . $data['password'] . " " . $user['password']);
            }
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    public function logout() {
        SessionManager::destroy();
        $this->jsonResponse(['success' => true]);
    }

    public function updateProfile() {
        try {
            $userId = SessionManager::get('user_id');
            $updateData = $this->validator->filterInput($_POST, [
                'username', 'email', 'password'
            ]);
            if (!empty($updateData['password'])) {
                $updateData['password'] = password_hash($updateData['password'], PASSWORD_BCRYPT);
            }
            $userUpdated = $this->userModel->updateUser($userId, $updateData);
            if ($userUpdated) {
                $this->jsonResponse(['success' => true]);
            } else {
                throw new Exception("Failed to update profile.");
            }
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    public function forgotPassword() {
        try {

            $this->validator->validate($_POST, ['email' => 'Email']);
            $token = bin2hex(random_bytes(32));
            $this->userModel->storeResetToken($_POST['email'], $token);
            $this->jsonResponse([
                'success' => true,
                'message' => 'Reset instructions sent'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    public function loadUser() { 
        try {
            $userId = SessionManager::get('user_id'); 

            if (!$userId) {
                $this->jsonResponse(['error'=> "User not authenticated."], 408);
            }

            $user = $this->userModel->loadUser($userId); 
            if ($user) {
                $this->jsonResponse(['success' => true, 'user' => $user]);
            } else {
                throw new Exception("User not found.");
            }
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 400);
        }
    }


    public function showsignupForm(){
        require_once __DIR__ . '/../views/signUp.html';
    }
    public function loginForm(){
        require_once __DIR__ . '/../views/login.html';
    }

    public function servehome(){
        require_once __DIR__ . '/../views/home.html';
    }

    public function getCities() {
        $filePath = __DIR__ . '/../views/cities.json';

        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $data = json_decode($jsonContent, true);

            if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
               
                $this->jsonResponse(['error' => 'Invalid JSON format in cities.json'], 500);
            } else {
                $this->jsonResponse($data, 200);
            }
        } else {
            $this->jsonResponse(['error' => 'cities.json not found'], 404);
        }
    }



    public function getAllAnnoucements(){
        $announcements = $this->AnnouncementModel->getAllAnnouncements();
        $this->jsonResponse($announcements);
    }    
    public function getAllAnnoucementsCities(){
        $announcements = $this->AnnouncementModel->getAllAnnoucementsCities();
        $this->jsonResponse($announcements);
    }


    public function carImage(){
        $imagePath = __DIR__ . '/../views/assets/img/car.jpg';
        $this->imageResponse($imagePath);
    }

    public function vanImage(){
        $imagePath = __DIR__ . '/../views/assets/img/van.jpg';
        $this->imageResponse($imagePath);
    }
    public function truckImage(){
        $imagePath = __DIR__ . '/../views/assets/img/truck.jpg';
        $this->imageResponse($imagePath);
    }


    private function jsonResponse($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }


    private function imageResponse($imagePath, $mimeType = 'image/jpg') {
        if (!file_exists($imagePath)) {
            http_response_code(404);
            exit('Image not found');
        }
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($imagePath));
        readfile($imagePath);
        exit();
    }



}

