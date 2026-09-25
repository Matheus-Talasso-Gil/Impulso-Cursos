<?php
require_once __DIR__ . '/../includes/session.php'; 
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificar_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Matricular aluno</h1>
        <form action="" method="post">
            <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome" required><br><br>
            <label for="turma">Turma: </label>
            <select name="turma" id="turma" required>
                <option value="" selected disabled>Selecione a turma</option>
                <option value="INF-01">INF-01 — Informática Básica</option>
                <option value="ING-01">ING-01 — Inglês</option>
                <option value="ADM-01">ADM-01 — Administração</option>
            </select><br><br>
            <label for="email">E-mail: </label>
            <input type="email" name="email" id="email" required><br><br>
            <label for="nasc">Nascimento: </label>
            <input type="date" name="nasc" id="nasc" required><br><br>
            <label>Ativo: </label>
            <input type="radio" name="ativo" id="ativo_sim" value="true" required>
            <label for="ativo_sim">SIM</label>
            <input type="radio" name="ativo" id="ativo_nao" value="false">
            <label for="ativo_nao">NÃO</label><br><br>
            <input type="submit" value="Cadastrar">
            <input type="reset" value="Limpar">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once __DIR__ . '/../database/connect_postgres.php';
            $sql = "INSERT INTO alunos  (nome, nasc, turma, ativo, email) 
                    VALUES   (:nome, :nasc, :turma, :ativo, :email)";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $_POST['nome']);
            $stmt->bindParam(":nasc", $_POST['nasc']);
            $stmt->bindParam(":turma", $_POST['turma']);
            $stmt->bindParam(":ativo", $_POST['ativo']);
            $stmt->bindParam(":email", $_POST['email']);
            $stmt->execute();
            echo "Aluno cadastrado com sucesso!";
        }
        ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>