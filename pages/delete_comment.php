<?php
include '../includes/header.php';
global $pdo;

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id']) || !isset($_GET['post'])) {
    header('Location: index.php');
    exit;
}

$comment_id = $_GET['id'];
$post_id = $_GET['post'];

// Verifica se o comentário é do usuário
$stmt = $pdo->prepare("SELECT id_usuario FROM comentarios WHERE id = ?");
$stmt->execute([$comment_id]);
$comentario = $stmt->fetch();

if (!$comentario || $comentario['id_usuario'] != $_SESSION['usuario_id']) {
    header('Location: post.php?id=' . $post_id);
    exit;
}

// Deleta o comentário
$stmt = $pdo->prepare("DELETE FROM comentarios WHERE id = ?");
$stmt->execute([$comment_id]);

header('Location: post.php?id=' . $post_id);
exit;
?>