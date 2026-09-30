# Diagramas do CRUD

Cada diagrama mostra a tabela usada pelo arquivo de `app/`. Todos usam `alunos`: `id` é PK e não há FK definida.

## create.php

- Cadastra o aluno. O banco gera o id automaticamente.

```mermaid
erDiagram
    alunos {
        serial id PK
        varchar(60) nome
        date nasc
        varchar(50) turma
        boolean ativo
        varchar(100) email
    }
```

## select.php

- Lista os alunos em ordem de id.

```mermaid
erDiagram
    alunos {
        serial id PK
        varchar(60) nome
        date nasc
        varchar(50) turma
        boolean ativo
        varchar(100) email
    }
```

## select_w.php

- Busca o aluno com id buscado e mostra os demais campos.

```mermaid
erDiagram
    alunos {
        serial id PK
        varchar(60) nome
        date nasc
        varchar(50) turma
        boolean ativo
        varchar(100) email
    }
```

## select_w_w.php

- Busca e mostra o aluno pelo id informado.

```mermaid
erDiagram
    alunos {
        serial id PK
        varchar(60) nome
        date nasc
        varchar(50) turma
        boolean ativo
        varchar(100) email
    }
```

## update.php

- Busca pelo id e altera nome, nasc, turma, ativo e email.

```mermaid
erDiagram
    alunos {
        serial id PK
        varchar(60) nome
        date nasc
        varchar(50) turma
        boolean ativo
        varchar(100) email
    }
```

## delete.php

- Busca pelo id, mostra nome e turma e exclui após confirmação.

```mermaid
erDiagram
    alunos {
        serial id PK
        varchar(60) nome
        date nasc
        varchar(50) turma
        boolean ativo
        varchar(100) email
    }
```
