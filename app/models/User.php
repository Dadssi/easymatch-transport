<?php 


/**
 * User class
 */

	class User
	{
		private $id;
		private $nom;
		private $prenom;
		private $email;
		private $password;
		private $pdo;
			 
		public function __construct($pdo){
			$this->pdo = $pdo;
		}
	
	
		public function getId(){
			return $this->id;            
		}
		public function getNom(){
			return $this->nom;
		}
		public function getPrenom(){
			return $this->prenom;
		}
		public function getEmail(){
			return $this->email;
		}
		public function getPassword(){
			return $this->password;
		}
	
		public function setNom($nom){
			$this->nom = $nom;
		}
		public function setPrenom($prenom){
			$this->prenom = $prenom;
		}
		public function setEmail($email){
			$this->email = $email;
		}
		public function setPassword($password){
			$this->password = password_hash($password , PASSWORD_BCRYPT);
		}
	 
		
	
	 
		// Récupérer un utilisateur par ID
		public function getUserById($id)
		{
			$sql = "SELECT * FROM users WHERE id = :id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(['id' => $id]);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
	
	
		// Récupérer un utilisateur par email
		public function getUserByEmail($email)
		{
			$sql = "SELECT * FROM users WHERE email = :email";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(['email' => $email]);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
	
	
	  // Ajouter un utilisateur
	  public function createUser($nom, $prenom, $email, $password)
	  {
		  $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hasher le mot de passe
		  $sql = "INSERT INTO users (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :password)";
		  $stmt = $this->pdo->prepare($sql);
		  return $stmt->execute([
			  'nom' => $nom,
			  'prenom' => $prenom,
			  'email' => $email,
			  'password' => $hashedPassword
		  ]);
	  }
		// Supprimer un utilisateur
		public function deleteUser($id)
		{
			$sql = "DELETE FROM users WHERE id = :id";
			$stmt = $this->pdo->prepare($sql);
			return $stmt->execute(['id' => $id]);
		}
		
	

	use Model;

	protected $table = 'users';

	protected $allowedColumns = [

		'email',
		'password',
	];

	public function validate($data)
	{
		$this->errors = [];

		if(empty($data['email']))
		{
			$this->errors['email'] = "Email is required";
		}else
		if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL))
		{
			$this->errors['email'] = "Email is not valid";
		}
		
		if(empty($data['password']))
		{
			$this->errors['password'] = "Password is required";
		}
		
		if(empty($data['terms']))
		{
			$this->errors['terms'] = "Please accept the terms and conditions";
		}

		if(empty($this->errors))
		{
			return true;
		}

		return false;
	}
}