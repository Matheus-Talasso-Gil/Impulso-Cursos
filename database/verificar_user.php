<?php
// Executar via CLI. A tabela temporária isola os testes dos usuários reais.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit();
}
require_once __DIR__ . '/../includes/functions.php';
function conferir($condicao, $mensagem) {
    if (!$condicao) throw new RuntimeException($mensagem);
}
$conexao->beginTransaction();
try {
    $conexao->exec('CREATE TEMP TABLE usuarios (id SERIAL PRIMARY KEY, email VARCHAR(255), senha VARCHAR(255)) ON COMMIT DROP');
    $inserir = $conexao->prepare('INSERT INTO usuarios (email, senha) VALUES (?, ?)');
    $inserir->execute(['duplicado@example.com', 'antiga']);
    $inserir->execute(['duplicado@example.com', password_hash('nova', PASSWORD_DEFAULT)]);
    $usuario = consultar_user($conexao, 'duplicado@example.com');
    conferir(password_verify('nova', $usuario['senha']), 'Deve usar o cadastro mais recente.');
    conferir(!password_verify('errada', $usuario['senha']), 'Deve rejeitar senha incorreta.');
    cadastrar_user($conexao, ' novo@example.com ', ' teste com espaços ');
    $usuario = consultar_user($conexao, ' novo@example.com ');
    conferir(password_verify(' teste com espaços ', $usuario['senha']), 'Cadastro deve permitir login e preservar a senha.');
    conferir(!consultar_user($conexao, 'ausente@example.com'), 'Usuário ausente deve ser rejeitado.');
    try {
        cadastrar_user($conexao, 'novo@example.com', 'outra');
        throw new RuntimeException('Não pode cadastrar e-mail duplicado.');
    } catch (InvalidArgumentException $e) {
        conferir(password_verify(' teste com espaços ', consultar_user($conexao, 'novo@example.com')['senha']), 'Duplicata não pode alterar a senha.');
    }
    echo "OK: cadastro, login, duplicatas, senha incorreta e usuário ausente.\n";
} finally {
    $conexao->rollBack();
}
