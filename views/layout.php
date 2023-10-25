<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($inicio)) {
    $inicio = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $nombrePagina ?? 'Bienes Raices'; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="../build/css/app.css">
</head>

<body>

    <header class="header <?php echo $inicio ? 'inicio' : '' ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/" class="logo">
                    <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>
                <div class="mobile-menu">
                    <a href="#navegacion">
                        <img src="/build/img/barras.svg" alt="Icono Menu">
                    </a>
                </div>

                <nav id="navegacion" class="navegacion">
                    <a href="/nosotros">Nosotros</a>
                    <a href="/anuncios">Anuncios</a>
                    <a href="/blog">Blog</a>
                    <a href="/contacto">Contacto</a>
                    <?php if (!$_SESSION) : ?>
                        <a href="/login">Login</a>
                    <?php endif; ?>
                    <?php if ($_SESSION['login'] ?? false === true) : ?>
                        <a href="/admin">Admin</a>
                        <a href="/logout">Cerrar Sesion</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div> <!-- contenedor -->
    </header>


    <?php
    echo $contenido;
    ?>


    <footer class="site-footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="/nosotros.php">Nosotros</a>
                <a href="/anuncios.php">Anuncios</a>
                <a href="/blog.php">Blog</a>
                <a href="/contacto.php">Contacto</a>
            </nav>
            <p class="copyright">Todos los Derechos Reservados <?php echo date('Y'); ?> &copy; </p>
        </div>
    </footer>

    <script src="../build/js/bundle.min.js"></script>
</body>

</html>