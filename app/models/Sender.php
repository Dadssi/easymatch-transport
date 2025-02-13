<?php 


/**
 * User class
 */
class Sender extends User
{
	use Model;
	protected $table = 'users';

	protected $allowedColumns = [

		'email',
		'password',
	];

    
}