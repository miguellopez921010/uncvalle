<fieldset>
	<legend>Datos Notario</legend>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Nombres y apellidos</label>
				<input type="text" name="NombreNotario" class="form-control" required="true" value="<?php 
				if(isset($InfoNotario)){
					if(!empty($InfoNotario)){
						echo $InfoNotario['NombreNotario'];
					}
				}
				?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Numero documento</label>
				<input type="text" name="NumeroDocumentoNotario" class="form-control" value="<?php 
				if(isset($InfoNotario)){
					if(!empty($InfoNotario)){
						echo $InfoNotario['NumeroDocumento'];
					}
				}
				?>">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Numero telefono (personal)</label>
				<input type="text" name="NumeroTelefonoNotario" class="form-control" value="<?php 
				if(isset($InfoNotario)){
					if(!empty($InfoNotario)){
						echo $InfoNotario['NumeroTelefono'];
					}
				}
				?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Email (personal)</label>
				<input type="email" name="EmailNotario" class="form-control" value="<?php 
				if(isset($InfoNotario)){
					if(!empty($InfoNotario)){
						echo $InfoNotario['Email'];
					}
				}
				?>">
			</div>
		</div>
	</div>
</fieldset>