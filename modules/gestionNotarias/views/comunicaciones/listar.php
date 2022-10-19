<?php 
use yii\helpers\Url;
use app\assets\AppAsset;
use app\assets\NotariasAsset;

AppAsset::register($this);
NotariasAsset::register($this);
?>

<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <thead>
            <tr>
                <th class="text-center">Nombre comunicacion</th>
                <th class="text-center">Fecha hora registro</th>
                <th class="text-center">Fecha hora modificacion</th>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($Comunicaciones)){
                foreach ($Comunicaciones AS $Comunicacion){
                    echo '<tr class="text-center">';
                        echo '<td>'.$Comunicacion['NombreComunicacion'].'</td>';
                        echo '<td>'.$Comunicacion['FechaHoraRegistro'].'</td>';
                        echo '<td>'.$Comunicacion['FechaHoraModificacion'].'</td>';
                        echo '<td><button class="btn btn-success" title="Cargar archivos" alt="Cargar archivos" onclick="window.location.href = \''.Url::to(['/gestionNotarias/comunicaciones/cargar-archivos', 'IdComunicaciones' => $Comunicacion['IdComunicaciones']]).'\'"><span class="glyphicon glyphicon-book"></span></button></td>';
                        echo '<td><button class="btn btn-primary" title="Editar" alt="Editar" onclick="window.location.href = \''.Url::to(['/gestionNotarias/comunicaciones/editar', 'IdComunicaciones' => $Comunicacion['IdComunicaciones']]).'\'"><span class="glyphicon glyphicon-edit"></span></button></td>';
                        echo '<td><button class="btn btn-danger" title="Eliminar" alt="Eliminar" onclick="EliminarComunicacion('.$Comunicacion['IdComunicaciones'].')"><span class="glyphicon glyphicon-remove"></span></button></td>';
                    echo '</tr>';
                }
            }else{
                echo '<tr class="text-center">';
                    echo '<td colspan="6"><h4>No hay registros</h4></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>