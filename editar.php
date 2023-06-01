<?php
require 'config.php';

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
                header('Location: visualizar.php');
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

// Feche a conexão com o banco de dados
$mysql->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente</title>
</head>
<body>
    <h2>Editar Cliente</h2>

    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="editar.php?edit_id=<?php echo $edit_id; ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $cliente['nome']; ?>"><br>

        <label for="idade">Idade:</label>
        <input type="text" id="idade" name="idade" value="<?php echo $cliente['idade']; ?>"><br>

        <label for="cidade">Cidade:</label>
        <input type="text" id="cidade" name="cidade" value="<?php echo $cliente['cidade']; ?>"><br>

        <input type="submit" value="Salvar">
    </form>
</body>
</html>
