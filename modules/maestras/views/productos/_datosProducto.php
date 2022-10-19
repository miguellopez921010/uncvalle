<fieldset>
	<legend>Datos Producto</legend>

	<div class="row">
		<?php 
		if(isset($InfoProducto)){
			?>
		<input type="hidden" id="IdProductos" name="IdProductos" value="<?=$InfoProducto['IdProductos']?>">
			<?php
		}
		?>
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Categoria</label>
				<select class="form-control" id="IdCategorias" name="IdCategorias" required="true">
					<option value="">Seleccionar Categoria</option>
					<?php 
					if(!empty($Categorias)){
						foreach ($Categorias AS $C) {
							$selected = "";
							if(isset($InfoProducto)){
								if($InfoProducto['IdCategorias'] == $C['Idcategorias']){
									$selected = "selected";
								}
							}
							?>
					<option value="<?=$C['Idcategorias']?>" <?=$selected?>><?=$C['Codigo']?> - <?=$C['NombreCategoria']?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Consecutivo</label>
				<input type="text" id="Consecutivo" name="Consecutivo" required="true" class="form-control" readonly="true" value="<?php 
				if(isset($InfoProducto)){
					echo $InfoProducto['Consecutivo'];
				}?>" >
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Nombre</label>
				<input type="text" name="Nombre" id="Nombre" class="form-control" required="true" value="<?php 
				if(isset($InfoProducto)){
					echo $InfoProducto['Nombre'];
				}?>" 
				>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Descripcion</label>
				<textarea id="Descripcion" name="Descripcion" class="form-control" rows="3" style="resize: none;"><?php 
				if(isset($InfoProducto)){
					echo $InfoProducto['Descripcion'];
				}?></textarea>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Color</label>
				<select class="form-control" id="IdColor" name="IdColor" required="true">
					<option value="">Seleccionar Color</option>
					<?php 
					if(!empty($Colores)){
						foreach ($Colores AS $C) {
							$selected = "";
							if(isset($InfoProducto)){
								if($InfoProducto['IdColor'] == $C['IdColores']){
									$selected = "selected";
								}
							}

							?>
					<option value="<?=$C['IdColores']?>" <?=$selected?>><?=$C['Nombre']?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
		</div>
	</div>

</fieldset>