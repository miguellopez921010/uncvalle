<?php

use app\assets\MesaAsset;

MesaAsset::register($this);
 
if(!empty($MesasDisponibles) && !empty($EquiposMesas)){
	if(count($MesasDisponibles) <= count($EquiposMesas)){
	?>
<p class="text-justify">Cada una de las mesas activas debe tener un equipo asociado.</p>
<form id="FormAsignarEquipoaMesa" name="FormAsignarEquipoaMesa" method="POST">
	<div class="table-responsive">
		<table class="table table-bordered table-condensed">
			<thead>
				<tr>
					<th class="text-center">Mesa</th>
					<th class="text-center">Equipo</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($MesasDisponibles AS $Mesa) {
					echo '<tr id="TrEquipoMesa_'.$Mesa['Idmesas'].'" class="text-center">';
						echo '<td><h4>'.$Mesa['NumeroMesa'].'</h4><input type="hidden" id="IdMesa_'.$Mesa['Idmesas'].'" name="IdMesa[]" value="'.$Mesa['Idmesas'].'"></td>';
						echo '<td style="width: 400px">';
							echo '<select required="true" id="EquipoMesa_'.$Mesa['Idmesas'].'" name="EquipoMesa_'.$Mesa['Idmesas'].'" class="form-control">';
								echo '<option value="">Seleccionar equipo</option>';
								foreach ($EquiposMesas AS $Equipo){
									$selected = "";
									if(isset($EquiposMesasAsignados)){
										if(!empty($EquiposMesasAsignados)){
											foreach ($EquiposMesasAsignados AS $EquipoMesaAsignado) {
												if($EquipoMesaAsignado['Idmesas'] == $Mesa['Idmesas']){
													if($Equipo['Idequipos'] == $EquipoMesaAsignado['Idequipos']){
														$selected = " selected ";
													}
												}
											}
										}
									}
									echo '<option value="'.$Equipo['Idequipos'].'" '.$selected.'>'.$Equipo['Nombre'].'</option>';							
								}
							echo '</select>';
						echo '</td>';
					echo '</tr>';
				}			
				?>
			</tbody>
		</table>
	</div>

	<div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>
	<?php
	}else{
		echo '<h4 class="text-center">La cantidad de mesas activas debe ser menor o igual a la cantidad de equipos activos (1 equipo por cada mesa).</h4>';
	}	
}else{
	echo '<h4 class="text-center">No hay Mesas activas en este momento o no se han creado Equipos para las mesas. Por favor verificar.</h4>';
}
?>

