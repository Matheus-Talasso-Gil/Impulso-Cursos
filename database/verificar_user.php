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

