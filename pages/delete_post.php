<?php
include '../includes/header.php';
global $pdo;

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$post_id = $_GET['id'];

// Verifica se o post é do usuário
$stmt = $pdo->prepare("SELECT id_usuario FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post || $post['id_usuario'] != $_SESSION['usuario_id']) {
    header('Location: index.php');
    exit;
}

// Deleta comentários do post
$stmt = $pdo->prepare("DELETE FROM comentarios WHERE id_post = ?");
$stmt->execute([$post_id]);

// Deleta o post
$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$post_id]);

header('Location: index.php');
exit;
?>