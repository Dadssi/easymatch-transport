<<<<<<< HEAD
<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/controllers/SignUpController.php';
require_once __DIR__ . '/../app/models/User.php';


=======
<?php 
use App\Core\App;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';


require "../app/core/init.php";

DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

$app = new App;
$app->loadController();



// require_once __DIR__ . '/../vendor/autoload.php';

// use App\Core\App;

// $app = new App();

>>>>>>> 9d1b4c8dc3be75093a94f1a1c68a559372f086f1
