<?php

use app\assets\AppAsset;

AppAsset::register($this);
?>

<form id="formCrearPagina" name="formCrearPagina" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="Nombre" class="required">Nombre</label>
				<input type="text" id="Nombre" name="Nombre" class="form-control" required="true">
			</div>
		</div>
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-success">Guardar</button>
	</div>
</form>