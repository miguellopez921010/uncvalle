<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(2);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion2---</i>';
    }
}
?>

<div>
    <fieldset>
        <legend>&Uacute;LTIMAS NOTICIAS</legend>
        
        <?php 
        if(isset($Datos['Noticias'])){
            if(!empty($Datos['Noticias'])){
                ?>
            <div class="row">
                <?php
                foreach($Datos['Noticias'] AS $Noticia){
                    ?>
                <div class="col-sm-<?=($Noticia['Prioridad']==1?'12':'6')?>">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b><?=$Noticia['Titulo']?></b></div>
                        <div class="panel-body">
                            <?=$Noticia['Resumen']?>
                        </div>
                        <div class="panel-footer text-right"><?='Fecha publicaci&oacute;n: '.$Noticia['FechaPublicacion']?></div>
                    </div>
                </div>
                    <?php
                    
                }
                ?>
            </div>
                <?php
            }else{
                ?>
                <p class="text-center" style="padding: 10px;">
                    <?php
                    echo 'No hay noticias disponibles en el momento';
                    ?>
                </p>
                <?php
            }
        }
        ?>
    </fieldset>
</div>