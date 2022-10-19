<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(6);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion6---</i>';
    }
}
?>

<form id="FormContactenos" name="FormContactenos">
    <div class="form-group">
        <label for="Nombre" class="required">Nombre</label>
        <input required="true" type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Nombre">
    </div>
    <div class="form-group">
        <label for="Correo" class="required">Correo</label>
        <input required="true" type="email" class="form-control" id="Correo" name="Correo" placeholder="Correo">
    </div>
    <div class="form-group">
        <label for="Asunto" class="required">Asunto</label>
        <input required="true" type="text" class="form-control" id="Asunto" name="Asunto" placeholder="Asunto">
    </div>
    <div class="form-group">
        <label for="Mensaje" class="required">Mensaje</label>
        <textarea required="true" rows="6" class="form-control" id="Mensaje" name="Mensaje" placeholder="Mensaje" style="resize: none;"></textarea>
    </div>
    
    <div class="form-group text-center">
        <button class="btn btn-success">Enviar</button>
    </div>
</form>

<label class="required">Campos obligatorios</label>