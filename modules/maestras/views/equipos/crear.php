<?php

use app\assets\EquiposAsset;

EquiposAsset::register($this);
?>

<form id="formCrearEquipo" name="formCrearEquipo" type="POST">
    <?php echo $this->render('_datosEquipo.php', ['TiposEquipos' => $TiposEquipos]); ?>
    
    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>