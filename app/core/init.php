<?php 

// spl_autoload_register(function($classname){

// 	require $filename = "../app/models/".ucfirst($classname).".php";
// });

spl_autoload_register(function($classname){
    if(file_exists("../app/models/".ucfirst($classname).".php"))
    {
        require "../app/models/".ucfirst($classname).".php";
    }
    elseif(file_exists("../app/controllers/".ucfirst($classname).".php"))
    {
        require "../app/controllers/".ucfirst($classname).".php";
    }
});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';