<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(12);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion12---</i>';
    }
}

if (isset($Datos['Galeria'])) {
    if(!empty($Datos['Galeria'])){
        ?>
        <div class="row">
            <?php 
            foreach($Datos['Galeria'] AS $G){
                ?>
            <div class="col-lg-3 col-md-4 col-sm-3 col-xs-6" style="border: 1px solid #ccc;">
                <a onclick="CargarImagenEnModal(<?=$G['IdImagenes']?>)">
                    <img src="<?= Yii::getAlias('@web') . '/images/' . $G['RutaCarpeta'] . '/' . $G['NombreImagen'] ?>" class="img-responsive" style="margin: 5px auto;" width="300" title="<?=$G['Comentario']?>">
                </a>
            </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}
?>