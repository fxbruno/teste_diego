
<?php
require 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="Usuário"><br>
        <input type="password" name="password" placeholder="Senha"><br>
        <input type="submit" value="Entrar">
    </form>
</body>
</html>
<?php
$usuario = $_POST['username'];
$senha = $_POST['password'];

if ($usuario === 'batata' && $senha === 'batata') {
   
    session_start();
    $_SESSION['authenticated'] === true;
    header("Location: http://localhost/site/index.php");
    exit; 
} else {
    
    echo "Usuário ou senha incorretos!";
}


/*
$sql = "CREATE TABLE IF NOT EXISTS clientes (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    idade INT(3) NOT NULL,
    cidade VARCHAR(50) NOT NULL
)";
*/