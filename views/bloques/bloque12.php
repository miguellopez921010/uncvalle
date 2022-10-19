<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$SeccionesPorBloque = $Secciones->ObtenerSeccionesPorBloque(12);
?>
<div class="row">
    <div id="bloque-12" class="col-lg-12">
        <?php 
		if(!empty($SeccionesPorBloque)){
		?>
		<div class="row">		
			<?php
				foreach($SeccionesPorBloque AS $Seccion){
				    ?>
				    <div id="seccion-<?=$Seccion['IdSecciones']?>" class="col-md-<?=$Seccion['CantidadCampos']?>">
				        <?php 
				        echo $this->render('/secciones/'.$Seccion['NombreArchivo']);
				        ?>
				    </div>
				    <?php
				}
			}
			?>
		</div>
		<?php
        ?>
    </div>
</div>