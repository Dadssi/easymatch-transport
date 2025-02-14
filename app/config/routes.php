<?php

return [
    
    'GET|/signup' => ['controller' => 'UserController', 'action' => 'showsignupForm', 'middleware' => ['guest']],
    'POST|/signup' => ['controller' => 'SignUpController', 'action' => 'registerUser', 'middleware' => ['guest']]


];