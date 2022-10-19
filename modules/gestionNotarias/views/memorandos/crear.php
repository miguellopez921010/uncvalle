<?php

use app\assets\AppAsset;
use app\assets\NotariasAsset;

AppAsset::register($this);
NotariasAsset::register($this);
?>

<form id="formCrearMemorando" name="formCrearMemorando" type="POST">
<?php echo $this->render('_datosMemorando.php', ['CategoriasMemorandos' => $CategoriasMemorandos,]); ?>

    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>