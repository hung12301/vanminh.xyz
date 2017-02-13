<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once "../app/init.php";
    $URI = trim($_SERVER['REQUEST_URI'],'/');
    $routes = new Route($URI);
?>