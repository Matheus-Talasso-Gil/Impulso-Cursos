<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../login/verificar_admin.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração | Impulso Cursos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Administração</h1>
        <p>Gerencie os cadastros de alunos.</p>
        <p><a class="report-link" href="create.php">Cadastrar aluno</a></p>
        <p><a class="report-link" href="select.php">Relatório de alunos</a></p>
        <p><a class="report-link" href="select_w_w.php">Consultar aluno</a></p>
        <p><a class="report-link" href="delete.php">Excluir aluno</a></p>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
