<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">
    <title><?= $this->e($title) ?></title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  </head>
  <body class="mod-bg-1 mod-nav-link">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
    <a class="navbar-brand d-flex align-items-center fw-500" href="/"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">
        </ul>
        <ul class="navbar-nav ml-auto">
            <?= ! empty($_SESSION['username']) ? $this->e($_SESSION['username']) : ''?>
            <?php
            if (isset($_SESSION['id_user'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Выйти</a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="/login">Войти</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

    <?=$this->section('content')?>


    <footer class="page-footer" role="contentinfo">
    <div class="d-flex align-items-center flex-1 text-muted">
        <span class="hidden-md-down fw-700">2025 © Учебный проект</span>
    </div>
</footer>
  </body>
</html>
