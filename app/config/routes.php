<!-- return [
    
    'GET|/admin/CheckAdminAuth' => ['controller' => 'Admin', 'action' => 'packages', 'middleware' => ['admin']],
    'POST|/login' => ['controller' => 'UserController', 'action' => 'login', 'middleware' => ['guest']],
    
    ] -->

<?php

    return [
    // Authentication routes
    'GET|/admin/login' => ['controller' => 'Admin', 'action' => 'login', 'middleware' => ['guest']],
    'POST|/admin/login' => ['controller' => 'Admin', 'action' => 'login', 'middleware' => ['guest']],
    'POST|/admin/logout' => ['controller' => 'Admin', 'action' => 'logout', 'middleware' => ['admin']],

    // Dashboard
    'GET|/admin' => ['controller' => 'Admin', 'action' => 'index', 'middleware' => ['admin']],
    'GET|/admin/dashboard' => ['controller' => 'Admin', 'action' => 'index', 'middleware' => ['admin']],

    // Users management
    'GET|/admin/users' => ['controller' => 'Admin', 'action' => 'users', 'middleware' => ['admin']],
    'POST|/admin/users/status/:id' => ['controller' => 'Admin', 'action' => 'updateUserStatus', 'middleware' => ['admin']],
    'POST|/admin/users/verify/:id' => ['controller' => 'Admin', 'action' => 'verifyUser', 'middleware' => ['admin']],

    // Announcements management
    'GET|/admin/announcements' => ['controller' => 'Admin', 'action' => 'announcements', 'middleware' => ['admin']],
    'POST|/admin/announcements/delete/:id' => ['controller' => 'Admin', 'action' => 'deleteAnnouncement', 'middleware' => ['admin']],

    // Packages management
    'GET|/admin/packages' => ['controller' => 'Admin', 'action' => 'packages', 'middleware' => ['admin']],

    // Logs
    'GET|/admin/logs' => ['controller' => 'Admin', 'action' => 'logs', 'middleware' => ['admin']],
];