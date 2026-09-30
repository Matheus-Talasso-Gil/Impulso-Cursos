# Dicionário de dados

## Alunos

Guarda os dados dos alunos cadastrados.

| Campo | Tipo | Chave | Aceita nulo? | Descrição |
| --- | --- | --- | --- | --- |
| id | SERIAL | PK | Não | Identificador do aluno, gerado automaticamente. |
| nome | VARCHAR(60) | — | Não | Nome do aluno, com até 60 caracteres. |
| nasc | DATE | — | Sim | Data de nascimento do aluno. |
| turma | VARCHAR(50) | — | Sim | Código da turma, como INF-01, ING-01 ou ADM-01. |
| ativo | BOOLEAN | — | Sim | Indica se o aluno está ativo: true ou false. |
| email | VARCHAR(100) | — | Sim | E-mail do aluno, com até 100 caracteres. |

- Base: [TABEL_alunos.sql](app/TABEL_alunos.sql).
- A coluna "Aceita nulo?" segue as regras definidas no banco.
- Os formulários podem exigir campos mesmo quando o banco permite valor nulo.
- O campo `turma` é armazenado como texto e não possui chave estrangeira.

## Usuários

Guarda as contas usadas para entrar no sistema.

| Campo | Tipo | Chave | Aceita nulo? | Descrição |
| --- | --- | --- | --- | --- |
| id | Não definido | Não definido | Não definido | Identificador do usuário, guardado na sessão após o login. |
| email | Não definido | Não definido | Não definido | E-mail utilizado para localizar a conta no login. |
| senha | VARCHAR(255) | Não definido | Não definido | Hash da senha, gerado com `password_hash()` e verificado com `password_verify()`. |

- Os campos aparecem nas consultas de [functions.php](includes/functions.php).
- O projeto ainda não possui o script de criação da tabela `usuarios`.
- Tipos, chaves e regras de nulidade devem ser confirmados no banco.
- O arquivo [ajustar_senhas.sql](database/ajustar_senhas.sql) ajusta o campo de senha para aceitar os hashes.
- Senhas antigas salvas como texto precisam ser convertidas ou redefinidas.

## Legenda

- **PK:** chave primária, identifica cada registro da tabela.
- **FK:** chave estrangeira, referencia uma chave de outra tabela.
- **Nulo:** ausência de valor no campo; não é o mesmo que texto vazio.
