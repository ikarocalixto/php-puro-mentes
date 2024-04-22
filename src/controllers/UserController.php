<?php

include '../../config/config.php';

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add':
        addUser($conn);
        break;
    case 'edit':
        editUser($conn);
        break;
    case 'delete':
        deleteUser($conn);
        break;
    default:
        echo "Adicionado com sucesso";
}

function addUser($conn) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city_id = $_POST['city_id']; // Supondo que você tenha modificado o formulário para enviar IDs
    $state_id = $_POST['state_id'];

    $query = "INSERT INTO users (name, email, address, city_id, state_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param("sssss", $name, $email, $address, $city_id, $state_id);
    $stmt->execute();

    if ($stmt->error) {
        echo "Erro: " . $stmt->error;
    } else {
        echo "Usuário adicionado com sucesso.";
        // Redireciona para a mesma página após adicionar o usuário
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }
    $stmt->close();
}


function editUser($conn) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city_id = $_POST['city_id'];
    $state_id = $_POST['state_id'];

    $query = "UPDATE users SET name=?, email=?, address=?, city_id=?, state_id=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $name, $email, $address, $city_id, $state_id, $id);
    $stmt->execute();

    if ($stmt->error) {
        echo "Erro: " . $stmt->error;
    } else {
        // Mensagem temporária que será exibida na próxima página
        $_SESSION['message'] = "Usuário atualizado com sucesso.";
        // Redireciona para addUser.php
        header("Location: /teste/api/public/HTML/addUser.php");
        exit;
    }
    $stmt->close();
}


function deleteUser($conn) {
    $id = $_POST['id'];
    $query = "DELETE FROM users WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->error) {
        echo "Erro: " . $stmt->error;
    } else {
        echo "Usuário removido com sucesso.";
    }
    $stmt->close();
}
