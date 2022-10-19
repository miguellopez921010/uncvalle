<?php 
if(isset($Mensaje)){
	if($Mensaje != null){
		?>
<div class="alert alert-primary" role="alert">
  <?=$Mensaje;?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
		<?php
	}
}

if(!empty($TiposImagenesPermitido)){
	foreach($TiposImagenesPermitido AS $IdTipoImagen => $NombreTipoImagen){
		?>
	<fieldset>
		<legend><?=$NombreTipoImagen?></legend>

		<form name="formCargueImagenes<?=$IdTipoImagen?>" id="formCargueImagenes<?=$IdTipoImagen?>" method="post" action="/maestras/imagenes/subir-imagenes" enctype="multipart/form-data">
			<input type="hidden" id="IdTipoImagen" name="IdTipoImagen" value="<?=$IdTipoImagen?>">
			<div class="form-group">
				<label class="col-sm-2 control-label">Archivos</label>
				<div class="col-sm-8">
					<input type="file" class="form-control" id="archivo[]" name="archivo[]" multiple="" accept=".png, .jpg, .jpeg">
				</div>
				<div class="col-sm-2">
					<button type="submit" class="btn btn-success btn-block">Cargar</button>	
				</div>
			</div>
		</form>
	</fieldset>
	<br>
		<?php
	}
}
?>