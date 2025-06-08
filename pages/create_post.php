<?php include '../includes/header.php'; ?>

<?php
// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<h2>Criar Novo Post</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $conteudo = trim($_POST['conteudo']);
    
    if (empty($titulo) || empty($conteudo)) {
        echo '<div class="alert alert-error">Título e conteúdo são obrigatórios.</div>';
    } else {
        $stmt = $pdo->prepare("INSERT INTO posts (titulo, conteudo, id_usuario) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$titulo, $conteudo, $_SESSION['usuario_id']])) {
            echo '<div class="alert alert-success">Post criado com sucesso! <a href="index.php">Ver todos os posts</a></div>';
        } else {
            echo '<div class="alert alert-error">Erro ao criar post.</div>';
        }
    }
}
?>

<form method="POST">
    <input type="text" name="titulo" placeholder="Título do post" required>
    <textarea name="conteudo" rows="10" placeholder="Conteúdo do post" required></textarea>
    <button type="submit">Publicar Post</button>
</form>

</div>
</body>
</html>