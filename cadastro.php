
<?php
require 'config.php';

$conn = new mysqli('localhost', 'root', '', 'teste_php');
// Verifique se o usuário está logado, caso contrário, redirecione para a página de login
/*session_start();
if (!isset($_SESSION['authenticated'])) {
    header('Location: login.php');
    exit;
} 
*/

// Verifique se o formulário de cadastro foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {




    // Recupere os dados do formulário
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $cidade = $_POST['cidade'];

    // Verifique se a idade é um número entre 0 e 130
    if (!is_numeric($idade) || $idade < 0 || $idade > 130) {
        echo "A idade deve ser um número entre 0 e 130.";
        exit;
    }

    // Prepare e execute a instrução SQL de inserção
    $stmt = $conn->prepare("INSERT INTO clientes (nome, idade, cidade) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nome, $idade, $cidade);
    $stmt->execute();

    
    

    // Feche a conexão com o banco de dados
    $stmt->close();
    $conn->close();

    // Redirecione para a página de visualização dos clientes após o cadastro
    header('Location: visualizar.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Cliente</title>
</head>
<body>
    <h2>Cadastro de Cliente</h2>
    <form method="POST" action="cadastro.php">
        <label>Nome:</label>
        <input type="text" name="nome" required><br><br>
        <label>Idade:</label>
        <input type="number" name="idade" min="0" max="130" required><br><br>
        <label>Cidade:</label>
        <input type="text" name="cidade" required><br><br>
        <input type="submit" value="Cadastrar">
    </form>
    <br>
    <a href="index.php">Voltar</a>
</body>
</html>

