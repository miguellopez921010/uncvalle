<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

if(isset($NombrePagina)){
    if($NombrePagina != null){
        $this->title = str_replace(['-'], ' ', $NombrePagina);
        $this->params['breadcrumbs'][] = $this->title;
    }
}
?>
<div class="site-contactenos">
    <?php 
    if(isset($NombrePagina)){
        if($NombrePagina != null){
            ?>
            <h1 class="titulo-pagina"><?=str_replace(['-'], ' ', $NombrePagina)?></h1>
            <?php
        }
    }
    
	if(isset($BloquesPagina)){
		if(!empty($BloquesPagina)){
			foreach($BloquesPagina AS $Bloque){
				echo $this->render('/bloques/'.$Bloque['NombreArchivo']);
			}
		}
	}
	?>
</div>
