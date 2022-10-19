<?php

use app\assets\ProductoAsset;

ProductoAsset::register($this);
?>

<form id="FormAdministrarImagenesProducto" name="FormAdministrarImagenesProducto" enctype="multipart/form-data">
	<input type="hidden" id="IdProductos" name="IdProductos" value="<?=$InfoProducto['IdProductos']?>">
	<label>Seleccionar imagen principal</label>
	<input type="file" id="ImagenPrincipal" name="ImagenPrincipal">
</form>