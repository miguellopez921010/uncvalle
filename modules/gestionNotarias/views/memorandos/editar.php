<?php
use app\assets\AppAsset;
use app\assets\NotariasAsset;

AppAsset::register($this);
NotariasAsset::register($this);
?>

<form id="formEditarMemorando" name="formEditarMemorando" type="POST">
    <?php echo $this->render('_datosMemorando.php', [
        'InfoMemorando' => $InfoMemorando,
        'CategoriasMemorandos' => $CategoriasMemorandos,
    ]); ?>

    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>
