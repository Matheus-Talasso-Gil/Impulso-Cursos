<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificar_user.php';

function buscarAlunoPorCpf($conexao, $cpf)
{
    $cpf = preg_replace('/\D/', '', (string) ($cpf ?? ''));
    if ($cpf === '') {
        return false;
    }

    $sql = "SELECT * FROM alunos WHERE cpf = :cpf LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- permite usar caracteres especiais e acentos na pagina -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- faz a pagina se adaptar melhor em celular -->
    <title>Consultar aluno</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- puxa o arquivo css que estiliza a pagina -->
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Consultar aluno</h1>
        <section class="forms">
            <form action="" method="post"> <!-- envia os dados digitados para a mesma pagina -->
                <label for="id">ID do aluno: </label>
                <input type="number" name="id" id="id" min="1" max="255"><br><br>
                <label for="cpf">CPF do aluno: </label>
                <input type="text" name="cpf" id="cpf" maxlength="14" placeholder="000.000.000-00"><br><br>
                <input type="submit" value="Consultar">
            </form>
        </section>
        <p><a class="report-link" href="select.php">Consultas RL</a></p>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['id'])) { // busca por ID quando o campo foi preenchido
                $id = (int) $_POST['id'];
                if ($id < 255 && $id > 0) { // verifica se o id esta dentro do limite aceito
                    read_w_w($conexao, $id); // chama a funcao que busca e mostra o aluno pelo id
                } else {
                    echo "Número inválido, tente novamente <br>";
                }
            } elseif (!empty($_POST['cpf'])) { // busca por CPF quando o campo foi preenchido
                $cpf = preg_replace('/\D/', '', $_POST['cpf']);
                $aluno = buscarAlunoPorCpf($conexao, $cpf);
                if ($aluno !== false) {
                    read_w_w($conexao, $aluno['id']);
                } else {
                    echo "Nenhum aluno encontrado com esse CPF.<br>";
                }
            } else {
                echo "Informe um ID ou CPF para consultar.<br>";
            }
        }
        ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
