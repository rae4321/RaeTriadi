<?php
header("Access-Control-Allow-Origin: *"); // Allow all domains
header("Content-Type: application/json; charset=UTF-8");

// Include database configuration
include_once 'config/database.php';

// Include API routes
include_once 'routes/todo_routes.php';
?>
