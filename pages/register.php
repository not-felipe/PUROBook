<?php include '../includes/header.php'; ?>

<h2>Cadastrar</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    
    $erro = '';
    
    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif ($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem.";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        // Verificar se o email já existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $erro = "Este email já está cadastrado.";
        } else {
            // Inserir novo usuário
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            
            if ($stmt->execute([$nome, $email, $senha_hash])) {
                echo '<div class="alert alert-success">Cadastro realizado com sucesso! <a href="login.php">Fazer login</a></div>';
            } else {
                $erro = "Erro ao cadastrar usuário.";
            }
        }
    }
    
    if (!empty($erro)) {
        echo '<div class="alert alert-error">' . $erro . '</div>';
    }
}
?>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome completo" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha (mín. 6 caracteres)" required>
    <input type="password" name="confirmar_senha" placeholder="Confirmar senha" required>
    <button type="submit">Cadastrar</button>
</form>

<p>Já tem uma conta? <a href="login.php">Fazer login</a></p>

</div>
</body>
</html>