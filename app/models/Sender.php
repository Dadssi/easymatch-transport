<?php 

require 'PackageModel.php';
require_once 'User.php';

class Sender extends User
{

	private $packages = [];
	protected $db; 



	public function __construct($db) {
		parent::__construct($db);
		$this->db = $db;
		$this->packages = [];
	}	


	public function getDb() {
		return $this->db;
	}

	public function loadPackages(){
		$Packages = PackageModel::getPackages();
		foreach ($Packages as $as){
			$Package = new PackageModel($this->db);
			$Package->intilize($as['id']);
			$this->packages[] = $Package;
		}
	}
	public function getSenderRequests($senderId) {
		$query = "SELECT * FROM sender_requests WHERE sender_id = :sender_id";
		$stmt = $this->db->prepare($query);
		$stmt->bindParam(':sender_id', $senderId, PDO::PARAM_INT);
		$stmt->execute();
	
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


    
}