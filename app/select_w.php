<?php
require_once __DIR__ . '/../includes/session.php'; 
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificar_user.php';
?>
<?php
require_once __DIR__ . '/../includes/functions.php';
$id = 7;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Aluno</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

<main>
    <h1>Consultar aluno</h1>
    <h2>Dados:</h2>
    <?php Consultar($conexao, $id); ?>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>