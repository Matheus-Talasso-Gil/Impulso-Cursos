# Dicionário de dados

## Alunos

Guarda os dados dos alunos cadastrados.

| Campo | Tipo | Chave | Aceita nulo? | Descrição |
| --- | --- | --- | --- | --- |
| id | SERIAL | PK | Não | Identificador do aluno, gerado automaticamente. |
| nome | VARCHAR(60) | — | Não | Nome do aluno, com até 60 caracteres. |
| nasc | DATE | — | Sim | Data de nascimento. |
| turma | VARCHAR(50) | — | Sim | Código da turma, como INF-01, ING-01 ou ADM-01. |
| ativo | BOOLEAN | — | Sim | Indica se o aluno está ativo: true ou false. |
| email | VARCHAR(100) | — | Sim | E-mail do aluno, com até 100 caracteres. |

- Base: [TABEL_alunos.sql](app/TABEL_alunos.sql). O script está sem vírgulas entre alguns campos; a tabela acima descreve as declarações presentes nele.
- A coluna “Aceita nulo?” segue o script do banco. Os formulários podem exigir o preenchimento mesmo quando o banco permite nulo.
- `turma` é um campo de texto, sem chave estrangeira definida nesse script.

## Usuarios

Guarda as contas usadas para entrar no sistema.

| Campo | Tipo e tamanho | Chave | Aceita nulo? | Descrição |
| --- | --- | --- | --- | --- |
| id | A confirmar | A confirmar | A confirmar | Identificador do usuário, guardado na sessão após o login. |
| email | A confirmar | A confirmar | A confirmar | E-mail usado para localizar a conta no login. |
| senha | A confirmar | A confirmar | A confirmar | Senha usada na verificação de acesso. |

- Os campos aparecem nas consultas de [functions.php](includes/functions.php).
- O projeto não inclui o script de criação de `usuarios`. Tipos, tamanhos, chaves e regras de nulidade precisam ser confirmados no banco.

## Legenda

- **PK:** chave primária, identifica cada registro da tabela.
- **FK:** chave estrangeira, referencia uma chave de outra tabela.
- **Nulo:** ausência de valor no campo; não é o mesmo que texto vazio.
