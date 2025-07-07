<?php
include '../includes/header.php';

// Obtém o ID do post da URL
$post_id = isset($_GET['id']) ? $_GET['id'] : null;

// Verifica se o ID do post é válido
if (!$post_id) {
    echo "ID do post inválido.";
    exit;
}

// Busca as informações do post
$stmt = $pdo->prepare("
    SELECT p.*, u.nome as autor_nome 
    FROM posts p
    JOIN usuarios u ON p.id_usuario = u.id
    WHERE p.id = ?
");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

// Se o post não existir, exibe uma mensagem de erro
if (!$post) {
    echo "Post não encontrado.";
    exit;
}

// Processa o formulário de comentário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['usuario_id'])) {
    $conteudo = $_POST['comentario'];
    $id_usuario = $_SESSION['usuario_id'];

    $stmt = $pdo->prepare("INSERT INTO comentarios (id_post, id_usuario, conteudo, data_criacao) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$post_id, $id_usuario, $conteudo]);

    // Recarrega a página para mostrar o novo comentário
    header("Location: post.php?id=" . $post_id);
    exit;
}

// Busca os comentários do post
$stmt = $pdo->prepare("
    SELECT c.*, u.nome as autor_nome 
    FROM comentarios c
    JOIN usuarios u ON c.id_usuario = u.id
    WHERE c.id_post = ?
    ORDER BY c.data_criacao DESC
");
$stmt->execute([$post_id]);
$comentarios = $stmt->fetchAll();
?>

<div class="main-layout">
    <div class="main-content">
        <div class="container">
            <h2><?php echo htmlspecialchars($post['titulo']); ?></h2>
            <div class="post-meta">
                Por <?php echo htmlspecialchars($post['autor_nome']); ?> em <?php echo date('d/m/Y H:i', strtotime($post['data_criacao'])); ?>
            </div>
            <p><?php echo nl2br(htmlspecialchars($post['conteudo'])); ?></p>

            <h4>Comentários:</h4>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <form method="post">
                    <label for="comentario">Deixe seu comentário:</label>
                    <textarea id="comentario" name="comentario" rows="3" required></textarea>
                    <button type="submit">Comentar</button>
                </form>
            <?php else: ?>
                <p><a href="login.php">Faça login</a> para comentar.</p>
            <?php endif; ?>

            <?php if (empty($comentarios)): ?>
                <p>Nenhum comentário ainda.</p>
            <?php else: ?>
                <?php foreach ($comentarios as $comentario): ?>
                    <div class="comment" style="position: relative;">
                        <div class="comment-meta">
                            Por <?php echo htmlspecialchars($comentario['autor_nome']); ?> em <?php echo date('d/m/Y H:i', strtotime($comentario['data_criacao'])); ?>
                            <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $comentario['id_usuario']): ?>
                                <button class="delete-btn" title="Deletar comentário" onclick="confirmDeleteComment(<?php echo $comentario['id']; ?>)" style="margin-left:8px;">🗑️</button>
                            <?php endif; ?>
                        </div>
                        <?php echo nl2br(htmlspecialchars($comentario['conteudo'])); ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal de confirmação (o mesmo do index.php, pode deixar só um por página) -->
<div id="confirmModal" class="modal" style="display:none;">
    <div class="modal-content">
        <p id="modalText">Tem certeza que deseja deletar?</p>
        <button id="confirmYes">Sim</button>
        <button id="confirmNo">Não</button>
    </div>
</div>

<script>
    let deleteType = '';
    let deleteId = '';

    function confirmDeleteComment(commentId) {
        deleteType = 'comment';
        deleteId = commentId;
        document.getElementById('modalText').innerText = 'Tem certeza que deseja deletar este comentário?';
        document.getElementById('confirmModal').style.display = 'flex';
    }

    document.getElementById('confirmYes').onclick = function() {
        if (deleteType === 'comment') {
            window.location = 'delete_comment.php?id=' + deleteId + '&post=<?php echo $post_id; ?>';
        }
    };
    document.getElementById('confirmNo').onclick = function() {
        document.getElementById('confirmModal').style.display = 'none';
    };
</script>
</body>
</html>