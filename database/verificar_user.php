<?php
// Executar via CLI. A tabela temporária isola os testes dos usuários reais.
if (PHP_SAPI !== 'cli') {
    // bloqueia o acesso pelo navegador
    http_response_code(404);
    exit();
}
require_once __DIR__ . '/../includes/functions.php'; // carrega as funcoes e a conexao com o banco
function conferir($condicao, $mensagem) {
    // para o teste se algo der errado
    if (!$condicao) throw new RuntimeException($mensagem);
}
$conexao->beginTransaction(); // começa a transacao do teste
try {
    // usa uma tabela temporaria para nao mexer nos usuarios reais
    $conexao->exec('CREATE TEMP TABLE usuarios (id SERIAL PRIMARY KEY, email VARCHAR(255), senha VARCHAR(255)) ON COMMIT DROP');
    $inserir = $conexao->prepare('INSERT INTO usuarios (email, senha) VALUES (?, ?)');
    // cria dois cadastros com o mesmo email
    $inserir->execute(['duplicado@gmail.com', 'antiga']);
    $inserir->execute(['duplicado@gmail.com', password_hash('nova', PASSWORD_DEFAULT)]);
    $usuario = consultar_user($conexao, 'duplicado@gmail.com');
    // confere a senha mais nova e uma senha errada
    conferir(password_verify('nova', $usuario['senha']), 'Deve usar o cadastro mais recente.');
    conferir(!password_verify('errada', $usuario['senha']), 'Deve rejeitar senha incorreta.');
    // testa cadastro com espacos no email e na senha
    cadastrar_user($conexao, ' novo@gmail.com ', ' teste com espaços ');
    $usuario = consultar_user($conexao, ' novo@gmail.com ');
    conferir(password_verify(' teste com espaços ', $usuario['senha']), 'Cadastro deve permitir login e preservar a senha.');
    // confere um usuario que nao existe
    conferir(!consultar_user($conexao, 'ausente@gmail.com'), 'Usuário ausente deve ser rejeitado.');
    try {
        // tenta cadastrar o mesmo email de novo
        cadastrar_user($conexao, 'novo@gmail.com', 'outra');
        throw new RuntimeException('Não pode cadastrar e-mail duplicado.');
    } catch (InvalidArgumentException $e) {
        // confere se a tentativa nao trocou a senha anterior
        conferir(password_verify(' teste com espaços ', consultar_user($conexao, 'novo@gmail.com')['senha']), 'Duplicata não pode alterar a senha.');
    }
    echo "OK: cadastro, login, duplicatas, senha incorreta e usuário ausente.\n";
} finally {
    // desfaz as alteracoes do teste
    $conexao->rollBack();
}
