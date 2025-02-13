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
