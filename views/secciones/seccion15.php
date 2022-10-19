<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(15);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion15---</i>';
    }
}

if(isset($Datos['Comunicaciones'])){
    if(!empty($Datos['Comunicaciones'])){
        ?>
<div class="list-group list-group-flush">
        <?php 
        foreach ($Datos['Comunicaciones'] AS $Memorando){
            ?>
            <a href="/site/ver-comunicado?IdComunicaciones=<?=$Memorando['IdComunicaciones']?>" class="list-group-item list-group-item-action"><?=$Memorando['NombreComunicacion']?></a>
            <?php
        }
        ?>
</div>
        <?php
    }else{
        echo 'No hay comunicaciones en este momento.';
    }
}
?>