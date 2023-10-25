<h1 class="fw-300 centrar-texto">Contacto</h1>
<img src="/build/img/destacada3.jpg" alt="Imagen Principal">

<main class="contenedor seccion contenido-centrado">
    <h2 class="fw-300 centrar-texto">Llena el formulario de Contacto</h2>
    <?php if ($mensaje) : ?>
        <p class="alerta exito"><?php echo $mensaje; ?></p>
    <?php endif; ?>
    <?php if ($mensaje === false) : ?>
        <p class="alerta error"><?php echo $mensaje; ?></p>
    <?php endif; ?>
    <form class="formulario" action="/contacto" method="POST">
        <fieldset>
            <legend>Información Personal</legend>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" placeholder="Tu Nombre" name="contacto[nombre]">

            <label for="mensaje">Mensaje: </label>
            <textarea id="mensaje" name="contacto[mensaje]"></textarea>

        </fieldset>


        <fieldset>
            <legend>Información sobre Propiedad</legend>
            <label for="opciones">Vende o Compra</label>
            <select id="opciones" name="contacto[tipo]">
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>

            <label for="presupuesto">Precio o Presupuesto</label>
            <input type="number" id="presupuesto" name="contacto[precio]">
        </fieldset>

        <fieldset>
            <legend>Contacto</legend>

            <p>Como desea ser Contactado:</p>

            <div class="forma-contacto">
                <label for="telefono">Teléfono</label>
                <input type="radio" name="contacto[contacto]" value="telefono" id="telefono">

                <label for="correo">E-mail</label>
                <input type="radio" name="contacto[contacto]" value="correo" id="correo">
            </div>
            <div id="tipoTelefono"> </div>
        </fieldset>

        <input type="submit" value="Enviar" class="boton boton-verde">

    </form>
</main>