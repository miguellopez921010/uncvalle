<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
	<?php 
	if(isset($BloquesPagina)){
		if(!empty($BloquesPagina)){
			foreach($BloquesPagina AS $Bloque){
				echo $this->render('/bloques/'.$Bloque['NombreArchivo']);
			}
		}
	}
	?>
</div>
