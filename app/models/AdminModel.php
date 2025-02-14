<?php

class AdminModel {
    use Model;

    protected $table = "users";
    protected $allowedColumns = [
        'id', 'first_name', 'last_name', 'email', 'password', 
        'phone', 'birthday', 'role', 'vehicle_category_id',
        'is_verified', 'is_banned', 'created_at'
    ];

    // ✅ Vérification des identifiants
    public function authenticate($email, $password) {
        $admin = $this->first(['email' => $email, 'role' => 'admin']);
        return ($admin && password_verify($password, $admin->password)) ? $admin : false;
    }

    // 👥 Récupérer tous les utilisateurs
    public function getUsers() {
        return $this->findAll();
    }

    // 🎟️ Valider/Suspendre un utilisateur
    public function updateUserStatus($id, $is_banned) {
        return $this->update($id, ['is_banned' => $is_banned]);
    }

    // ✅ Vérifier un utilisateur
    public function verifyUser($id) {
        return $this->update($id, ['is_verified' => true]);
    }

    // 📢 Gestion des annonces des conducteurs
    public function getDriverAnnouncements() {
        $this->table = "driver_announcements";
        return $this->findAll();
    }

    public function deleteAnnouncement($id) {
        $this->table = "driver_announcements";
        return $this->delete($id);
    }

    // 📦 Gestion des colis
    public function getPackages() {
        $this->table = "packages";
        return $this->findAll();
    }

    // 📝 Gestion des logs
    public function getLogs() {
        $this->table = "logs";
        return $this->findAll();
    }

    // Ajouter un log
    protected function addLog($user_id, $action) {
        $this->table = "logs";
        return $this->insert([
            'user_id' => $user_id,
            'action' => $action
        ]);
    }
}





