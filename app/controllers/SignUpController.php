<?php

// namespace App\Controllers;

// use App\Models\User;
use Core\Database;
// use Core\Controller;
// use Core\Request;

require_once __DIR__.'/../Models/User.php';

class SignUpController 
{
    // Méthode pour afficher le formulaire d'inscription
    public function showsignupForm()
    {
        return $this->view('signup');
    }

    // Méthode pour enregistrer un utilisateur
    public function registerUser()
    {
        // Récupérer les données du formulaire
        $data = $_POST;

        // Valider les données
        // if (!$this->validateSignupData($data)) {
        //     return $this->view('signup', ['errors' => $this->errors]);
        // }

        
        $user = new User(Database::getConnection());
        if ($user->getUserByEmail($data['email'])) {
            $this->errors['email'] = 'Cet email est déjà utilisé.';
            return $this->view('signup', ['errors' => $this->errors]);
        }
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $user->createUser($data['nom'], $data['prenom'], $data['email'], $password);

        
        exit;
    }

    // Méthode pour valider les données d'inscription
    private function validateSignupData($data)
    {
        $this->errors = [];

        // Validation du prénom
        if (empty($data['prenom'])) {
            $this->errors['prenom'] = 'Le prénom est requis.';
        }

        // Validation du nom
        if (empty($data['nom'])) {
            $this->errors['nom'] = 'Le nom est requis.';
        }

        // Validation de l'email
        if (empty($data['email'])) {
            $this->errors['email'] = 'L\'email est requis.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'L\'email n\'est pas valide.';
        }

        // Validation du mot de passe
        if (empty($data['password'])) {
            $this->errors['password'] = 'Le mot de passe est requis.';
        } elseif ($data['password'] !== $data['confirm_password']) {
            $this->errors['confirm_password'] = 'Les mots de passe ne correspondent pas.';
        }

        // Validation du téléphone
        if (empty($data['phone'])) {
            $this->errors['phone'] = 'Le téléphone est requis.';
        }

        // Validation de la date de naissance
        if (empty($data['birthday'])) {
            $this->errors['birthday'] = 'La date de naissance est requise.';
        }

        // Validation du rôle
        if (empty($data['role'])) {
            $this->errors['role'] = 'Le rôle est requis.';
        }

        return empty($this->errors);
    }
}
