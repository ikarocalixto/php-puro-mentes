<?php
include_once 'controllers/UserController.php';

function handleRoute($url, $conn) {
    if (preg_match("/users\/(\d+)/", $url, $matches)) {
        $userId = $matches[1];
        getUser($userId, $conn);
    }
    // Adicione mais rotas conforme necessário
}
