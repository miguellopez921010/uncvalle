<?php 
use yii\helpers\Url;
use app\assets\EmpleadoAsset;

EmpleadoAsset::register($this);
?>

<form id="formCambioContrasenaUsuario" name="formCambioContrasenaUsuario" type="POST">
	<input type="hidden" name="IdUsuario" id="IdUsuario" value="<?=$IdUsuario?>">
	
	<?php echo $this->render('_crearContrasena.php'); ?>

	<div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>
</form>
