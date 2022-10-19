<?php
use app\assets\AppAsset;
use app\assets\NotariasAsset;

AppAsset::register($this);
NotariasAsset::register($this);
?>

<form id="formCargarArchivosComunicaciones" name="formCargarArchivosComunicaciones" action="cargar-archivos-tmp-comunicaciones" class="dropzone">
    <!--<input type="file" name="file" />-->
    <input type="hidden" id="IdComunicaciones" name="IdComunicaciones" value="<?=$IdComunicaciones?>" >
</form>