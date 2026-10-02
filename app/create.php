<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificar_user.php';
require_once __DIR__ . '/../login/verificar_cpf.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- permite usar caracteres especiais e acentos na pagina -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- faz a pagina se adaptar melhor em celular -->
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- puxa o arquivo css que estiliza a pagina -->
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Matricular aluno</h1>
        <form action="" method="post"> <!-- envia os dados do formulario para a mesma pagina -->
            <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome" required>
            <!-- campo obrigatório para identificar o aluno sem ambiguidade -->
            <label for="cpf">CPF: </label>
            <input type="text" name="cpf" id="cpf" maxlength="14" placeholder="000.000.000-00" inputmode="numeric" required>
            <label for="turma">Turma: </label>
            <select name="turma" id="turma" required> <!-- cria uma lista de turmas para o usuario escolher -->
                <option value="" selected disabled>Selecione a turma</option>
                <option value="INF-01">INF-01 — Informática Básica</option>
                <option value="ING-01">ING-01 — Inglês</option>
                <option value="ADM-01">ADM-01 — Administração</option>
            </select>
            <label for="email">E-mail: </label>
            <input type="email" name="email" id="email" required>
            <label for="nasc">Nascimento: </label>
            <input type="date" name="nasc" id="nasc" required>
            <label>Ativo: </label>
            <input type="radio" name="ativo" id="ativo_sim" value="true" required>
            <label for="ativo_sim">SIM</label>
            <input type="radio" name="ativo" id="ativo_nao" value="false">
            <label for="ativo_nao">NÃO</label>
            <input type="submit" value="Cadastrar">
            <input type="reset" value="Limpar">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // so executa o cadastro quando o formulario for enviado
            $cpf = verificar_cpf($_POST['cpf'] ?? '');
            if ($cpf === false) {
                echo '<p class="message-error" role="alert">Informe um CPF válido.</p>';
            } else {
                // inclui o CPF no insert para manter o cadastro completo do aluno
                $sql = "INSERT INTO alunos  (nome, cpf, nasc, turma, ativo, email) 
                        VALUES   (:nome, :cpf, :nasc, :turma, :ativo, :email)"; // cria o comando para inserir um novo aluno
                $stmt = $conexao->prepare($sql); // prepara o comando antes de enviar para o banco
                $stmt->bindParam(":nome", $_POST['nome']); // liga os dados do formulario aos parametros do sql
                $stmt->bindParam(":cpf", $cpf); // guarda o CPF limpo no banco
                $stmt->bindParam(":nasc", $_POST['nasc']); // Associa a data de nascimento ao parâmetro SQL.
                $stmt->bindParam(":turma", $_POST['turma']); // Associa a turma selecionada ao parâmetro SQL.
                $stmt->bindParam(":ativo", $_POST['ativo']); // Associa a situação escolhida ao parâmetro SQL.
                $stmt->bindParam(":email", $_POST['email']); // Associa o e-mail informado ao parâmetro SQL.
                $stmt->execute(); // executa o cadastro no banco
                echo '<p class="message-success" role="status">Aluno cadastrado com sucesso!</p>';
            }
        }
        ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>