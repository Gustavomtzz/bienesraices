<h1 class="fw-300 centrar-texto">Administración - Nuevo(a) Vendedor(a)</h1>

<main class="contenedor seccion contenido-centrado">
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores ?? [] as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST">
        <?php include __DIR__ . '/formulario.php'; ?>
        <input type="submit" value="Crear Vendedor" class="boton boton-verde">

    </form>

</main>