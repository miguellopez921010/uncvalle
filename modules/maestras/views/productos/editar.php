<?php

use app\assets\ProductoAsset;

ProductoAsset::register($this);
?>

<form id="formCrearProducto" name="formCrearProducto" type="POST">
    <?php echo $this->render('_datosProducto.php', [
        'Categorias' => $Categorias,
        'Colores' => $Colores,
        'InfoProducto' => $InfoProducto,
    ]); ?>
    
    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>