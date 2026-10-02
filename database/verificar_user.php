<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit(); } // Executa somente no terminal para bloquear acesso pelo navegador.
require_once __DIR__ . '/../includes/functions.php'; // carrega as funcoes e a conexao com o banco
function conferir($condicao, $mensagem) { if (!$condicao) throw new RuntimeException($mensagem); } // Interrompe o teste quando uma condição falha.
$conexao->beginTransaction(); // começa a transacao do teste
try {
    $conexao->exec('CREATE TEMP TABLE usuarios (id SERIAL PRIMARY KEY, email VARCHAR(255), senha VARCHAR(255)) ON COMMIT DROP'); // Isola os testes sem alterar a tabela real.
    $inserir = $conexao->prepare('INSERT INTO usuarios (email, senha) VALUES (?, ?)'); // Prepara inserções de usuários de teste.
    $inserir->execute(['duplicado@gmail.com', 'antiga']); $inserir->execute(['duplicado@gmail.com', password_hash('nova', PASSWORD_DEFAULT)]); // Cria duplicatas para testar qual senha prevalece.
    $usuario = consultar_user($conexao, 'duplicado@gmail.com'); // Carrega a conta duplicada mais recente.
    conferir(password_verify('nova', $usuario['senha']), 'Deve usar o cadastro mais recente.'); conferir(!password_verify('errada', $usuario['senha']), 'Deve rejeitar senha incorreta.'); // Verifica senha correta e rejeita a incorreta.
    cadastrar_user($conexao, ' novo@gmail.com ', ' teste com espaços '); // Testa cadastro com espaços no e-mail e na senha.
    $usuario = consultar_user($conexao, ' novo@gmail.com ');
    conferir(password_verify(' teste com espaços ', $usuario['senha']), 'Cadastro deve permitir login e preservar a senha.'); // Garante que a senha original seja preservada.
    conferir(!consultar_user($conexao, 'ausente@gmail.com'), 'Usuário ausente deve ser rejeitado.'); // Verifica que uma conta inexistente não autentica.
    try {
        cadastrar_user($conexao, 'novo@gmail.com', 'outra');
        throw new RuntimeException('Não pode cadastrar e-mail duplicado.');
    } catch (InvalidArgumentException $e) {
        conferir(password_verify(' teste com espaços ', consultar_user($conexao, 'novo@gmail.com')['senha']), 'Duplicata não pode alterar a senha.'); // Confirma que a duplicata não substituiu a senha existente.
    }
    echo "OK: cadastro, login, duplicatas, senha incorreta e usuário ausente.\n";
} finally {
    $conexao->rollBack(); // Desfaz a transação e remove a tabela temporária ao final.
}
