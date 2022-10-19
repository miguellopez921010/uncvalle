<?php

use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(1);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion1---</i>';
    }
}
?>

<div>
    <?php
    if (isset($Datos['Banners'])) {
        if (!empty($Datos['Banners'])) {
            //<div <!--class="slider"-->>
            ?>
            <div style="border: 1px solid #eee; margin-bottom: 15px;">
                <?php
                foreach ($Datos['Banners'] AS $B) {
                    ?>
                    <div>
                        <?php
                        if ($B['Enlace'] != null) {
                            ?>
                            <a href="<?= $B['Enlace'] ?>">
                                <?php
                            }
                            ?>
                            <img src="<?= Yii::getAlias('@web') . 'images/' . $B['RutaCarpeta'] . '/' . $B['NombreImagen'] ?>" class="img-responsive">
                            <?php
                            if ($B['Enlace'] != null) {
                                ?>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
    ?>
</div>