<?php include '../includes/header.php'; ?>

<?php
$id_post = $_GET['id'] ?? 0;

// Buscar o post
$stmt = $pdo->prepare("
    SELECT p.*, u.nome as autor_nome 
    FROM posts p 
    JOIN usuarios u ON p.id_usuario = u.id 
    WHERE p.id = ?
");
$stmt->execute([$id_post]);
$post = $stmt->fetch();

if (!$post) {
    echo '<div class="alert alert-error">Post não encontrado.</div>';
    echo '</div></body></html>';
    exit();
}

// Processar novo comentário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['usuario_id'])) {
    $conteudo = trim($_POST['conteudo']);
    
    if (!empty($conteudo)) {
        $stmt = $pdo->prepare("INSERT INTO comentarios (id_post, id_usuario, conteudo) VALUES (?, ?, ?)");
        if ($stmt->execute([$id_post, $_SESSION['usuario_id'], $conteudo])) {
            header("Location: post.php?id=" . $id_post);
            exit();
        }
    }
}

// Buscar comentários
$stmt = $pdo->prepare("
    SELECT c.*, u.nome as autor_nome 
    FROM comentarios c 
    JOIN usuarios u ON c.id_usuario = u.id 
    WHERE c.id_post = ? 
    ORDER BY c.data_criacao ASC
");
$stmt->execute([$id_post]);
$comentarios = $stmt->fetchAll();
?>

<div class="post">
    <h2><?php echo htmlspecialchars($post['titulo']); ?></h2>
    <div class="post-meta">
        Por <?php echo htmlspecialchars($post['autor_nome']); ?> em <?php echo date('d/m/Y H:i', strtotime($post['data_criacao'])); ?>
    </div>
    <div style="margin-top: 20px;">
        <?php echo nl2br(htmlspecialchars($post['conteudo'])); ?>
    </div>
</div>

<h3>Comentários (<?php echo count($comentarios); ?>)</h3>

<?php if (empty($comentarios)): ?>
    <p>Nenhum comentário ainda.</p>
<?php else: ?>
    <?php foreach ($comentarios as $comentario): ?>
        <div class="comment">
            <div class="comment-meta">
                <?php echo htmlspecialchars($comentario['autor_nome']); ?> - <?php echo date('d/m/Y H:i', strtotime($comentario['data_criacao'])); ?>
            </div>
            <div><?php echo nl2br(htmlspecialchars($comentario['conteudo'])); ?></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($_SESSION['usuario_id'])): ?>
    <h4>Adicionar Comentário</h4>
    <form method="POST">
        <textarea name="conteudo" rows="4" placeholder="Escreva seu comentário..." required></textarea>
        <button type="submit">Comentar</button>
    </form>
<?php else: ?>
    <p><a href="login.php">Faça login</a> para comentar.</p>
<?php endif; ?>

</div>
</body>
</html>