<fieldset>
	<legend>Datos Notaria</legend>

	<?php 
	if(isset($InfoNotaria)){
		if(!empty($InfoNotaria)){
			?>
	<input type="hidden" name="IdNotarias" value="<?=$InfoNotaria['IdNotarias']?>">
			<?php
		}
	}
	?>

	<input type="hidden" name="Estado" value="<?=(isset($InfoNotaria)?$InfoNotaria['Estado']:1)?>">

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Nombre</label>
				<input type="text" name="NombreNotaria" id="NombreNotaria" class="form-control" required="true" value="<?php 
				if(isset($InfoNotaria)){
					if(!empty($InfoNotaria)){
						echo $InfoNotaria['NombreNotaria'];
					}
				}
				?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Numero notaria</label>
				<input type="text" name="NumeroNotaria" id="NumeroNotaria" class="form-control" required="true" value="<?php 
				if(isset($InfoNotaria)){
					if(!empty($InfoNotaria)){
						echo $InfoNotaria['NumeroNotaria'];
					}
				}
				?>">
			</div>
		</div>		
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Direccion</label>
				<input type="text" name="Direccion" id="Direccion" class="form-control" required="true" value="<?php 
				if(isset($InfoNotaria)){
					if(!empty($InfoNotaria)){
						echo $InfoNotaria['Direccion'];
					}
				}
				?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Barrio</label>
				<input type="text" name="Barrio" id="Barrio" class="form-control" value="<?php 
				if(isset($InfoNotaria)){
					if(!empty($InfoNotaria)){
						echo $InfoNotaria['Barrio'];
					}
				}
				?>">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Departamentos</label>
				<select class="form-control" id="IdDepartamento" name="IdDepartamento" required="true" onchange="ListarCiudadesPorDepartamento()">
					<option value="">Seleccionar departamento</option>
					<?php 
					if(isset($Departamentos)){
						if(!empty($Departamentos)){
							foreach ($Departamentos AS $Departamento) {
								$selected = "";
								if(isset($InfoNotaria)){
									if(!empty($InfoNotaria)){
										if($Departamento['IdDepartamento'] == $InfoNotaria['IdDepartamento']){
											$selected = ' selected ';
										}
									}
								}
								echo '<option value="'.$Departamento['IdDepartamento'].'" '.$selected.'>'.$Departamento['NombreDepartamento'].'</option>';
							}
						}
					}
					?>
				</select>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Ciudades</label>
				<select class="form-control" id="IdCiudad" name="IdCiudad" required="true">
					<option value="">Seleccionar ciudad</option>
					<?php 
					if(isset($Ciudades)){
						if(!empty($Ciudades)){
							foreach ($Ciudades AS $Ciudad) {
								$selected = "";
								if(isset($InfoNotaria)){
									if(!empty($InfoNotaria)){
										if($Ciudad['IdCiudad'] == $InfoNotaria['IdCiudad']){
											$selected = ' selected ';
										}
									}
								}
								echo '<option value="'.$Ciudad['IdCiudad'].'" '.$selected.'>'.$Ciudad['NombreCiudad'].'</option>';
							}
						}
					}
					?>
				</select>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-7">
			<?php echo $this->render('_datosTelefonosNotaria.php', [
				'TiposTelefonos' => $TiposTelefonos,
				'TelefonosNotaria' => $TelefonosNotaria,                
			]); ?>
		</div>
		<div class="col-md-5">
			<?php echo $this->render('_datosEmailsNotaria.php', [
				'EmailsNotaria' => $EmailsNotaria,
			]); ?>
		</div>
	</div>
</fieldset>