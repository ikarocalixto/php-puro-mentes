<?php
include_once '../config/config.php';
include_once '../src/routes.php';

$url = $_SERVER['REQUEST_URI'];
handleRoute($url, $conn);
