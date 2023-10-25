<!-- OBLIGATORIO sanitizar cada input PRECARGADO en caso de error -->
<fieldset>
    <legend>Información General</legend>
    <label for="nombre">Nombre:</label>
    <input name="nombre" type="text" id="nombre" placeholder="Nombre Vendedor" value="<?php echo s($vendedor->nombre);  ?>">

    <label for="apellido">Apellido: </label>
    <input name="apellido" type="text" id="apellido" placeholder="Apellido" value="<?php echo s($vendedor->apellido); ?>">

    <label for="telefono">Telefono:</label>
    <input name="telefono" type="text" id="telefono" placeholder="Telefono" value="<?php echo s($vendedor->telefono); ?>">

</fieldset>