<h1 class="nombre-pagina">Actualizar servicios</h1>
<p class="descripcion-pagina">
    Modifica los datos del servicio.
</p>
<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>
<form method="POST" class="formulario">
    <?php
        include_once __DIR__ . '/formulario.php';
    ?>
    <input type="submit" class="boton" value="Guardar servicio">
</form>