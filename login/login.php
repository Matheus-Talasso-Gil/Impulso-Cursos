<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $usuario = consultar_user($conexao, $_POST['email'] ?? '');
        if ($usuario && password_verify($_POST['senha'] ?? '', $usuario['senha'])) { // confere a senha digitada com o hash salvo
            session_regenerate_id(true);
            $_SESSION['id'] = $usuario['id'];
            header('Location: ../index.php');
            exit();
        }
        $erro = 'Usuário ou senha inválidos';
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $erro = 'Não foi possível consultar o cadastro. Tente novamente.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Impulso Cursos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<main>
    <h1>Área do funcionário</h1>
    <p>Faça login para gerenciar os alunos da Impulso Cursos.</p>
    <?php if (($_GET['cadastro'] ?? '') === 'sucesso'): ?>
        <p class="message-success" role="status">Cadastro realizado. Entre com seu e-mail e senha.</p>
    <?php endif; ?>
    <?php if ($erro !== ''): ?>
        <p class="message-error" role="alert"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" autocomplete="username" required><br><br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" autocomplete="current-password" required><br><br>
        <input type="submit" value="Entrar">
        <input type="reset" value="Limpar">
    </form>
    <p><a href="cadastrar.php">Cadastrar usuário</a></p>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
