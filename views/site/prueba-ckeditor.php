<?php
use app\assets\ModulosAsset;

ModulosAsset::register($this);
?>

<form id="FormEditor1" name="FormEditor1">
    <textarea name="editor1" id="editor1" rows="10" cols="80">
        This is my textarea to be replaced with CKEditor.
    </textarea>
    
    <button type="button" onclick="ValorCKEditor()">ddfg</button>
</form>