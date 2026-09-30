# Briefing do projeto Impulso Cursos

## Visão do proprietário

Quero um sistema simples e confiável para organizar os alunos da Impulso Cursos. A equipe deve conseguir realizar as tarefas comuns rapidamente, encontrar informações com facilidade e manter os dados protegidos. O site precisa funcionar bem em computadores e celulares.

## Objetivos

- Centralizar os dados dos alunos.
- Facilitar matrícula, consulta, atualização e exclusão de cadastros.
- Reduzir erros por meio de validação e mensagens claras.
- Permitir que a equipe acompanhe a situação dos alunos e das turmas.

## Usuários

- **Administrador:** gerencia os cadastros e, futuramente, as contas e permissões da equipe.
- **Funcionário autorizado:** realiza operações com alunos conforme as permissões definidas.

## Requisitos principais

### Acesso

- Login para áreas administrativas.
- Encerramento de sessão.
- Mensagens claras para falhas de autenticação.
- Acesso restrito a usuários autorizados.

### Alunos

- Cadastrar aluno com nome, e-mail, data de nascimento, turma e situação (ativo ou inativo).
- Validar campos obrigatórios e formatos antes de salvar.
- Consultar alunos em uma lista organizada.
- Pesquisar por nome, e-mail ou ID e filtrar por turma e situação.
- Editar os dados de um aluno e confirmar o resultado da operação.
- Exibir os dados e pedir confirmação antes de excluir um aluno.
- Mostrar uma mensagem apropriada quando a busca não encontrar resultados.

### Relatórios e navegação

- Exibir um relatório com os dados principais dos alunos.
- Indicar claramente quando não houver cadastros ou resultados.
- Manter navegação consistente entre as telas e oferecer retorno visual após cada ação.

## Requisitos de qualidade e segurança

- Interface clara, responsiva e fácil de usar por pessoas sem conhecimento técnico.
- Formulários com rótulos e mensagens compreensíveis.
- Validar os dados no servidor, mesmo que também haja validação no navegador.
- Armazenar senhas com hash; nunca guardar senhas em texto puro.
- Usar consultas preparadas para acessar o banco de dados.
- Escapar dados exibidos em HTML para reduzir riscos de injeção de conteúdo.
- Não publicar senhas, tokens ou credenciais no repositório.
- Documentar como configurar o banco e executar o projeto do zero.

## Melhorias desejadas

- Gerenciar turmas pelo próprio sistema, sem precisar alterar o código.
- Paginar listas grandes.
- Criar níveis de acesso para administrador e funcionário.
- Registrar datas de matrícula e de última atualização.
- Manter um histórico básico de alterações importantes.

## Ideias adicionais

- Exportar relatórios para CSV ou PDF.
- Mostrar indicadores na página inicial, como total de alunos ativos por turma.
- Recuperar senha.
- Sinalizar cadastros incompletos ou alunos inativos.

## Prioridades

1. Manter login e operações de cadastro, consulta, edição e exclusão funcionando corretamente.
2. Melhorar busca, filtros e experiência em dispositivos móveis.
3. Implementar permissões, gestão de turmas e histórico.
4. Avaliar exportações, indicadores e recuperação de senha.

## Critério de conclusão

Considerar uma funcionalidade concluída quando ela puder ser usada no navegador, validar os dados, apresentar retorno claro, funcionar com o banco configurado e tiver sido testada nos cenários esperados. Registrar o resultado e eventuais pendências em `acompanhamento.md`.
