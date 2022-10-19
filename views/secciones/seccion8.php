<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(8);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion8---</i>';
    }
}
?>

<label>CONSEJO DIRECTIVO DE UNIVOC PARA EL PERIODO 2019 â€“ 2021.</label>
    
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
	  	<div class="panel-body">
	  		<h2 class="text-center">PRINCIPALES</h2>
	    		<fieldset>
	    			<legend>PRESIDENTE</legend>
	    			<b>HOLMES RAFAEL CARDONA MONTOYA</b><br>
	    			<i>NOTARIO VEINTIUNO DE CALI</i>
	    		</fieldset>
	    		<hr>
	    		<fieldset>
	    			<legend>VICEPRESIDENTE</legend>
	    			<b>GLORIA MARINA RESTREPO CAMPO</b><br>
	    			<i>NOTARIA QUINTA DE CALI</i>
	    		</fieldset>
	    		<hr>
	    		<fieldset>
	    			<legend>SECRETARIA</legend>
	    			<b>GLORIA AMPARO PEREA GALLÃ“N</b><br>
	    			<i>NOTARIA UNICA DE LA CUMBRE VALLE</i>
	    			<br>
	    			<br>
	    			<b>CLAUDIA PATRICIA SALDARRIAGA MARTINEZ</b><br>
	    			<i>NOTARIA UNICA DE CORINTO CAUCA</i>
	    			<br>
	    			<br>
	    			<b>JULIO ALEXANDER DELGADO ENRÃ?QUEZ</b><br>
	    			<i>NOTARIO SEGUNDO DE TUQUERRES NARIÃ‘O</i>
	    		</fieldset>		    		
	  	</div>
	</div>    		
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
	  	<div class="panel-body">
	  		<h2 class="text-center">SUPLENTES</h2>
	    		<fieldset>
	    			<legend>PRESIDENTE</legend>
	    			<b>LUZ MARINA GARCÃ?A BASTIDAS</b><br>
	    			<i>NOTARIA UNICA DE TORO VALLE</i>
	    		</fieldset>
	    		<hr>
	    		<fieldset>
	    			<legend>VICEPRESIDENTE</legend>
	    			<b>ZULMA YULIETH SANDOVAL MOSQUERA</b><br>
	    			<i>NOTARIA UNICA DE CALDONO CAUCA</i>
	    		</fieldset>
	    		<hr>
	    		<fieldset>
	    			<legend>SECRETARIA</legend>
	    			<b>HÃ‰CTOR FABIO CÃ“RDOBA CORTES</b><br>
	    			<i>NOTARIO UNICO DE MIRANDA CAUCA</i>
	    			<br>
	    			<br>
	    			<b>HAROLD AUGUSTO MONTOYA URDINOLA</b><br>
	    			<i>NOTARIO UNICO DE EL DOVIO VALLE</i>
	    			<br>
	    			<br>
	    			<b>ALFONSO RUIZ RAMÃ?REZ</b><br>
	    			<i>NOTARIO ONCE DE CALI</i>
	    		</fieldset>		    		
	  	</div>
	</div>    		
	</div>
</div>

  <div class="row">
  	<div class="col-md-3"></div>
  	<div class="col-md-6">
  		<div class="panel panel-default">
		  	<div class="panel-body">
		    		<fieldset>
		    			<legend>VEEDOR PARA LAS CAUSAS ETICAS NOTARIALES</legend>
		    			<b>FABIÃ?N MAURICIO MEDINA CABRERA</b><br>
		    			<i>NOTARIO PRIMERO DE SEVILLA VALLE DEL CAUCA</i>
		    		</fieldset>
		    		<hr>
		    		<fieldset>
		    			<legend>TRIBUNAL SECCIONAL DE ETICA NOTARIAL</legend>
		    			<b>JAIME HERNÃ?N CORREA OREJUELA</b><br>
		    			<i>EX NOTARIO</i>
		    			<br>
		    			<br>
		    			<b>SONIA ESCALANTE ARIAS</b><br>
		    			<i>NOTARIA 16 DE SANTIAGO DE CALI</i>
		    			<br>
		    			<br>
		    			<b>FERNANDO VÃ‰LEZ ROJAS</b><br>
		    			<i>NOTARIO SEGUNDO DE PALMIRA</i>
		    		</fieldset>
		    		<hr>
		    		<fieldset>
		    			<legend>DIRECTORA EJECUTIVA â€“ TESORERA DE "UNIVOC"</legend>
		    			<b>YOLANDA RICO BRAVO</b>
		    		</fieldset>		    		
		  	</div>
		</div>
  	</div>
  	<div class="col-md-3"></div>
  </div>