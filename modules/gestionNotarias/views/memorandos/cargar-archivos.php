<?php
use app\assets\AppAsset;
use app\assets\NotariasAsset;

AppAsset::register($this);
NotariasAsset::register($this);
?>

<form id="formCargarArchivosMemorando" name="formCargarArchivosMemorando" action="cargar-archivos-tmp-memorando" class="dropzone">
    <!--<input type="file" name="file" />-->
    <input type="hidden" id="IdMemorandos" name="IdMemorandos" value="<?=$IdMemorandos?>" >
</form>