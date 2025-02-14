<?php 
use App\Core\controller;
class Home
{
	use Controller;

	public function index()
	{

		$this->view('home');
	}

}