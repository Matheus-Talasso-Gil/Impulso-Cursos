<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../login/verificar_user.php';
require_once __DIR__ . '/../includes/functions.php';
$alunos = listarAlunos($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório | Impulso Cursos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Alunos matriculados</h1>
        <div class="table-wrapper" tabindex="0" role="region" aria-label="Relatório de alunos">
            <table>
                <caption>Relatório de alunos da Impulso Cursos</caption>
                <thead>
                    <tr>
                        <th scope="col">ID</th><th scope="col">Nome</th>
                        <th scope="col">Nascimento</th><th scope="col">Turma</th>
                        <th scope="col">E-mail</th><th scope="col">Situação</th><th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $aluno['nome'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $aluno['nasc'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $aluno['turma'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) ($aluno['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= $aluno['ativo'] ? 'Ativo' : 'Inativo' ?></td>
                        <td>
                            <form action="update.php" method="post" class="edit-action">
                                <input type="hidden" name="id" value="<?= htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') ?>">
                                <input type="submit" value="Editar">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (!$alunos): ?>
                    <tr><td colspan="7">Nenhum aluno cadastrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>