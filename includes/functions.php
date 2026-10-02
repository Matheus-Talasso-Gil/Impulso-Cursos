<?php
require_once __DIR__ . '/../database/connect_postgres.php';
function cadastrar($conexao, $nome, $turma, $nasc, $ativo, $email, $cpf)
{
    $sql = "INSERT INTO alunos (nome, turma, nasc, ativo, email, cpf) VALUES (:nome, :turma, :nasc, :ativo, :email, :cpf)";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":turma", $turma);
        $stmt->bindParam(":nasc", $nasc);
        $stmt->bindParam(":ativo", $ativo);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":cpf", $cpf);
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
        echo '<p class="message-success" role="status">Registro deletado.</p>';
    } else {
        echo '<p class="message-error" role="alert">Insira um ID para apagar.</p>';
    }
}
function Consultar($conexao, $id)
{
    $sql = "SELECT nome, nasc, turma, ativo, email, cpf
            FROM alunos
            WHERE id = :id";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($aluno) {
        echo 'Aluno: ' . htmlspecialchars((string) $aluno['nome'], ENT_QUOTES, 'UTF-8') . '<br>';
        echo 'CPF: ' . htmlspecialchars((string) $aluno['cpf'], ENT_QUOTES, 'UTF-8') . '<br>';
        echo 'Turma: ' . htmlspecialchars((string) $aluno['turma'], ENT_QUOTES, 'UTF-8') . '<br>';
        echo 'E-mail: ' . htmlspecialchars((string) $aluno['email'], ENT_QUOTES, 'UTF-8') . '<br>';
        echo 'Nasc: ' . htmlspecialchars((string) $aluno['nasc'], ENT_QUOTES, 'UTF-8') . '<br>';
        echo "Ativo: " . ($aluno['ativo'] ? "SIM" : "NÃO") . "<br>";
    } else {
        echo "Aluno não encontrado.";
    }
}
// atualiza os dados do aluno, incluindo o CPF no banco
function Atualizar($conexao, $id, $nome, $turma, $nasc, $ativo, $email, $cpf)
{
    $sql = "UPDATE alunos SET nome = :nome, turma = :turma, nasc = :nasc,
            ativo = :ativo, email = :email, cpf = :cpf WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":turma", $turma);
        $stmt->bindParam(":nasc", $nasc);
        $stmt->bindParam(":ativo", $ativo);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":cpf", $cpf);

        $stmt->execute();

        echo '<p class="message-success" role="status">ALUNO ATUALIZADO COM SUCESSO! VOLTE AO RELATÓRIO PARA CONFERIR.</p>';
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
function read_w_w($conexao, $id)
{
    try {
        $sql = "SELECT * FROM alunos WHERE id = :id;"; // Busca o cadastro pelo ID usando uma consulta preparada.
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($aluno !== false) { 
            $cpfFormatado = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', (string) ($aluno['cpf'] ?? '')); // Formata o CPF apenas na exibição.
            echo '<h2>Dados do aluno</h2><dl class="student-details">'; // Abre a lista que organiza os dados em rótulos e valores.
            echo '<div><dt>ID</dt><dd>' . htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') . '</dd></div>'; // Escapa os valores para não serem interpretados como HTML.
            echo '<div><dt>Aluno</dt><dd>' . htmlspecialchars((string) $aluno['nome'], ENT_QUOTES, 'UTF-8') . '</dd></div>';
            echo '<div><dt>CPF</dt><dd>' . htmlspecialchars((string) $cpfFormatado, ENT_QUOTES, 'UTF-8') . '</dd></div>';
            echo '<div><dt>Turma</dt><dd>' . htmlspecialchars((string) $aluno['turma'], ENT_QUOTES, 'UTF-8') . '</dd></div>';
            echo '<div><dt>E-mail</dt><dd>' . htmlspecialchars((string) $aluno['email'], ENT_QUOTES, 'UTF-8') . '</dd></div>';
            echo '<div><dt>Data de nascimento</dt><dd>' . htmlspecialchars((string) $aluno['nasc'], ENT_QUOTES, 'UTF-8') . '</dd></div>';
            echo '<div><dt>Status</dt><dd><span class="student-status ' . ($aluno['ativo'] ? 'is-active' : 'is-inactive') . '">' . ($aluno['ativo'] ? 'Ativo' : 'Inativo') . '</span></dd></div>';
            echo '</dl>';
        } else {
            echo '<p class="lookup-empty" role="status">Nenhum registro encontrado.</p>'; // Informa quando não há cadastro com esse ID.
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    echo '<a class="lookup-home-link" href="../index.php">Voltar ao início</a>'; // Oferece um retorno à página inicial.
}
function cadastrar_user($conexao, $email, $senha)
{
    $email = trim($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $senha === '') {
        throw new InvalidArgumentException('Informe um e-mail válido e uma senha.');
    }
    if (consultar_user($conexao, $email)) {
        throw new InvalidArgumentException('Este e-mail já está cadastrado. Faça login com a senha do cadastro mais recente.');
    }
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // gera o hash para não salvar a senha original
    $sql = "INSERT INTO usuarios (email, senha)   VALUES (:email, :senha)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":senha", $senhaHash);

    $stmt->execute();
}
function consultar_user($conexao, $email)
{
    $email = trim($email);
    // Há cadastros antigos duplicados: usa a senha do cadastro mais recente.
    $sql = "SELECT id, email, senha FROM usuarios WHERE email = :email ORDER BY id DESC LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    return $usuario;
}
