<?php
// require_once "Model.php";

class AdminModel {
    use Model;
    
    protected $table = "users"; // Nom de la table des utilisateurs
    protected $allowedColumns = ['id', 'first_name', 'last_name', 'email', 'password', 'role', 'created_at'];

    // Vérifier si un administrateur existe
    public function authenticate($email, $password) {
        $admin = $this->first(['email' => $email]);
        
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }

    // Récupérer tous les utilisateurs
    public function getUsers() {
        $this->table = "users";
        return $this->findAll();
    }

    // Valider ou suspendre un utilisateur
    public function updateUserStatus($userId, $status) {
        $this->table = "users";
        return $this->update($userId, ['status' => $status]);
    }

    // Gérer les annonces des conducteurs
    public function getAllAnnoncements() {
        $this->table = "annonces";
        return $this->findAll();
    }

    public function deleteAnnoncement($annonceId) {
        $this->table = "annonces";
        return $this->delete($annonceId);
    }

    // Suivi des transactions
    public function getTransactions() {
        $this->table = "transactions";
        return $this->findAll();
    }

    // Gestion des évaluations
    public function getEvaluations() {
        $this->table = "evaluations";
        return $this->findAll();
    }

    public function deleteEvaluation($evaluationId) {
        $this->table = "evaluations";
        return $this->delete($evaluationId);
    }

    // Générer des statistiques
    public function getStats() {
        return [
            'total_users' => count($this->getUsers()),
            'total_annonces' => count($this->getAllAnnoncements()),
            'total_transactions' => count($this->getTransactions()),
            'total_evaluations' => count($this->getEvaluations()),
        ];
    }
}
