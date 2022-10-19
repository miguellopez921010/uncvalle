<?php 
use yii\helpers\Url;

use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(3);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion3---</i>';
    }
}

if(isset($Datos['Opciones'])){
    if(!empty($Datos['Opciones'])){
        ?>
    <div>
        <div class="row">
            <?php
            foreach($Datos['Opciones'] AS $Opcion){
                ?>
            <div class="col-sm-6">
                <a class="btn btn-link" <?=($Opcion['CargueInformacion']==1?'href="'.$Opcion['Url'].'"':'onclick="CargarDiv()"')?> style="width: 100%; display: table;	height:150px;">
                    <div style="border: 1px solid; width: 100%; height: 100%; display: table-cell; vertical-align: middle;">
                        <?=$Opcion['Nombre']?>
                    </div>
                </a>
            </div>
                <?php
            }
            ?>
        </div>
    </div>
        <?php
    }
}
?>

<div style="border: 1px solid #ddd; padding: 5px;">
    <iframe style="width: 100%; height: auto;" src="https://www.youtube.com/embed/Sqo_iLjLSdE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>