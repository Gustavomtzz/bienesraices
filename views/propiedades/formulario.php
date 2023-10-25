<!-- OBLIGATORIO sanitizar cada input PRECARGADO en caso de error -->
<?php

use Model\Vendedor;
?>
<fieldset>
    <legend>Información General</legend>
    <label for="titulo">Titulo:</label>
    <input name="titulo" type="text" id="titulo" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo);  ?>">

    <label for="precio">Precio: </label>
    <input name="precio" type="number" id="precio" placeholder="Precio" value="<?php echo s($propiedad->precio); ?>">

    <label for="imagen">Imagen: </label>
    <input name="imagen" type="file" id="imagen" accept="image/*.jpg,image/*.png">
    <?php if ($propiedad->imagen) :  ?>
        <label for="">Imagen Anterior:</label>
        <img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small">
    <?php endif; ?>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>

</fieldset>


<fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input name="habitaciones" type="number" min="1" max="10" step="1" id="habitaciones" value="<?php echo s($propiedad->habitaciones); ?>">

    <label for="baños">Baños:</label>
    <input name="baños" type="number" min="1" max="10" step="1" id="baños" value="<?php echo s($propiedad->baños); ?>">

    <label for="estacionamiento">Estacionamiento:</label>
    <input name="estacionamiento" type="number" min="1" max="10" step="1" id="estacionamiento" value="<?php echo s($propiedad->estacionamiento); ?>">

    <legend>Información Vendedor:</legend>
    <label for="nombre_vendedor">Nombre:</label>

    <select name="vendedores_id" id="nombre_vendedor">
        <option selected value="" disabled>-- Seleccione --</option>
        <?php foreach (Vendedor::getAll() as $vendedor) : ?>
            <option <?php echo $propiedad->vendedores_id === s($vendedor->id) ? 'selected' : '' ?> value="<?php echo s($vendedor->id); ?>"><?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?>
            <?php endforeach; ?>
    </select>
</fieldset>