<?php 

require_once __DIR__ . '/../core/Database.php';

class User
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $role;
    private $createdAt;
    private $db;
    
    public function __construct($pdo = null){
        $this->db = $pdo ? $pdo : Database::getInstance()->getConnection();
    }

    public function getId(){
        return $this->id;            
    }
    public function getUsername(){
        return $this->username;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getRole(){
        return $this->role;
    }
    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function setUsername($username){
        $this->username = $username;
    }
    public function setPassword($password){
        $this->password = password_hash($password , PASSWORD_BCRYPT);
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setRole($role){
        $this->role = $role;
    }

    public function createUser($first_name, $last_name, $password, $email, $role)
    {
        $sql = "INSERT INTO users (first_name, last_name, password, email, role) VALUES (:first_name, :last_name, :password, :email, :role)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'password' => $password,
            'email' => $email,
            'role' => $role
        ]);
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE user_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $username, $password, $email, $role)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET username = :username, password = :password, email = :email, role = :role WHERE user_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'username' => $username,
            'password' => $hashedPassword,
            'email' => $email,
            'role' => $role
        ]);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE user_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function loadUser($userId) {
        $sql = "SELECT user_id, first_name, last_name, email, role FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}