<?php
require_once'../utils/SessionManager.php';

class Admin {
    use Controller;

    private $adminModel;

    public function __construct() {
        // Vérifier si l'admin est connecté sauf pour la page login
        if ($_GET['url'] != 'admin/login') {
            $this->checkAdminAuth();
        }
        $this->adminModel = new AdminModel();
    }

    // 🔒 Vérification authentification admin
    private function checkAdminAuth() {
        if (!SessionManager::isAdmin()) {
            header("Location: " . ROOT . "/admin/login");
            exit();
        }
    }

    // 📌 Page d'accueil de l'admin
    public function index() {
        $data = [
            'users' => $this->adminModel->getUsers(),
            'announcements' => $this->adminModel->getDriverAnnouncements(),
            'packages' => $this->adminModel->getPackages(),
            'logs' => $this->adminModel->getLogs()
        ];
        if(isset($_GET['json'])) {
            $this->jsonResponse($data);
        }
        $this->view('admin/dashboard', $data);
    }

    // 🔑 Connexion de l'admin
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $admin = $this->adminModel->authenticate($email, $password);

            if ($admin) {
                // Utilisation de SessionManager pour définir les variables de session
                SessionManager::set('user_name', $admin->first_name . ' ' . $admin->last_name);
                SessionManager::set('role', 'admin');
                SessionManager::set('logged_in', true);
                SessionManager::set('user_id', $admin->id);
                SessionManager::regenerate(); // Sécurité : régénération de l'ID de session

                if(isset($_GET['json'])) {
                    $this->jsonResponse(['success' => true]);
                }
                header("Location: " . ROOT . "/admin");
                exit();
            } else {
                if(isset($_GET['json'])) {
                    $this->jsonResponse(['error' => 'Identifiants incorrects'], 401);
                }
                $this->view('admin/login', ['error' => 'Identifiants incorrects']);
            }
        } else {
            $this->view('admin/login');
        }
    }

    // 🚪 Déconnexion
    public function logout() {
        session_destroy();
        if(isset($_GET['json'])) {
            $this->jsonResponse(['success' => true]);
        }
        header("Location: " . ROOT . "/admin/login");
        exit();
    }

    // 👥 Gestion des utilisateurs
    public function users() {
        $data = [
            'users' => $this->adminModel->getUsers()
        ];
        if(isset($_GET['json'])) {
            $this->jsonResponse($data);
        }
        $this->view('admin/users', $data);
    }

    // ✅ Validation/Suspension utilisateur
    public function updateUserStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $is_banned = $_POST['is_banned'] ?? false;
            $result = $this->adminModel->updateUserStatus($id, $is_banned);
            if(isset($_GET['json'])) {
                $this->jsonResponse(['success' => $result]);
            }
            header("Location: " . ROOT . "/admin/users");
            exit();
        }
    }

    // ✅ Vérification utilisateur
    public function verifyUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->adminModel->verifyUser($id);
            if(isset($_GET['json'])) {
                $this->jsonResponse(['success' => $result]);
            }
            header("Location: " . ROOT . "/admin/users");
            exit();
        }
    }

    // 📢 Gestion des annonces
    public function announcements() {
        $data = [
            'announcements' => $this->adminModel->getDriverAnnouncements()
        ];
        if(isset($_GET['json'])) {
            $this->jsonResponse($data);
        }
        $this->view('admin/announcements', $data);
    }

    // ❌ Suppression d'une annonce
    public function deleteAnnouncement($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->adminModel->deleteAnnouncement($id);
            if(isset($_GET['json'])) {
                $this->jsonResponse(['success' => $result]);
            }
            header("Location: " . ROOT . "/admin/announcements");
            exit();
        }
    }

    // 📦 Gestion des colis
    public function packages() {
        $data = [
            'packages' => $this->adminModel->getPackages()
        ];
        if(isset($_GET['json'])) {
            $this->jsonResponse($data);
        }
        $this->view('admin/packages', $data);
    }

    // 📝 Logs système
    public function logs() {
        $data = [
            'logs' => $this->adminModel->getLogs()
        ];
        if(isset($_GET['json'])) {
            $this->jsonResponse($data);
        }
        $this->view('admin/logs', $data);
    }
}