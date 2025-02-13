<?php 

/**
 * home class
 */
class Admin
{
	use Controller;

	public function index()
	{

		$this->view('admin');
	}

}

// -------------------------------------------
// -------------------------------------------
// -------------------------------------------

require_once 'app/models/Admin.php';
require_once 'config/database.php';

class AdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin(Database::getInstance()->getConnection());
    }

    public function dashboard() {
        require 'app/views/admin/dashboard.php';
    }

    public function users() {
        $users = $this->adminModel->getAllUsers();
        require 'app/views/admin/users.php';
    }

    public function updateUserStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $status = $_POST['status'];
            if ($this->adminModel->updateUserStatus($userId, $status)) {
                header("Location: /admin/users");
                exit();
            }
        }
    }

    public function annonces() {
        $annonces = $this->adminModel->getAllAnnonces();
        require 'app/views/admin/annonces.php';
    }

    public function deleteAnnonce() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $annonceId = $_POST['annonce_id'];
            if ($this->adminModel->deleteAnnonce($annonceId)) {
                header("Location: /admin/annonces");
                exit();
            }
        }
    }
}
?>

