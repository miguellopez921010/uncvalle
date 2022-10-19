<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(9);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion9---</i>';
    }
}
?>

<div class="site-estatutos">
    <iframe src="http://online.fliphtml5.com/iwhdz/jpiw/" height="600" style="width:100%"></iframe>
</div>