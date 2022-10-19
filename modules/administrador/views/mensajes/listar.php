<?php 
use yii\helpers\Url;
?>

<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <thead>
            <tr>
                <th class="text-center">Nombre</th>
                <th class="text-center">Correo</th>
                <th class="text-center">Asunto</th>
                <th class="text-center">Mensaje</th>
                <th class="text-center">Fecha Hora Registro</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($MensajesContactenos)){
                foreach ($MensajesContactenos AS $Mensaje){
                    echo '<tr class="text-center">';
                        echo '<td>'.$Mensaje['Nombre'].'</td>';
                        echo '<td>'.$Mensaje['Correo'].'</td>';
                        echo '<td>'.$Mensaje['Asunto'].'</td>';
                        echo '<td><a class="btn btn-link" onclick="VerMensajeContactenos('.$Mensaje['IdMensajesContactenos'].')">Ver Mensaje...</a></td>';
                        echo '<td>'.$Mensaje['FechaHoraRegistro'].'</td>';
                    echo '</tr>';
                }
            }else{
                echo '<tr class="text-center">';
                    echo '<td colspan="5"><h4>No hay registros</h4></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>
