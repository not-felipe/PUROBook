<?php
include '../includes/header.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Busca dados atuais do usuário
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch();

$mensagem = "";

// Processa o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $curso = $_POST['curso'] ?? null;

    // Validação simples
    if (empty($nome)) {
        $mensagem = '<div class="alert alert-error">O nome não pode ficar em branco.</div>';
    } else {
        // Lida com upload da foto de perfil
        $foto_perfil = $usuario['foto_perfil'] ?? 'default.png';
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $permitidos = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
            if (in_array($_FILES['foto_perfil']['type'], $permitidos)) {
                $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
                $novo_nome = uniqid('perfil_') . '.' . $ext;
                $destino = '../uploads/perfis/' . $novo_nome;
                if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $destino)) {
                    $foto_perfil = $novo_nome;
                } else {
                    $mensagem = '<div class="alert alert-error">Erro ao salvar a nova foto de perfil.</div>';
                }
            } else {
                $mensagem = '<div class="alert alert-error">Tipo de arquivo não permitido. Envie uma imagem PNG, JPG ou GIF.</div>';
            }
        }

        // Atualiza no banco
        if (empty($mensagem)) {
            $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, curso = ?, foto_perfil = ? WHERE id = ?");
            $stmt->execute([$nome, $curso ?: null, $foto_perfil, $_SESSION['usuario_id']]);
            $mensagem = '<div class="alert alert-success">Perfil atualizado com sucesso!</div>';

            // Atualiza nome na sessão
            $_SESSION['usuario_nome'] = $nome;

            // Atualiza dados do usuário para exibir o novo perfil
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$_SESSION['usuario_id']]);
            $usuario = $stmt->fetch();
        }
    }
}

// Define foto de perfil para exibição
$foto = !empty($usuario['foto_perfil']) ? $usuario['foto_perfil'] : 'default.png';
$caminho_foto = '../uploads/perfis/' . $foto;
if (!file_exists($caminho_foto)) {
    $caminho_foto = '../uploads/perfis/default.png';
}
?>

<div class="main-layout">
    <div class="main-content">
        <div class="container">
            <h2>Editar Perfil</h2>
            <?= $mensagem ?>

            <div style="text-align:center; margin-bottom: 24px;">
                <img src="<?= htmlspecialchars($caminho_foto) ?>" alt="Foto de perfil" style="width:120px; height:120px; border-radius:50%; object-fit:cover; border:3px solid #7c3aed;">
            </div>

            <form method="POST" enctype="multipart/form-data">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

                <label for="curso">Curso:</label>
                <select name="curso" id="curso">
                    <option value="">Selecione seu curso</option>
                    <option value="Ciencia da Computação" <?= $usuario['curso']=='Ciencia da Computação'?'selected':'' ?>>Ciência da Computação</option>
                    <option value="Engenharia de Produção" <?= $usuario['curso']=='Engenharia de Produção'?'selected':'' ?>>Engenharia de Produção</option>
                    <option value="Serviço Social" <?= $usuario['curso']=='Serviço Social'?'selected':'' ?>>Serviço Social</option>
                    <option value="Psicologia" <?= $usuario['curso']=='Psicologia'?'selected':'' ?>>Psicologia</option>
                    <option value="Enfermagem" <?= $usuario['curso']=='Enfermagem'?'selected':'' ?>>Enfermagem</option>
                    <option value="Produção Cultural" <?= $usuario['curso']=='Produção Cultural'?'selected':'' ?>>Produção Cultural</option>
                </select>

                <label for="foto_perfil">Foto de perfil:</label>
                <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*">

                <button type="submit">Salvar alterações</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>