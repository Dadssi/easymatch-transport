<?php

return [
    
    'GET|/signup' => ['controller' => 'UserController', 'action' => 'showsignupForm', 'middleware' => ['guest']]

];