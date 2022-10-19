<?php 
use yii\helpers\Url;
use app\assets\EmpleadoAsset;

EmpleadoAsset::register($this);
?>

<form id="formCambioContrasenaMiCuenta" name="formCambioContrasenaMiCuenta" type="POST">
	<input type="hidden" name="IdUsuario" id="IdUsuario" value="<?=$IdUsuario?>">
	
	<div class="form-group">
		<label class="required">Contraseña Actual</label>
		<input type="password" id="PasswordActual" name="PasswordActual" class="form-control" required="true">
	</div>

	<?php echo $this->render('@app/modules/maestras/views/empleados/_crearContrasena'); ?>

	<div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>
</form>
