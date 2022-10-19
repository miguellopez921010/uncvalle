<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(10);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion10---</i>';
    }
}
?>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="required">Departamentos</label>
			<select class="form-control" id="IdDepartamento" name="IdDepartamento" required="true" onchange="ListarCiudadesPorDepartamento(); CargarDirectorioNotarias();">
				<option value="">Seleccionar departamento</option>
				<?php 
				$Departamentos = $Datos['Departamentos'];

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
			<select class="form-control" id="IdCiudad" name="IdCiudad" required="true" onchange="CargarDirectorioNotarias()">
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

<div id="ListadoDirectorioNotarias">
	
</div>

<script type="text/javascript">
	function CargarDirectorioNotarias(){
		var IdDepartamento = $('select#IdDepartamento').val();
		var IdCiudad = $('select#IdCiudad').val();

		CargarDiv('ListadoDirectorioNotarias', 1, '/site/listar-directorio-notarias', {'IdDepartamento': IdDepartamento, 'IdCiudad': IdCiudad});
	}
</script>