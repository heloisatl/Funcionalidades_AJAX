<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../estilo/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Gestão de Computadores</title>
</head>

<body style="background: linear-gradient(-130deg, var(--bg-darker), var(--bg-dark),   var(--bg-dark));">
    <?php
    $isHome = basename($_SERVER['PHP_SELF']) === 'home.php';
    $navbarClass = $isHome ? 'navbar-home' : '';
    include(__DIR__ . "/navbar.php");
    ?>
    <?php if (!$isHome) {
        echo '<div class="container">';
    } ?>