<?php
require_once '../core/database.php'; // Connexion à la base de données
require_once '../core/Model.php'; // Inclure le trait Model
require_once '../models/User.php'; // Inclure le modèle User

class SignUpController {
    private $pdo;
    private $user;

    public function __construct() {
        // Créer une instance de DatabaseConnection et obtenir la connexion PDO
        $dbConnection = new DatabaseConnection();
        $this->pdo = $dbConnection->getConnection();  // Utiliser la méthode publique getConnection()
        $this->user = new User($this->pdo);
    }

    public function registerUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les entrées et les sécuriser
            $nom = htmlspecialchars($_POST['last_name']);
            $prenom = htmlspecialchars($_POST['first_name']);
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $role = $_POST['role'];

            // Vérification des mots de passe
            if ($password !== $confirm_password) {
                die("Les mots de passe ne correspondent pas.");
            }

            // Validation de l'email (utiliser un regex simple)
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("L'email n'est pas valide.");
            }

            // Vérification de la force du mot de passe
            if (strlen($password) < 8) {
                die("Le mot de passe doit contenir au moins 8 caractères.");
            }

            // Vérifier si l'utilisateur existe déjà
            if ($this->user->getUserByEmail($email)) {
                die("Cet email est déjà utilisé.");
            }

            // Hachage du mot de passe
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Créer l'utilisateur
            if ($this->user->createUser($nom, $prenom, $email, $hashed_password)) {
                // Récupérer l'utilisateur créé
                $user = $this->user->getUserByEmail($email);
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $role;

                // Redirection selon le rôle
                switch ($role) {
                    case 'admin':
                        header("Location: ../views/admin_dashboard.php");
                        break;
                    case 'sender':
                        header("Location: ../views/sender_dashboard.php");
                        break;
                    case 'driver':
                        header("Location: ../views/driver_dashboard.php");
                        break;
                    default:
                        header("Location: ../views/login.php");
                        break;
                }
                exit();
            } else {
                die("Erreur lors de l'inscription.");
            }
        }
    }
}
