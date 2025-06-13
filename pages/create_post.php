<?php
include '../includes/header.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../config/database.php';
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $id_usuario = $_SESSION['usuario_id'];

    $stmt = $pdo->prepare("INSERT INTO posts (titulo, conteudo, id_usuario) VALUES (?, ?, ?)");
    $stmt->execute([$titulo, $conteudo, $id_usuario]);

    header("Location: index.php");
    exit();
}
?>

<div class="main-layout">
    <div class="main-content">
        <div class="container">
            <h2>Criar Post</h2>
            <form method="post">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>

                <label for="conteudo">Conteúdo:</label>
                <textarea id="conteudo" name="conteudo" rows="5" required></textarea>

                <button type="submit">Publicar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>