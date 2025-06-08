<?php
session_start();
include '../config/database.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUROBook</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PUROBook</h1>
            <p>A rede social que une os estudantes da UFF.</p>
            <div class="nav">
                <a href="index.php">Home</a>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="create_post.php">Criar Post</a>
                    <a href="logout.php">Sair (<?php echo $_SESSION['usuario_nome']; ?>)</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Cadastrar</a>
                <?php endif; ?>
            </div>
        </div>