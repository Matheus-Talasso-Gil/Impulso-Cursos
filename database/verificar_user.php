<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit(); } // executa somente no terminal para bloquear acesso pelo navegador
require_once __DIR__ . '/../includes/functions.php'; // carrega as funcoes e a conexao com o banco
function conferir($condicao, $mensagem) { if (!$condicao) throw new RuntimeException($mensagem); } // interrompe o teste quando uma condição falha
$conexao->beginTransaction(); // começa a transacao do teste
try {
    $conexao->exec('CREATE TEMP TABLE usuarios (id SERIAL PRIMARY KEY, email VARCHAR(255), senha VARCHAR(255)) ON COMMIT DROP'); // isola os testes sem alterar a tabela real
    $inserir = $conexao->prepare('INSERT INTO usuarios (email, senha) VALUES (?, ?)'); // prepara inserções de usuários de teste
    $inserir->execute(['duplicado@gmail.com', 'antiga']); $inserir->execute(['duplicado@gmail.com', password_hash('nova', PASSWORD_DEFAULT)]); // cria duplicatas para testar qual senha prevalece
    $usuario = consultar_user($conexao, 'duplicado@gmail.com'); // carrega a conta duplicada mais recente
    conferir(password_verify('nova', $usuario['senha']), 'Deve usar o cadastro mais recente.'); conferir(!password_verify('errada', $usuario['senha']), 'Deve rejeitar senha incorreta.'); // verifica senha correta e rejeita a incorreta
    cadastrar_user($conexao, ' novo@gmail.com ', ' teste com espaços '); // testa cadastro com espaços no e-mail e na senha
    $usuario = consultar_user($conexao, ' novo@gmail.com ');
    conferir(password_verify(' teste com espaços ', $usuario['senha']), 'Cadastro deve permitir login e preservar a senha.'); // garante que a senha original seja preservada
    conferir(!consultar_user($conexao, 'ausente@gmail.com'), 'Usuário ausente deve ser rejeitado.'); // verifica que uma conta inexistente não autentica
    try {
        cadastrar_user($conexao, 'novo@gmail.com', 'outra');
        throw new RuntimeException('Não pode cadastrar e-mail duplicado.');
    } catch (InvalidArgumentException $e) {
        conferir(password_verify(' teste com espaços ', consultar_user($conexao, 'novo@gmail.com')['senha']), 'Duplicata não pode alterar a senha.'); // confirma que a duplicata não substituiu a senha existente
    }
    echo "OK: cadastro, login, duplicatas, senha incorreta e usuário ausente.\n";
} finally {
    $conexao->rollBack(); // desfaz a transação e remove a tabela temporária ao final
}
