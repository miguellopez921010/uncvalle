<?php 
use yii\helpers\Url;
?>

<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <thead>
            <tr>
                <th class="text-center">Nombre</th>
                <th class="text-center">Descripcion</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Orden</th>
                <th class="text-center">Cantidad campos</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($Secciones)){
                foreach ($Secciones AS $Seccion){
                    echo '<tr class="text-center">';
                        echo '<td>'.$Seccion['NombreSeccion'].'</td>';
                        echo '<td>'.$Seccion['DescripcionSeccion'].'</td>';
                        echo '<td id="tdBtnActivarNotaria_'.$Seccion['IdSecciones'].'">'.($Seccion['Estado']==1?'<b>Activar</b> / <a class="btn btn-link" onclick="CambiarEstadoEquipo('.$Seccion['IdSecciones'].', 0)">Desactivar</a>':'<a class="btn btn-link" onclick="CambiarEstadoEquipo('.$Seccion['IdSecciones'].', 1)">Activar</a> / <b>Desactivar</b>').'</td>';
                        echo '<td>'.$Seccion['Orden'].'</td>';
                        echo '<td>'.$Seccion['CantidadCampos'].'</td>';
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
