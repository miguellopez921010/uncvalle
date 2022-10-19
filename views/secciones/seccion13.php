<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(13);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion13---</i>';
    }
}

if(isset($AnioDefecto)){
}

if(isset($Datos['Opciones'])){
    if(!empty($Datos['Opciones'])){
        ?>
    <p>Seleccione el A&ntilde;o a consultar</p>
    <ul class="nav nav-tabs">
        <?php
        foreach($Datos['Opciones'] AS $Opcion){
            ?>
        <li id="pestana-permanenciaesaldian-<?=$Opcion['Nombre']?>" class="pestanas-permanenciaesaldian"><a <?=($Opcion['CargueInformacion']==1?'href="'.$Opcion['Url'].'"':$Opcion['CargueInformacion']==2?' onclick="CargarDiv(\'ContenidoPermanenciaEsalDian\',1,\''.$Opcion['Url'].'\', {Anio:'.$Opcion['Nombre'].'}); PestanaActual(\'pestana-permanenciaesaldian-'.$Opcion['Nombre'].'\', \'pestanas-permanenciaesaldian\'); " ':'')?>><?=$Opcion['Nombre']?></a></li>
            <?php
        }
        ?>
    </ul>
    
    <div id="ContenidoPermanenciaEsalDian">
        
    </div>
        <?php
    }
}
?>