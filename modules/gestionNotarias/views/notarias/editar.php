<?php
use app\assets\AppAsset;
use app\assets\NotariasAsset;

AppAsset::register($this);
NotariasAsset::register($this);
?>

<form id="formEditarNotaria" name="formEditarNotaria" type="POST">
    <?php echo $this->render('_datosNotaria.php', [
                'Departamentos' => $Departamentos,
                'Ciudades' => $Ciudades,
                'TiposTelefonos' => $TiposTelefonos,
                'InfoNotaria' => $InfoNotaria,
                'TelefonosNotaria' => $TelefonosNotaria,
                'EmailsNotaria' => $EmailsNotaria,
            ]); ?>

    <?php echo $this->render('_datosNotario.php', [
        'InfoNotario' => $InfoNotario,
    ]); ?>
    
    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>