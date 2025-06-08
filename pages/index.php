<?php include '../includes/header.php'; ?>

<h2>Todos os Posts</h2>

<?php
// Buscar todos os posts com informações do autor
$stmt = $pdo->query("
    SELECT p.*, u.nome as autor_nome 
    FROM posts p 
    JOIN usuarios u ON p.id_usuario = u.id 
    ORDER BY p.data_criacao DESC
");
$posts = $stmt->fetchAll();
?>

<?php if (empty($posts)): ?>
    <p>Nenhum post encontrado. <a href="create_post.php">Criar o primeiro post</a></p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <h3><a href="post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['titulo']); ?></a></h3>
            <div class="post-meta">
                Por <?php echo htmlspecialchars($post['autor_nome']); ?> em <?php echo date('d/m/Y H:i', strtotime($post['data_criacao'])); ?>
            </div>
            <p><?php echo nl2br(htmlspecialchars(substr($post['conteudo'], 0, 200))); ?>...</p>
            <a href="post.php?id=<?php echo $post['id']; ?>">Ler mais</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</div>
</body>
</html>