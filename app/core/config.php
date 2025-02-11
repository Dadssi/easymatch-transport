<?php
if($_SERVER['SERVER_NAME'] == 'localhost'){

    /** DATABASE CONFIG **/
    define('DBNAME', 'easymatch');
    define('DBHOST', 'localhost');
    define('DBUSER', 'postgres');
    define('DBPASSWORD', '12345');
    define('DBDRIVER', 'PostgreSQL');

    define('ROOT', 'http://localhost/easymatch-transport/public');
}else {
     /** DATABASE CONFIG **/
     define('DBNAME', '');
     define('DBHOST', '');
     define('DBUSER', '');
     define('DBPASSWORD', '');
     define('DBDRIVER', '');

    define('ROOT', 'https://www.yourwebsite.com');
}