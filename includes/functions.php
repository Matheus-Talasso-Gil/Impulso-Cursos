<?php
require_once __DIR__ . '/../database/connect_postgres.php';
function cadastrar($conexao, $nome, $turma, $nasc, $ativo, $email, $cpf)
{
    $sql = "INSERT INTO alunos (nome, turma, nasc, ativo, email, cpf) VALUES (:nome, :turma, :nasc, :ativo, :email, :cpf)"; // Prepara o cadastro do aluno com todos os campos.
    try {
        $stmt = $conexao->prepare($sql); // Prepara a inserção para receber os valores.
        $stmt->bindParam(":nome", $nome); $stmt->bindParam(":turma", $turma); // Associa nome e turma.
        $stmt->bindParam(":nasc", $nasc); $stmt->bindParam(":ativo", $ativo); // Associa nascimento e situação.
        $stmt->bindParam(":email", $email); $stmt->bindParam(":cpf", $cpf); // Associa e-mail e CPF.
        $stmt->execute();
        echo "Aluno inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
function listarAlunos($conexao, $turma = '', $situacao = 'todas') // Aceita filtros opcionais para a listagem do relatório.
{
    $sql = "SELECT * FROM alunos"; // Começa buscando os registros da tabela de alunos.
    $filtros = []; // Guarda somente as condições solicitadas.
    $parametros = []; // Separa os valores da consulta para usá-los com segurança.
    if ($turma !== '') {
        $filtros[] = 'turma = :turma'; // Adiciona a condição de turma quando foi selecionada.
        $parametros[':turma'] = $turma; // Associa o código ao parâmetro preparado.
    }
    if ($situacao === 'ativo') $filtros[] = 'ativo = TRUE'; // Restringe a lista aos alunos ativos.
    elseif ($situacao === 'inativo') $filtros[] = 'ativo = FALSE'; // Restringe a lista aos alunos inativos.
    if ($filtros) $sql .= ' WHERE ' . implode(' AND ', $filtros); // Combina os filtros escolhidos.
    $sql .= ' ORDER BY id ASC'; // Mantém os resultados em ordem de cadastro.
    $stmt = $conexao->prepare($sql); // Prepara a consulta antes de enviá-la ao banco.
    $stmt->execute($parametros); // Executa usando os valores associados aos parâmetros.
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function apagar($conexao)
{
    if (isset($_POST['id']) && $_POST['id'] != "") { // Só exclui quando o formulário envia um ID.
        $sql = "DELETE FROM alunos WHERE id = :id"; // Prepara a exclusão do aluno selecionado.
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $_POST['id']); $stmt->execute(); // Executa a exclusão usando o ID recebido.
        echo '<p class="message-success" role="status">Registro deletado.</p>';
    } else {
        echo '<p class="message-error" role="alert">Insira um ID para apagar.</p>';
    }
}
function Consultar($conexao, $id)
{
    $sql = "SELECT nome, nasc, turma, ativo, email, cpf
            FROM alunos
        WHERE id = :id"; // Seleciona os dados do aluno com o ID informado.
    $stmt = $conexao->prepare($sql); // Prepara a consulta antes de executá-la.
    $stmt->bindParam(":id", $id); $stmt->execute(); // Busca o aluno pelo ID.
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC); // Obtém o resultado como array associativo.

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
function Atualizar($conexao, $id, $nome, $turma, $nasc, $ativo, $email, $cpf)
{
    $sql = "UPDATE alunos SET nome = :nome, turma = :turma, nasc = :nasc,
            ativo = :ativo, email = :email, cpf = :cpf WHERE id = :id"; // Atualiza todos os campos do aluno identificado.
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id); $stmt->bindParam(":nome", $nome); // Associa ID e nome.
        $stmt->bindParam(":turma", $turma); $stmt->bindParam(":nasc", $nasc); // Associa turma e nascimento.
        $stmt->bindParam(":ativo", $ativo); $stmt->bindParam(":email", $email); // Associa situação e e-mail.
        $stmt->bindParam(":cpf", $cpf); // Associa o CPF.
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
        $stmt->bindParam(":id", $id); $stmt->execute(); // Executa a busca do aluno pelo ID.
        $aluno = $stmt->fetch(PDO::FETCH_ASSOC); // Recupera os dados para exibi-los.
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
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Gera um hash para não armazenar a senha original.
    $sql = "INSERT INTO usuarios (email, senha)   VALUES (:email, :senha)"; // Cria o comando para inserir o usuário.
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":email", $email); $stmt->bindParam(":senha", $senhaHash); // Associa e-mail e senha criptografada.
    $stmt->execute(); // Salva o usuário no banco.
}
function consultar_user($conexao, $email)
{
    $email = trim($email); // Remove espaços ao redor do e-mail informado.
    $sql = "SELECT id, email, senha FROM usuarios WHERE email = :email ORDER BY id DESC LIMIT 1"; // Prefere o cadastro mais recente se houver duplicatas antigas.
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":email", $email); $stmt->execute(); // Consulta o usuário pelo e-mail.
    return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna o usuário encontrado ou false.
}
