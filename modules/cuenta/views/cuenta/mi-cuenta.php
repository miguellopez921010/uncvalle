<?php

use app\assets\EmpleadoAsset;

EmpleadoAsset::register($this);
?>

<form id="formMiCuenta" name="formMiCuenta" type="POST">
    <?php 
    if(isset($InfoUsuario)){
        if(isset($InfoUsuario['IdUsuario'])){
            if($InfoUsuario['IdUsuario'] != null){
                ?>
                <input type="hidden" id="IdUsuario" name="IdUsuario" value="<?=$InfoUsuario['IdUsuario']?>">
                <?php
            }
        }
    }
    ?>

	<?php echo $this->render('@app/modules/maestras/views/empleados/_datosPersona', ['InfoUsuario' => $InfoUsuario, 'BloqueoCambioDocumento' => true]); ?>

	<div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>