<?php include '../includes/header.php'; ?>

<h2>Login</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    
    if (empty($email) || empty($senha)) {
        echo '<div class="alert alert-error">Email e senha são obrigatórios.</div>';
    } else {
        $stmt = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header("Location: index.php");
            exit();
        } else {
            echo '<div class="alert alert-error">Email ou senha incorretos.</div>';
        }
    }
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>

<p>Não tem uma conta? <a href="register.php">Cadastrar</a></p>

</div>
</body>
</html>