<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Cadastrar</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include '../config/database.php';
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        if (strlen($senha) < 8) {
            echo "<div class='alert alert-error'>A senha deve ter pelo menos 8 caracteres.</div>";
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $num_emails = $stmt->fetchColumn();

            if ($num_emails > 0) {
                echo "<div class='alert alert-error'>Este email já está cadastrado.</div>";
            } else {
                $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
                $stmt->execute([$nome, $email, $senha_hash]);

                echo "<div class='alert alert-success'>Cadastro realizado com sucesso! <a href='login.php'>Faça login</a>.</div>";
            }
        }
    }
    ?>
    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Cadastrar</button>
    </form>
</div>
</body>
</html>