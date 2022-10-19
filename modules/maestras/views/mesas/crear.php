<?php

use app\assets\MesaAsset;

MesaAsset::register($this);
?>

<form id="formCrearMesa" name="formCrearMesa" type="POST">
    <?php echo $this->render('_datosMesa.php'); ?>
    
    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>