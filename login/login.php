<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // só verifica as credenciais após o envio do formulário
    try {
        $usuario = consultar_user($conexao, $_POST['email'] ?? ''); // procura a conta pelo e-mail enviado
        if ($usuario && password_verify($_POST['senha'] ?? '', $usuario['senha'])) { // compara a senha digitada com o hash salvo
            session_regenerate_id(true); // evita reutilizar o identificador antigo da sessão
            $_SESSION['id'] = $usuario['id']; // marca o funcionário como autenticado
            header('Location: ../index.php'); exit(); // abre a página inicial após o login
        }
        $erro = 'Usuário ou senha inválidos';
    } catch (PDOException $e) {
        error_log($e->getMessage()); // registra o detalhe técnico sem exibi-lo ao usuário
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
<main class="auth-page">
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
        <input type="email" name="email" id="email" autocomplete="username" required>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" autocomplete="current-password" required>
        <input type="submit" value="Entrar">
        <input type="reset" value="Limpar">
    </form>
    <p><a href="cadastrar.php">Cadastrar usuário</a></p>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
