<div class="form-group">
    <label>Nombre</label>
    <input type="text" class="form-control input-lg" readonly="true" value="<?= $RegistroMensajeContactenos['Nombre']; ?>" />
</div>
<div class="form-group">
    <label>Correo</label>
    <input type="text" class="form-control input-lg" readonly="true" value="<?= $RegistroMensajeContactenos['Correo']; ?>" />
</div>
<div class="form-group">
    <label>Asunto</label>
    <input type="text" class="form-control input-lg" readonly="true" value="<?= $RegistroMensajeContactenos['Asunto']; ?>" />
</div>
<div class="form-group">
    <label>Mensaje</label>
    <textarea class="form-control input-lg" readonly="true" rows="10"><?= $RegistroMensajeContactenos['Mensaje']; ?></textarea>
</div>


<?php
/*
  array(6) { ["IdMensajesContactenos"]=> string(2) "15" ["Nombre"]=> string(12) "olga escobar" ["Correo"]=> string(27) "olgaescobar2022@hotmail.com" ["Asunto"]=> string(31) "irregularidad servicio notarial" ["Mensaje"]=> string(678) "el dia de hoy 3 de febrero me acerque a las instalaciones de la NOTARIA CUARTA DE PALMIRA VALLE DEL CAUCA para hacer una cotizacion para los tramites de una escritura encontrandome con una situacion que me causo algo de sorpresa, ya que encontre 3 oficinas de escrituracion y para mi sorpresa en las 3 oicinas me presentaron cotizaciones con valores diferentes para lo que yo queria realizar, dejandome una duda enorme de los valores que manejan en cada oficina y la no generalizacion de los mismos, para mayor sorpresa una de las oficinas no se encuentra viculada directamente con la notaria si no que manifestaron ser externos a ella y que prestan sus servicios a la notaria, " ["FechaHoraRegistro"]=> string(19) "2021-02-03 21:37:37" }
 *  */
?>