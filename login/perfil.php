<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/verificar_user.php';
$tipoConta = ($_SESSION['tipo'] ?? 'usuario') === 'admin' ? 'Administrador' : 'Usuário';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu perfil | Impulso Cursos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="auth-page">
        <h1>Meu perfil</h1>
        <p>E-mail: <?= htmlspecialchars((string) ($_SESSION['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
        <p>Tipo de conta: <?= htmlspecialchars($tipoConta, ENT_QUOTES, 'UTF-8') ?></p>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
