<?php 
if($_SERVER['SERVER_NAME'] == 'localhost')
{
    /** database config **/
    define('DBNAME', 'easymatch');
    define('DBHOST', 'localhost');
    define('DBUSER', 'postgres');
    define('DBPASS', '12345');
    define('DBDRIVER', 'pgsql');
    
    define('ROOT', 'http://localhost/easymatch-transport/public');
}else
{
	/** database config **/
	define('DBNAME', 'my_db');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', 'https://www.yourwebsite.com');

}

define('APP_NAME', "My Webiste");
define('APP_DESC', "Best website on the planet");

/** true means show errors **/
define('DEBUG', true);