<?php
require 'config.php';

// Verifique se o ID do cliente a ser excluído foi fornecido na URL
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Preparar e executar a instrução SQL de exclusão
    $stmt = $mysql->prepare('DELETE FROM clientes WHERE id = ?');
    $stmt->bind_param('i', $delete_id);

    if ($stmt->execute()) {
        echo "Cliente excluído com sucesso!";
    } else {
        echo "Erro ao excluir cliente: " . $stmt->error;
    }

    // Fechar a declaração
    $stmt->close();
}

// Verifique se o ID do cliente a ser editado foi fornecido na URL
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    // Verifique se o formulário de edição foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtenha os dados enviados pelo formulário
        $nome = $_POST['nome'];
        $idade = $_POST['idade'];
        $cidade = $_POST['cidade'];

        // Valide os dados (pode adicionar outras validações conforme necessário)
        if (empty($nome) || empty($idade) || empty($cidade)) {
            $error = "Todos os campos são obrigatórios!";
        } else {
            // Preparar e executar a instrução SQL de atualização
            $stmt = $mysql->prepare('UPDATE clientes SET nome = ?, idade = ?, cidade = ? WHERE id = ?');
            $stmt->bind_param('sisi', $nome, $idade, $cidade, $edit_id);

            if ($stmt->execute()) {
                echo "Dados do cliente atualizados com sucesso!";
            } else {
                echo "Erro ao atualizar dados do cliente: " . $stmt->error;
            }

            // Fechar a declaração
            $stmt->close();
        }
    }

    // Consultar o cliente a ser editado
    $stmt = $mysql->prepare('SELECT * FROM clientes WHERE id = ?');
    $stmt->bind_param('i', $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();

    // Fechar a declaração
    $stmt->close();
}

// Execute a consulta SQL para buscar todos os clientes
$sql = "SELECT * FROM clientes";
$result = $mysql->query($sql);

// Verifique se há resultados
if ($result->num_rows > 0) {
    // Exiba os clientes em uma tabela
    echo "<h2>Clientes Cadastrados</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Nome</th><th>Idade</th><th>Cidade</th><th>Ação</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . $row['idade'] . "</td>";
        echo "<td>" . $row['cidade'] . "</td>";
        echo "<td><a href=\"?edit_id=" . $row['id'] . "\">Editar</a> | <a href=\"?delete_id=" . $row['id'] . "\" onclick=\"return confirm('Tem certeza de que deseja excluir este cliente?')\">Excluir</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nenhum cliente cadastrado.";
}

// Feche a conexão com o banco de dados
$mysql->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Visualizar Clientes</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <br>
    <a href="index.php">Voltar</a>

    <?php if (isset($edit_id)) : ?>
    <h2>Editar Cliente</h2>
    <form method="POST" action="?edit_id=<?php echo $edit_id; ?>">
        <input type="text" name="nome" name="Nome" value="<?php echo isset($cliente['nome']) ? $cliente['nome'] : ''; ?>"><br>
        <input type="text" name="idade" name="Idade" value="<?php echo isset($cliente['idade']) ? $cliente['idade'] : ''; ?>"><br>
        <input type="text" name="cidade" name="Cidade" value="<?php echo isset($cliente['cidade']) ? $cliente['cidade'] : ''; ?>"><br>
        <input type="submit" value="Salvar">
    </form>
<?php endif; ?>

</body>
</html>
