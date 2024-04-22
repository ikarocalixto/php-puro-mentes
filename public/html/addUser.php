<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Adicionar/Editar Usuário</title>
</head>
<link rel="stylesheet" href="../css/style.css">
<body>
<?php
include '../../config/config.php';
// Inclui a configuração do banco de dados

$user = ['id' => '', 'name' => '', 'email' => '', 'address' => '', 'city' => '', 'state' => ''];  // Array padrão vazio para usuário
$action = 'add';  // Ação padrão é 'adicionar'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $action = 'add'; 
   
    
    // Após processar os dados do formulário, recarregar a página
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['id'])) {
    $action = 'edit';  // Muda a ação para 'editar'
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();  // Pega os dados do usuário para preencher no formulário
    }
    $stmt->close();
}
?>

<h1><?php echo $action === 'edit' ? 'Editar' : 'Adicionar'; ?> Usuário</h1>
<form action="../../src/controllers/UserController.php" method="POST">
    Nome: <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>
    Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
    Endereço: <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required><br>
    Cidade ID: <input type="text" name="city_id" value="<?php echo isset($user['city_id']) ? htmlspecialchars($user['city_id']) : ''; ?>" required><br>
    Estado ID: <input type="text" name="state_id" value="<?php echo isset($user['state_id']) ? htmlspecialchars($user['state_id']) : ''; ?>" required><br>
    <input type="hidden" name="action" value="<?php echo htmlspecialchars($action); ?>">
    <?php if ($action === 'edit'): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
    <?php endif; ?>
    <button type="submit"><?php echo $action === 'edit' ? 'Atualizar' : 'Enviar'; ?></button>
</form>

</body>
</html>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Gerenciar Usuários</title>
</head>
<body>
    <?php
    // Função para deletar usuário
    if (isset($_GET['delete'])) {
        $userId = intval($_GET['delete']);
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    
        // Redireciona para a mesma página após a exclusão
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }

    // Filtros
    $whereClauses = [];
    if (isset($_GET['search_id']) && !empty($_GET['search_id'])) {
        $whereClauses[] = 'id = ' . intval($_GET['search_id']);
    }
    if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
        $whereClauses[] = "name LIKE '%" . $conn->real_escape_string($_GET['search_name']) . "%'";
    }
    $whereSql = $whereClauses ? " WHERE " . join(" AND ", $whereClauses) : "";

    // Buscar todos os usuários com filtro
    $query = "SELECT * FROM users" . $whereSql;
    $result = $conn->query($query);
    ?>

    <h1>Usuários Cadastrados</h1>
    
    <form method="get">
        <label for="search_id">ID do Usuário:</label>
        <input type="text" id="search_id" name="search_id">
        <label for="search_name">Nome do Usuário:</label>
        <input type="text" id="search_name" name="search_name">
        <button type="submit">Pesquisar</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Endereço</th>
                <th>Cidade ID</th>
                <th>Estado ID</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['city_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['state_id']); ?></td>
                    <td>
                        <a href="editUser.php?edit=<?php echo $row['id']; ?>">Editar</a>
                        <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja remover este usuário?');">Remover</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>


