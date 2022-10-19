<fieldset>
	<legend>Datos Personales</legend>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="required">Numero de Documento</label>
				<input type="text" name="NumeroDocumento" id="NumeroDocumento" class="form-control" required="true" value="<?php 
				if(isset($InfoUsuario)){
					echo $InfoUsuario['NumeroDocumento'];
				}?>" 
				<?php 
				if(isset($BloqueoCambioDocumento)){
					if($BloqueoCambioDocumento){
						echo ' readonly ';
					}
				}
				?>
				>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Nombres</label>
				<input type="text" name="Nombres" id="Nombres" class="form-control" required="true" value="<?php 
				if(isset($InfoUsuario)){
					echo $InfoUsuario['Nombres'];
				}?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Apellidos</label>
				<input type="text" name="Apellidos" id="Apellidos" class="form-control" required="true" value="<?php 
				if(isset($InfoUsuario)){
					echo $InfoUsuario['Apellidos'];
				}?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="required">Email</label>
				<input type="email" name="Email" id="Email" required="true" class="form-control" value="<?php 
				if(isset($InfoUsuario)){
					echo $InfoUsuario['Email'];
				}?>">
			</div>
		</div>
	</div>
</fieldset>
