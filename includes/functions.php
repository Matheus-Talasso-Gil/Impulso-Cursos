<?php
require_once __DIR__ . '/../database/connect_postgres.php';
function validar_cpf($cpf)
{
    $cpf = preg_replace('/\D/', '', (string) $cpf); // remove a pontuação para validar somente os dígitos
    if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) return false; // exige 11 dígitos e rejeita números repetidos
    $soma = 0;
    for ($i = 0; $i < 9; $i++) $soma += (int) $cpf[$i] * (10 - $i); // calcula a soma usada no primeiro dígito verificador
    $resto = $soma % 11;
    $primeiro = $resto < 2 ? 0 : 11 - $resto;
    if ((int) $cpf[9] !== $primeiro) return false; // confere o primeiro dígito verificador
    $soma = 0;
    for ($i = 0; $i < 10; $i++) $soma += (int) $cpf[$i] * (11 - $i); // calcula a soma usada no segundo dígito
    $resto = $soma % 11;
    $segundo = $resto < 2 ? 0 : 11 - $resto;
    return (int) $cpf[10] === $segundo; // retorna true somente se o segundo dígito também conferir
}
function cadastrar($conexao, $nome, $turma, $nasc, $ativo, $email, $cpf)
{
    $sql = "INSERT INTO alunos (nome, turma, nasc, ativo, email, cpf) VALUES (:nome, :turma, :nasc, :ativo, :email, :cpf)"; // prepara o cadastro do aluno com todos os campos
    try {
        $stmt = $conexao->prepare($sql); // prepara a inserção para receber os valores
        $stmt->bindParam(":nome", $nome); $stmt->bindParam(":turma", $turma); // associa nome e turma
        $stmt->bindParam(":nasc", $nasc); $stmt->bindParam(":ativo", $ativo); // associa nascimento e situação
        $stmt->bindParam(":email", $email); $stmt->bindParam(":cpf", $cpf); // associa e-mail e cpf
        $stmt->execute();
        echo "Aluno inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
function listarAlunos($conexao, $turma = '', $situacao = 'todas') // aceita filtros opcionais para a listagem do relatório
{
    $sql = "SELECT * FROM alunos"; // começa buscando os registros da tabela de alunos
    $filtros = []; // guarda somente as condições solicitadas
    $parametros = []; // separa os valores da consulta para usá-los com segurança
    if ($turma !== '') {
        $filtros[] = 'turma = :turma'; // adiciona a condição de turma quando foi selecionada
        $parametros[':turma'] = $turma; // associa o código ao parâmetro preparado
    }
    if ($situacao === 'ativo') $filtros[] = 'ativo = TRUE'; // restringe a lista aos alunos ativos
    elseif ($situacao === 'inativo') $filtros[] = 'ativo = FALSE'; // restringe a lista aos alunos inativos
    if ($filtros) $sql .= ' WHERE ' . implode(' AND ', $filtros); // combina os filtros escolhidos
    $sql .= ' ORDER BY id ASC'; // mantém os resultados em ordem de cadastro
    $stmt = $conexao->prepare($sql); // prepara a consulta antes de enviá-la ao banco
    $stmt->execute($parametros); // executa usando os valores associados aos parâmetros
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function apagar($conexao)
{
    if (isset($_POST['id']) && $_POST['id'] != "") { // só exclui quando o formulário envia um id
        $sql = "DELETE FROM alunos WHERE id = :id"; // prepara a exclusão do aluno selecionado
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $_POST['id']); $stmt->execute(); // executa a exclusão usando o id recebido
        echo '<p class="message-success" role="status">Registro deletado.</p>';
    } else {
        echo '<p class="message-error" role="alert">Insira um ID para apagar.</p>';
    }
}
function Consultar($conexao, $id)
{
    $sql = "SELECT nome, nasc, turma, ativo, email, cpf
            FROM alunos
            WHERE id = :id"; // seleciona os dados do aluno com o id informado
        $stmt = $conexao->prepare($sql); // prepara a consulta antes de executá-la
        $stmt->bindParam(":id", $id); $stmt->execute(); // busca o aluno pelo id
        $aluno = $stmt->fetch(PDO::FETCH_ASSOC); // obtém o resultado como array associativo

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
            ativo = :ativo, email = :email, cpf = :cpf WHERE id = :id"; // atualiza todos os campos do aluno identificado
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id); $stmt->bindParam(":nome", $nome); // associa id e nome
        $stmt->bindParam(":turma", $turma); $stmt->bindParam(":nasc", $nasc); // associa turma e nascimento
        $stmt->bindParam(":ativo", $ativo); $stmt->bindParam(":email", $email); // associa situação e e-mail
        $stmt->bindParam(":cpf", $cpf); // associa o cpf
        $stmt->execute();
        echo '<p class="message-success" role="status">ALUNO ATUALIZADO COM SUCESSO! VOLTE AO RELATÓRIO PARA CONFERIR.</p>';
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
function read_w_w($conexao, $id)
{
    try {
        $sql = "SELECT * FROM alunos WHERE id = :id;"; // busca o cadastro pelo id usando uma consulta preparada
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id); $stmt->execute(); // executa a busca do aluno pelo id
        $aluno = $stmt->fetch(PDO::FETCH_ASSOC); // recupera os dados para exibi-los
        if ($aluno !== false) { 
            $cpfFormatado = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', (string) ($aluno['cpf'] ?? '')); // formata o cpf apenas na exibição
            echo '<h2>Dados do aluno</h2><dl class="student-details">'; // abre a lista que organiza os dados em rótulos e valores
            echo '<div><dt>ID</dt><dd>' . htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') . '</dd></div>'; // escapa os valores para não serem interpretados como html
            echo '<div><dt>Aluno</dt><dd>' . htmlspecialchars((string) $aluno['nome'], ENT_QUOTES, 'UTF-8') . '</dd></div>';
            echo '<div><dt>CPF</dt><dd>' . htmlspecialchars((string) $cpfFormatado, ENT_QUOTES, 'UTF-8') . '</dd></div>';
            echo '<div><dt>Turma</dt><dd>' . htmlspecialchars((string) $aluno['turma'], ENT_QUOTES, 'UTF-8') . '</dd></div>';
            echo '<div><dt>E-mail</dt><dd>' . htmlspecialchars((string) $aluno['email'], ENT_QUOTES, 'UTF-8') . '</dd></div>';
            echo '<div><dt>Data de nascimento</dt><dd>' . htmlspecialchars((string) $aluno['nasc'], ENT_QUOTES, 'UTF-8') . '</dd></div>';
            echo '<div><dt>Status</dt><dd><span class="student-status ' . ($aluno['ativo'] ? 'is-active' : 'is-inactive') . '">' . ($aluno['ativo'] ? 'Ativo' : 'Inativo') . '</span></dd></div>';
            echo '</dl>';
        } else {
            echo '<p class="lookup-empty" role="status">Nenhum registro encontrado.</p>'; // informa quando não há cadastro com esse id
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    echo '<a class="lookup-home-link" href="../index.php">Voltar ao início</a>'; // oferece um retorno à página inicial
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
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // gera um hash para não armazenar a senha original
    $sql = "INSERT INTO usuarios (email, senha, tipo) VALUES (:email, :senha, 'usuario')"; // força o cadastro público a criar sempre uma conta comum
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":email", $email); $stmt->bindParam(":senha", $senhaHash); // associa e-mail e senha criptografada
    $stmt->execute(); // salva o usuário no banco
}
function consultar_user($conexao, $email)
{
    $email = trim($email); // remove espaços ao redor do e-mail informado
    $sql = "SELECT id, email, senha, tipo FROM usuarios WHERE email = :email ORDER BY id DESC LIMIT 1"; // retorna o tipo da conta junto com os dados de login
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":email", $email); $stmt->execute(); // consulta o usuário pelo e-mail
    return $stmt->fetch(PDO::FETCH_ASSOC); // retorna o usuário encontrado ou false
}
