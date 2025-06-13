<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Login</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include '../config/database.php';
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header("Location: index.php");
            exit();
        } else {
            echo "<div class='alert alert-error'>Email ou senha incorretos.</div>";
        }
    }
    ?>
    <form method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Entrar</button>
    </form>
</div>
</body>
</html>