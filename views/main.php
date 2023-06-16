<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/probamunka/resources/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/probamunka/resources/css/spinner.css">
        <script src="/probamunka/resources/bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php if(session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['email'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/probamunka/user/profile">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/probamunka/analysis/index">Elemzés</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/probamunka/chat/index">Chat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/probamunka/login/logout">Kijelentkezés</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/probamunka/login/login">Bejelentkezés</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/probamunka/register/register">Regisztráció</a>
                            </li>
                        <?php endif ?>
                    </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <?php include $content; ?>
        </main>
    </body>
</html>