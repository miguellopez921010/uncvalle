<fieldset>
	<legend>Datos Equipo</legend>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Nombre</label>
				<input type="text" name="Nombre" id="Nombre" class="form-control" required="true" value="<?php 
				if(isset($InfoEquipo)){
					if(!empty($InfoEquipo)){
						echo $InfoEquipo['Nombre'];
					}
				}
				?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Descripcion</label>
				<textarea id="Descripcion" name="Descripcion" class="form-control" style="resize: none;" rows="3"><?php 
				if(isset($InfoEquipo)){
					if(!empty($InfoEquipo)){
						echo $InfoEquipo['Descripcion'];
					}
				}
				?></textarea>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Marca</label>
				<input type="text" name="Marca" id="Marca" class="form-control" required="true" value="<?php 
				if(isset($InfoEquipo)){
					if(!empty($InfoEquipo)){
						echo $InfoEquipo['Marca'];
					}
				}
				?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Numero serie</label>
				<input type="text" name="NumeroSerie" id="NumeroSerie" class="form-control" required="true" value="<?php 
				if(isset($InfoEquipo)){
					if(!empty($InfoEquipo)){
						echo $InfoEquipo['NumeroSerie'];
					}
				}
				?>">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>IMEI</label><span>(Preferiblemente para celulares, tablets)</span>
				<input type="text" name="IMEI" id="IMEI" class="form-control" value="<?php 
				if(isset($InfoEquipo)){
					if(!empty($InfoEquipo)){
						echo $InfoEquipo['IMEI'];
					}
				}
				?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="required">Direccion IP</label>
				<input type="text" name="DireccionIP" id="DireccionIP" class="form-control" required="true" value="<?php 
				if(isset($InfoEquipo)){
					if(!empty($InfoEquipo)){
						echo $InfoEquipo['DireccionIP'];
					}
				}
				?>">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="required">Tipo equipo</label>
				<select class="form-control" id="Idtipos_equipos" name="Idtipos_equipos" required="true">
					<option value="">Seleccionar tipo de quipo</option>
					<?php 
					if(isset($TiposEquipos)){
						if(!empty($TiposEquipos)){
							foreach ($TiposEquipos AS $TipoEquipo) {
								$selected = "";
								if(isset($InfoEquipo)){
									if(!empty($InfoEquipo)){
										if($TipoEquipo['Idtipos_equipos'] == $InfoEquipo['Idtipos_equipos']){
											$selected = ' selected ';
										}
									}
								}
								echo '<option value="'.$TipoEquipo['Idtipos_equipos'].'" '.$selected.'>'.$TipoEquipo['Nombre'].'</option>';
							}
						}
					}
					?>
				</select>
			</div>
		</div>
	</div>
</fieldset>