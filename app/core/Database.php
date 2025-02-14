<?php 

namespace app\core;

use PDO;
use PDOException;


Trait Database
{
    private function connect()
    {
        $string = "pgsql:host=".DBHOST.";dbname=".DBNAME;
        try {
            $con = new PDO($string, DBUSER, DBPASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch(PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function query($query, $data = [])
    {

        $con = $this->connect();
        $stm = $con->prepare($query);

        $check = $stm->execute($data);
        if($check)
        {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if(is_array($result) && count($result))
            {
                return $result;
            }
        }
        return false;
    }

    public function get_row($query, $data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);

        $check = $stm->execute($data);
        if($check)
        {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if(is_array($result) && count($result))
            {
                return $result[0];
            }
        }

        return false;
    }

}
