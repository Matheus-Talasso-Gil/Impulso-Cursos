# Impulso Cursos

Projeto fictício de gestão de alunos feito com PHP e PostgreSQL.

O sistema permite cadastrar, consultar, editar e excluir alunos, além de possuir sistema de login.

## Funcionalidades

- Cadastrar alunos
- Consultar alunos
- Editar alunos
- Excluir alunos
- Fazer login
- Sair da conta

## Tecnologias utilizadas

- PHP
- PostgreSQL
- HTML
- CSS
- Git
- GitHub

## Estrutura do projeto

```text
mini_sistema/
├── app/
├── css/
├── database/
├── includes/
├── login/
├── index.php
└── README.md
```

## Como executar

1. Instale o PHP.
2. Instale o PostgreSQL.
3. Confira a conexão com o banco em database/connect_postgres.php.
4. Abra o terminal na pasta que contém mini_sistema.
5. Execute:
    php -S localhost:8000

## Banco de dados

O projeto utiliza PostgreSQL.

Os arquivos SQL ficam na pasta database.
Exemplo:

```text
database/
├── connect_postgres.php
└── ajustar_senhas.sql
```

## Senhas

As senhas são protegidas usando:
password_hash()

E são verificadas no login usando:
password_verify()

Assim, a senha não fica salva diretamente no banco.

## GitHub

Depois de alterar o projeto, use:

git add .

git commit -m "descricao da alteracao"

git push

## Autor

### Matheus Gil
