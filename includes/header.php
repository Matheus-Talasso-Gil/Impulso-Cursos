<header>
    <nav>
        <a class="brand" href="/mini_sistema/index.php">Impulso Cursos</a>
        <div class="nav-links">
            <a href="/mini_sistema/index.php">Início</a>
            <a href="/mini_sistema/app/create.php">Cadastrar</a>
            <a href="/mini_sistema/app/delete.php">Excluir</a>
            <a href="/mini_sistema/app/select.php">Relatório</a>
            <a href="/mini_sistema/app/select_w_w.php">Consultar</a>
        </div>
        <div class="nav-account">
            <?php if (!isset($_SESSION['id'])): // mostra Entrar somente quando o usuário não está logado ?>
            <a href="/mini_sistema/login/login.php">Entrar</a>
            <?php endif; // encerra a condição que controla a exibição do link Entrar ?>
            <a href="/mini_sistema/login/logout.php">Sair</a>
        </div>
    </nav>
</header>
