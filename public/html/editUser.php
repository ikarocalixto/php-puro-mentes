<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Editar Usuário</title>
</head>
<body>
    <?php
    include '../../config/config.php';  // Inclui a configuração do banco de dados

    $user = null;
    if (isset($_GET['edit'])) {
        $userId = intval($_GET['edit']);
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
        } else {
            echo "<p>Usuário não encontrado.</p>";
            exit;
        }
        $stmt->close();
    } else {
        echo "<p>ID de usuário não especificado.</p>";
        exit;
    }

    // Lógica para processar atualização do usuário
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
        // Assegurar que todos os campos requeridos estão presentes
        if (isset($_POST['name'], $_POST['email'], $_POST['address'], $_POST['city_id'], $_POST['state_id'])) {
            $stmt = $conn->prepare("UPDATE users SET name=?, email=?, address=?, city_id=?, state_id=? WHERE id=?");
            $stmt->bind_param("sssssi", $_POST['name'], $_POST['email'], $_POST['address'], $_POST['city_id'], $_POST['state_id'], $userId);
            $stmt->execute();
            if ($stmt->error) {
                echo "Erro ao atualizar usuário: " . $stmt->error;
            } else {
                echo "Usuário atualizado com sucesso.";
                header("Location: manageUsers.php"); // Redirecionar de volta para a página de listagem
                exit;
            }
            $stmt->close();
        } else {
            echo "<p>Todos os campos são obrigatórios.</p>";
        }
    }
    ?>

    <h1>Editar Usuário</h1>
    <form action="../../src/controllers/UserController.php" method="POST">

    <!-- Adicione um campo oculto para enviar a ação 'edit' -->
    <input type="hidden" name="action" value="edit">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

    Nome: <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>
    Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
    Endereço: <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required><br>
    Cidade: <input type="text" name="city_id" value="<?php echo htmlspecialchars($user['city_id']); ?>" required><br>
    Estado: <input type="text" name="state_id" value="<?php echo htmlspecialchars($user['state_id']); ?>" required><br>
    <button type="submit" name="update">Atualizar</button>
</form>
</body>
</html>
