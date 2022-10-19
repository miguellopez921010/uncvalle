<?php
use app\assets\AppAsset;
use app\assets\NotariasAsset;

AppAsset::register($this);
NotariasAsset::register($this);
?>

<form id="formCrearNotaria" name="formCrearNotaria" type="POST">
    <?php echo $this->render('_datosNotaria.php', [
                'Departamentos' => $Departamentos,
                'Ciudades' => $Ciudades,
                'TiposTelefonos' => $TiposTelefonos,
                'TelefonosNotaria' => $TelefonosNotaria,
                'EmailsNotaria' => $EmailsNotaria,
            ]); ?>

    <?php echo $this->render('_datosNotario.php'); ?>
    
    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>