<?php

return [

    'GET|/driver/dashboard' => ['controller' => 'DriverController', 'action' => 'dashboard', 'middleware' => ['driver']],
    'GET|/sender/dashboard' => ['controller' => 'SenderController', 'action' => 'dashboard', 'middleware' => ['driver']],
    'GET|/' => ['controller' => 'UserController', 'action' => 'showsignupForm'],
    'GET|/user/register' => ['controller' => 'UserController', 'action' => 'showsignupForm'],
    'POST|/user/register' => ['controller' => 'UserController', 'action' => 'register'],
    'GET|/user/login' => ['controller' => 'UserController', 'action' => 'loginForm'],
    'POST|/user/login' => ['controller' => 'UserController', 'action' => 'login'],
    'GET|/user/logout' => ['controller' => 'UserController', 'action' => 'logout', 'middleware' => ['auth']],
    'POST|/user/updateProfile' => ['controller' => 'UserController', 'action' => 'updateProfile', 'middleware' => ['auth']],
    'POST|/user/forgotPassword' => ['controller' => 'UserController', 'action' => 'forgotPassword'],
    'GET|/user/loadUser' => ['controller' => 'UserController', 'action' => 'loadUser', 'middleware' => ['auth']],


    'GET|/user/getallanouncements' => ['controller' => 'UserController', 'action' => 'getAllAnnoucements'],
    'GET|/user/getalldrivers' => ['controller' => 'DriverController', 'action' => 'getalldrivers'],
    'GET|/user/getAllAnnoucementsCities' => ['controller' => 'UserController', 'action' => 'getAllAnnoucementsCities'],
    'GET|/user/home' => ['controller' => 'UserController', 'action' => 'servehome'],
    'GET|/user/carimage' => ['controller' => 'UserController', 'action' => 'carImage'],
    'GET|/user/vanimage' => ['controller' => 'UserController', 'action' => 'vanImage'],
    'GET|/user/truckimage' => ['controller' => 'UserController', 'action' => 'truckImage'],
    'POST|/sender/requests' => ['controller' => 'SenderController', 'action' => 'makereq', 'middleware' => ['auth', 'sender']], 
    'GET|/sender/dashboard' => ['controller' => 'SenderController', 'action' => 'dashboard', 'middleware' => ['sender']],
    'POST|/sender/changePackageStatus' => ['controller' => 'SenderController', 'action' => 'changePackageStatus', 'middleware' => ['sender']],
    'GET|/sender/maderequestes' => ['controller' => 'SenderController', 'action' => 'getallreq', 'middleware' => ['sender']],
    'GET|/user/cities' => ['controller' => 'UserController', 'action' => 'getCities'],
    'POST|/driver/createAnnouncement' => ['controller' => 'DriverController', 'action' => 'createAnnouncement', 'middleware' => ['auth', 'driver']], 
    'POST|/driver/getAllAnnouncements' => ['controller' => 'DriverController', 'action' => 'getAllAnnouncements', 'middleware' => ['auth', 'driver']], 
    'POST|/driver/createVehicle' => ['controller' => 'DriverController', 'action' => 'createVehicle', 'middleware' => ['auth', 'driver']],
    'POST|/announcements/update/{id}' => ['controller' => 'DriverController', 'action' => 'updateAnnouncement', 'middleware' => ['auth', 'driver']], 
    'POST|/announcements/delete/{id}' => ['controller' => 'DriverController', 'action' => 'deleteAnnouncement', 'middleware' => ['auth', 'driver']], 
    'GET|/vehicles' => ['controller' => 'DriverController', 'action' => 'getVehicles', 'middleware' => ['auth', 'driver']], 
    'POST|/vehicles' => ['controller' => 'DriverController', 'action' => 'createVehicle', 'middleware' => ['auth', 'driver']], 
    'POST|/api/route' => ['controller' => 'ApiController', 'action' => 'getRoute', 'middleware' => ['auth, driver']], 
    'GET|/driver/profile' => ['controller' => 'UserController', 'action' => 'loadUser', 'middleware' => ['auth', 'driver']], 
    'GET|/sender/profile' => ['controller' => 'UserController', 'action' => 'loadUser'], 


    'GET|/admin/dashboard' => ['controller' => 'AdminController', 'action' => 'dashboard', 'middleware' => ['admin']],
    'GET|/admin/profile' => ['controller' => 'UserController', 'action' => 'loadUser', 'middleware' => ['auth', 'admin']], 
    'POST|/admin/ban' => ['controller' => 'AdminController', 'action' => 'banUser', 'middleware' => ['auth', 'admin']], 
    'POST|/admin/delete' => ['controller' => 'AdminController', 'action' => 'deleteUser', 'middleware' => ['auth', 'admin']], 
    'GET|/admin/getAllUsers' => ['controller' => 'AdminController', 'action' => 'getAllUsers', 'middleware' => ['auth', 'admin']], 
    'GET|/admin/getAllAnouncments' => ['controller' => 'AdminController', 'action' => 'getAllAnnnouncements', 'middleware' => ['auth', 'admin']], 
    'GET|/admin/getAllPackages' => ['controller' => 'AdminController', 'action' => 'getAllPackages', 'middleware' => ['auth', 'admin']], 
    'GET|/admin/stats' => ['controller' => 'AdminController', 'action' => 'stats', 'middleware' => ['auth', 'admin']], 


];