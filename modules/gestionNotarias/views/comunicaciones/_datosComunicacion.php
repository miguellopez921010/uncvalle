<fieldset>
	<legend>Datos Comunicaciones</legend>

    <?php 
	if(isset($InfoComunicacion)){
		if(!empty($InfoComunicacion)){
			?>
	<input type="hidden" id="IdComunicaciones" name="IdComunicaciones" value="<?=$InfoComunicacion['IdComunicaciones']?>">
			<?php
		}
	}
	?>
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="required">Nombre</label>
				<input type="text" name="NombreComunicacion" id="NombreComunicacion" class="form-control" required="true" value="<?php 
				if(isset($InfoComunicacion)){
					if(!empty($InfoComunicacion)){
						echo $InfoComunicacion['NombreComunicacion'];
					}
				}
				?>">
			</div>
		</div>	
	</div>
</fieldset>