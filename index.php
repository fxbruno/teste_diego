<?php
require 'config.php';

/*session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
} */

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Cadastro de Clientes</title>
</head>
<body>
    <h2>Bem-vindo!</h2>
    <a href="cadastro.php">Cadastrar Cliente</a><br>
    <a href="visualizar.php">Visualizar Clientes</a><br>  
    <a href="logout.php">Sair</a>
</body>
</html>