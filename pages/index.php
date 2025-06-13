<?php 
include '../config/database.php';
session_start();

// Se usuário não estiver logado, mostrar landing page
if (!isset($_SESSION['usuario_id'])) {
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUROBook - UFF Rio das Ostras</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Navbar para usuários não logados -->
    <nav style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 2rem; background: #7c3aed; color: white;">
        <div style="font-weight: bold; font-size: 1.5rem;">
            PUROBook
        </div>
        <div>
            <a href="register.php" style="color: white; margin-right: 1rem; text-decoration: none; padding: 0.5rem 1rem; border: 1px solid white; border-radius: 4px;">Cadastrar</a>
            <a href="login.php" style="color: white; text-decoration: none; padding: 0.5rem 1rem; background: white; color: #7c3aed; border-radius: 4px;">Login</a>
        </div>
    </nav>

    <!-- Landing Page Section -->
    <section class="landing-section" style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 80vh; text-align: center; padding: 2rem;">
        <h1 style="color: #7c3aed; font-size: 3rem; margin-bottom: 1rem;">Bem-vindo ao PUROBook</h1>
        <p style="font-size: 1.3rem; color: #666; max-width: 600px; margin-bottom: 2rem;">
            A rede social exclusiva para universitários da UFF de Rio das Ostras.<br>
            Conecte-se com seus colegas, compartilhe experiências e faça parte da nossa comunidade acadêmica!
        </p>
        <div style="display: flex; gap: 1rem;">
            <a href="register.php" style="background: #7c3aed; color: white; padding: 1rem 2rem; text-decoration: none; border-radius: 8px; font-size: 1.1rem;">Criar Conta</a>
            <a href="login.php" style="border: 2px solid #7c3aed; color: #7c3aed; padding: 1rem 2rem; text-decoration: none; border-radius: 8px; font-size: 1.1rem;">Já tenho conta</a>
        </div>
    </section>
</body>
</html>
<?php
    exit();
}

// Se usuário estiver logado, mostrar o feed normal
include '../includes/header.php';
?>

<div class="main-layout">
    <div class="main-content">
        <div class="container">
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
    </div>
</div>
</body>
</html>