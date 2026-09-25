# Impulso Cursos

Projeto fictício de gestão de alunos em PHP e PostgreSQL, com cadastro, consulta, relatório, edição, exclusão e login.

## Executar localmente

1. Instale PHP com a extensão PDO PostgreSQL habilitada e tenha acesso a um servidor PostgreSQL.
2. Mantenha o projeto em uma pasta chamada `mini_sistema`, pois os links usam esse caminho.
3. Confira os dados de conexão em `database/connect_postgres.php` e ajuste-os se usar outro servidor. Esse arquivo faz parte do repositório.
4. Configure um banco com as tabelas `alunos` e `usuarios` compatíveis com o projeto ou restaure seu backup do PostgreSQL. O SQL em `app/` é um rascunho, não uma migração completa.
5. Na pasta que contém `mini_sistema`, execute `php -S localhost:8000`.
6. Acesse `http://localhost:8000/mini_sistema/index.php`.

## Salvar novas alterações

Após editar os arquivos, faça um commit no Git e envie com push ao GitHub. As alterações não são enviadas automaticamente.

O repositório armazena o código. Os registros do PostgreSQL precisam de backup separado.