<?php 
use app\components\Configuracion;

$Config = new Configuracion();
$Configuracion = $Config->ObtenerConfiguracion();
?>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <?=$Configuracion['Nombre']?>
                <br>
                Nit <?=$Configuracion['Nit']?>
            </div>
            <div class="col-md-4">
                <?=$Configuracion['Direccion']?>
                <br>
                Tel&eacute;fonos: <?=$Configuracion['TelefonoFijo']?> - <?=$Configuracion['TelefonoMovil']?>
                <br>
                Correo electr&oacute;nico: <?=$Configuracion['CorreoElectronico']?>
            </div>
            <div class="col-md-4">
                Ing. Miguel Lopez
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center" style="border-top: 1px solid; padding: 10px;">
                <label>Total visitas: <?=$Configuracion['TotalVisitas']?></label>
            </div>
        </div>
    </div>
</footer>