<?php 
use yii\helpers\Url;
use app\assets\EmpleadoAsset;

EmpleadoAsset::register($this);
?>

<form id="formCargarEmpleados" name="formCargarEmpleados" type="POST" enctype="multipart/form-data">
	<div class="form-group">
		<a class="btn btn-default" href="<?=Yii::getAlias('@web')?>/files/Empleados.xlsx"><span class="glyphicon glyphicon-save"></span> Descargar Guia</a>
	</div>

	<div class="form-group">
		<label>Seleccionar archivo</label>
		<input type="file" id="ArchivoEmpleados" name="ArchivoEmpleados">
	</div>

	<div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>

