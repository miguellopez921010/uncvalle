<div class="table-responsive">
	<table class="table table-condensed table-striped table-bordered">
		<thead>
			<tr>
				<th class="text-center">Imagen</th>
				<th class="text-center">Tipo imagen</th>
				<th class="text-center">Enlace</th>
				<th class="text-center">Comentario</th>
				<th class="text-center">Estado</th>
				<?php
				if (!Yii::$app->user->isGuest) {
				    $UsuarioLogueado = Yii::$app->user->id;

				    if ($UsuarioLogueado == 1) {
				        ?>
				<th class="text-center">Eliminar</th>
				        <?php
				    }
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?php 
			if(!empty($ListaImagenes)){
				foreach($ListaImagenes AS $I){
					?>
			<tr class="text-center">
				<td><img src="<?= Yii::getAlias('@web') . '/images/' . $I['RutaCarpeta'] . '/' . $I['NombreImagen'] ?>" class="img-responsive" width="150" style="margin: 5px auto;"></td>
				<td><?=$TiposImagenesPermitido[$I['IdTiposImagenes']]?></td>
				<td><?=$I['Enlace']?></td>
				<td><?=$I['Comentario']?></td>
				<td><?=($I['Estado']==1?'<b>ACTIVO</b> / <a onclick="CambiarEstadoImagen('.$I['IdImagenes'].',0)">INACTIVAR</a>':'<a onclick="CambiarEstadoImagen('.$I['IdImagenes'].',1)">ACTIVAR</a> / <b>INACTIVO</b>')?></td>
				<?php
				if (!Yii::$app->user->isGuest) {
				    $UsuarioLogueado = Yii::$app->user->id;

				    if ($UsuarioLogueado == 1) {
				        ?>
				<td><button class="btn btn-danger" onclick="EliminarImagen(<?=$I['IdImagenes']?>)">Eliminar</button></td>
				        <?php
				    }
				}
				?>
			</tr>
					<?php
				}
			}else{
				?>
			<tr>
				<td colspan="3">No hay registros</td>
			</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>
