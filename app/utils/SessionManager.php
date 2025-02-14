<?php

namespace app\utils;

class SessionManager
{


    public static function startSession(){
        session_start();
    }

    static public function isAuthenticated()
    {
        return isset($_SESSION['user_name']) && $_SESSION['logged_in'] === true;
    }

    static public function isAdmin(){
        return isset($_SESSION['user_name']) && $_SESSION['role'] === 'admin';
    }

    static function isConducteur(){
        return isset($_SESSION['user_name']) && $_SESSION['role'] === 'conducteur';
    }

    static function isExpediteur(){
        return isset($_SESSION['user_name']) && $_SESSION['role'] === 'expediteur';
    } 

    public static function set(string $key, $value) {
        $_SESSION[$key] = $value;
    }


// Get session value safely
public static function get(string $key) {
    return $_SESSION[$key] ?? null;
}

public static function regenerate() {
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_regenerate_id(true);
    }
}


}