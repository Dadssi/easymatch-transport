<?php 

use App\Core\Controller;
class _404
{
	use Controller;
	
	public function index()
	{
		echo "404 Page not found controller";
	}
}