# Diagramas do sistema

## Estrutura e ligação entre as pastas

Os blocos mostram os arquivos e suas funções. As ligações representam o uso entre módulos, não relações entre tabelas do banco.

- **App:** cadastro, consulta, edição e exclusão de alunos.
- **Login:** acesso ao sistema e verificação de sessão.
- **Includes:** arquivos compartilhados pelas páginas.
- **Database:** conexão com o banco de dados.
- **CSS:** aparência das páginas.

```mermaid
erDiagram
    app {
        php create "Cadastrar aluno"
        php select "Listar alunos"
        php select_w "Consultar ID 7"
        php select_w_w "Consultar por ID"
        php update "Editar aluno"
        php delete "Excluir aluno"
        sql TABEL_alunos "Criar tabela"
        md tabela "Documentar tabela"
    }

    login {
        php login "Entrar"
        php cadastrar "Cadastrar usuário"
        php verificar_user "Verificar sessão"
        php logout "Sair"
    }

        includes {
        php session "Iniciar sessão"
        php header "Menu"
        php footer "Rodapé"
        php functions "Funções de alunos e usuários"
    }

    database {
        php connect_postgres "Conexão PDO com PostgreSQL"
    }

    css {
        css style "Estilos do sistema"
    }

    index ||--|| includes : "usa"
    index ||--|| css : "usa"
    app ||--|| login : "verifica sessão"
    app ||--|| includes : "usa"
    login ||--|| includes : "usa"
    includes ||--|| database : "carrega conexão"
    app ||--|| database : "executa SQL"
    login ||--|| database : "conecta no cadastro"
    app ||--|| css : "usa"
    login ||--|| css : "usa"
    database ||--|| PostgreSQL : "conecta"
```

