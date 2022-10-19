<div class="panel panel-default">
  	<div class="panel-heading">TEL&Eacute;FONOS</div>
  	<div class="panel-body">  		
  		<div class="table-responsive" style="max-height: 250px !important; overflow-y: auto;">
			<table id="TableTelefonosNotaria" name="TableTelefonosNotaria" class="table table-stripped table-bordered table-condensed">
				<thead>
					<tr>
						<th class="text-center">Tipo tel&eacute;fono</th>
						<th class="text-center">Numero de tel&eacute;fono</th>
						<th class="text-center">Extensi&oacute;n</th>
					</tr>
				</thead>
				<tbody>
					<tr style="display: none;" id="FilaTelefonoNotaria">
						<td>
							<select name="IdTiposTelefonosNotaria[]" class="form-control">
								<option value="">Seleccionar tipo telefono</option>
								<?php 
								if(isset($TiposTelefonos)){
									if(!empty($TiposTelefonos)){
										foreach ($TiposTelefonos AS $TT) {
											echo '<option value="'.$TT['IdTiposTelefonos'].'">'.$TT['Nombre'].'</option>';
										}
									}
								}
								?>
							</select>
						</td>
						<td>
							<input type="text" name="NumeroTelefonoNotaria[]" class="form-control">	
						</td>
						<td>
							<input type="text" name="ExtensionNumeroTelefonoNotaria[]" class="form-control">	
						</td>
					</tr>
					<?php 
					$TelefonosEnCrecion = true;
					if(isset($TelefonosNotaria)){
						if(!empty($TelefonosNotaria)){
							$TelefonosEnCrecion = false;
							//TELEFONOS EN LA MODIFICACION
							foreach ($TelefonosNotaria AS $TN) {
								?>
						<tr>
							<td>
								<select name="IdTiposTelefonosNotaria[]" class="form-control">
									<option value="">Seleccionar tipo telefono</option>
									<?php 
									if(isset($TiposTelefonos)){
										if(!empty($TiposTelefonos)){										
											foreach ($TiposTelefonos AS $TT) {
												$selected = "";
												if($TT['IdTiposTelefonos'] == $TN['IdTiposTelefonos']){
													$selected = ' selected ';
												}
												echo '<option value="'.$TT['IdTiposTelefonos'].'" '.$selected.'>'.$TT['Nombre'].'</option>';
											}
										}
									}
									?>
								</select>
							</td>
							<td>
								<input type="text" name="NumeroTelefonoNotaria[]" class="form-control" value="<?=$TN['NumeroTelefono']?>">	
							</td>
							<td>
								<input type="text" name="ExtensionNumeroTelefonoNotaria[]" class="form-control" value="<?=$TN['Extension']?>">	
							</td>
						</tr>
								<?php
							}
						}
					}

					if($TelefonosEnCrecion){
						?>
					<tr>
						<td>
							<select name="IdTiposTelefonosNotaria[]" class="form-control">
								<option value="">Seleccionar tipo telefono</option>
								<?php 
								if(isset($TiposTelefonos)){
									if(!empty($TiposTelefonos)){
										foreach ($TiposTelefonos AS $TT) {
											echo '<option value="'.$TT['IdTiposTelefonos'].'">'.$TT['Nombre'].'</option>';
										}
									}
								}
								?>
							</select>
						</td>
						<td>
							<input type="text" name="NumeroTelefonoNotaria[]" class="form-control">	
						</td>
						<td>
							<input type="text" name="ExtensionNumeroTelefonoNotaria[]" class="form-control">	
						</td>
					</tr>
						<?php
					}
					?>					
				</tbody>
			</table>
		</div>
		<button type="button" onclick="AgregarFilaTabla('TableTelefonosNotaria', 'FilaTelefonoNotaria')"  class="btn btn-danger">Agregar</button>
  	</div>
</div>