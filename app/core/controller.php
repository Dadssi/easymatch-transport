<?php 

namespace App\Core;

trait Controller {
    public function view($name, $data = []) {
        $filename = "../app/views/" . $name . ".view.php";

        if (file_exists($filename)) {
            extract($data);
            require $filename;
        } else {
            require "../app/views/404.php";
        }
    }

    public function jsonResponse($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }
}
