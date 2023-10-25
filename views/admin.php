<?php

use Model\Propiedad;
use Model\Vendedor;
?>

<main class="contenedor seccion contenido-centrado main-admin">


    <?php
    if ($mensaje) {
        if ($mensaje == 1) {
            echo '<p class="alerta exito">Registro Creado Correctamente</p>';
        } else if ($mensaje == 2) {
            echo '<p class="alerta actualizar">Registro Actualizado Correctamente</p>';
        }
        if ($mensaje == 3) {
            echo '<p class="alerta error">Registro Eliminado Correctamente</p>';
        }
    }
    ?>

    <div class="flex">
        <a href="/propiedades/crear" class="boton boton-crear boton-verde">Nueva Propiedad</a>
        <a href="/vendedores/crear" class="boton boton-crear boton-amarillo">Nuevo(a) Vendedor</a>
    </div>


    <table class="propiedades">
        <h2>Propiedades</h2>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach (Propiedad::getAll() as $prop) : ?>
                <tr>
                    <td><?php echo $prop->id; ?></td>
                    <td><?php echo $prop->titulo; ?></td>
                    <td>
                        <img src="/imagenes/<?php echo $prop->imagen; ?>"" width=" 100" class="imagen-small">
                    </td>
                    <td>$ <?php echo $prop->precio; ?></td>
                    <td>
                        <form method="POST" action="/propiedades/eliminar">
                            <input type="hidden" name="id" value="<?php echo $prop->id; ?>">
                            <input type="hidden" name="tipo" value="propiedades">
                            <input type="submit" class="boton boton-rojo w-100" value="Borrar">
                        </form>

                        <a href="/propiedades/actualizar?id=<?php echo $prop->id; ?>" class="boton boton-verde w-100">Actualizar</a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
    <table class="propiedades">
        <h2>Vendedores</h2>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach (Vendedor::getAll() as $vendedor) : ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre; ?></td>
                    <td><?php echo $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" action="/vendedores/eliminar">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton boton-rojo w-100" value="Borrar">
                        </form>
                        <a href="/vendedores/actualizar?id=<?php echo $vendedor->id; ?>" class=" boton boton-verde w-100">Actualizar</a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>


</main>