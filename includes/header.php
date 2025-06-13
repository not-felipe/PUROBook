<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../config/database.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUROBook</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-row">
                <div class="header-logo">
                    <h1>PUROBook</h1>
                </div>
                <div class="header-nav-user">
                    <div class="nav">
                        <a href="index.php">Home</a>
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <a href="create_post.php">Criar Post</a>
                        <?php else: ?>
                            <a href="login.php">Login</a>
                            <a href="register.php">Cadastrar</a>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($_SESSION['usuario_id'])): 
                        // Busca dados do usuário
                        $stmt = $pdo->prepare("SELECT nome, foto_perfil FROM usuarios WHERE id = ?");
                        $stmt->execute([$_SESSION['usuario_id']]);
                        $usuario = $stmt->fetch();
                        $foto = !empty($usuario['foto_perfil']) ? $usuario['foto_perfil'] : 'default.png';
                        $caminho_foto = '../uploads/perfis/' . $foto;
                        if (!file_exists($caminho_foto)) {
                            $caminho_foto = '../uploads/perfis/default.png';
                        }
                    ?>
                        <div class="user-header-menu">
                            <span class="user-header-nome"><?php echo htmlspecialchars($usuario['nome']); ?></span>
                            <img src="<?php echo htmlspecialchars($caminho_foto); ?>" alt="Foto de perfil" class="user-header-foto" id="userMenuToggle">
                            <div class="user-header-dropdown" id="userMenuDropdown">
                                <a href="editar_perfil.php">Editar perfil</a>
                                <a href="logout.php">Sair</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    <script src="../js/scripts.js"></script>
</body>