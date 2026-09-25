<?php
require_once __DIR__ . '/../database/connect_postgres.php';
function cadastrar($conexao, $nome, $turma, $nasc, $ativo, $email)
{
    $sql = "INSERT INTO alunos (nome, turma, nasc, ativo, email)   VALUES (:nome, :turma, :nasc, :ativo, :email)";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":turma", $turma);
        $stmt->bindParam(":nasc", $nasc);
        $stmt->bindParam(":ativo", $ativo);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        echo "Aluno inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
function listarAlunos($conexao)
{
    $sql = "SELECT * FROM alunos ORDER BY id ASC";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function apagar($conexao)
{
    if (isset($_POST['id']) && $_POST['id'] != "") {
        $sql = "DELETE FROM alunos WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $_POST['id']);
        $stmt->execute();
        echo "Registro deletado.";
    } else {
        echo "Insira um ID para apagar.<br>";
    }
}
function Consultar($conexao, $id)
{
    $sql = "SELECT nome, nasc, turma, ativo, email
            FROM alunos
            WHERE id = :id";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($aluno) {
        echo "Aluno: {$aluno['nome']}<br>";
        echo "Turma: {$aluno['turma']}<br>";
        echo "E-mail: {$aluno['email']}<br>";
        echo "Nasc: {$aluno['nasc']}<br>";
        echo "Ativo: " . ($aluno['ativo'] ? "SIM" : "NÃO") . "<br>";
    } else {
        echo "Aluno não encontrado.";
    }
}
function Atualizar($conexao, $id, $nome, $turma, $nasc, $ativo, $email)
{
    $sql = "UPDATE alunos SET nome = :nome, turma = :turma, nasc = :nasc,
            ativo = :ativo, email = :email WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":turma", $turma);
        $stmt->bindParam(":nasc", $nasc);
        $stmt->bindParam(":ativo", $ativo);
        $stmt->bindParam(":email", $email);

        $stmt->execute();

        echo '<p class="message-success" role="status">ALUNO ATUALIZADO COM SUCESSO! VOLTE AO RELATÓRIO PARA CONFERIR.</p>';
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
function read_w_w($conexao, $id)
{
    try {
        $sql = "SELECT * FROM alunos WHERE id = :id;";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($aluno !== false) { 
            echo "<hr>";
            echo "ID:" . $aluno['id'] . '<br>';
            echo "Aluno:" . $aluno['nome'] . '<br>';
            echo "Turma:" . $aluno['turma'] . '<br>';
            echo "Email:" . $aluno['email'] . '<br>';
            echo "Data de Nascimento:" . $aluno['nasc'] . '<br>';
            echo "Ativo:" . $aluno['ativo'];
        } else {
            echo "Nenhum registro encontrado.";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    echo '<br><a href="../index.php">Retorne aqui</a>';
}
function cadastrar_user($conexao, $email, $senha)
{
    $sql = "INSERT INTO usuarios (email, senha)   VALUES (:email, :senha)";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);

        $stmt->execute();
        echo "Usuário inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
function consultar_user($conexao, $email)
{
    $sql = "SELECT id, email, senha FROM usuarios WHERE email = :email";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        return null;
    }
}