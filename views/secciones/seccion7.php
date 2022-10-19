<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(7);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion7---</i>';
    }
}
?>

<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d995.6324147542683!2d-76.52418573728718!3d3.463786317641026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e30a78043d4cd4d%3A0xdfab2132582c670!2sUNION%20COLEGIADA%20DE%20NOTARIADO%20VALLECAUCANO%20Y%20DEL%20SUROCCIDENTE%20COLOMBIANO%20%E2%80%9CUNIVOC%E2%80%9D!5e0!3m2!1ses-419!2sco!4v1584669364356!5m2!1ses-419!2sco" height="450" frameborder="0" style="border:0; width: 100%;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>