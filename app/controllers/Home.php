<?php 

/**
 * home class
 */
class Home
{
	use Controller;
	//jjd

	public function index()
	{

		$this->view('home');
	}

}
