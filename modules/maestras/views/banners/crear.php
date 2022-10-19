<?php

use app\assets\AppAsset;
use app\assets\BannerAsset;

AppAsset::register($this);
BannerAsset::register($this);
?>

<form id="formCrearBanner" name="formCrearBanner" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="Nombre" class="required">Nombre</label>
				<input type="text" id="Nombre" name="Nombre" class="form-control" required="true">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label id="IdTipoBanner" class="required">Tipo Banner</label>
				<select id="IdTipoBanner" name="IdTipoBanner" class="form-control" required="true">
					<option value="">Seleccionar</option>
					<?php 
					if(!empty($TiposBanners)){
						foreach ($TiposBanners AS $TipoBanner) {
							echo '<option value="'.$TipoBanner['IdTiposImagenesProductos'].'">'.$TipoBanner['Nombre'].'</option>';
						}
					}
					?>
				</select>				
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="Archivo" class="required">Seleccionar imagen</label>
				<input type="file" id="Archivo" name="Archivo">
			</div>			
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="Enlace">Enlace</label>
				<input type="text" id="Enlace" name="Enlace" class="form-control">
			</div>			
		</div>
	</div>


	<div class="form-group">
		<button type="submit" class="btn btn-success">Guardar</button>
	</div>
</form>