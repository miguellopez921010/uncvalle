<?php 
use yii\helpers\Url;
use app\assets\EquiposAsset;

EquiposAsset::register($this);
?>

<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <thead>
            <tr>
                <th class="text-center">Nombre</th>
                <th class="text-center">Marca</th>
                <th class="text-center">Serie</th>
                <th class="text-center">IMEI</th>
                <th class="text-center">IP</th>
                <th class="text-center">Tipo Equipo</th>
                <th class="text-center">Estado</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($ListaEquipos)){
                foreach ($ListaEquipos AS $Equipo){
                    echo '<tr class="text-center">';
                        echo '<td>'.$Equipo['Nombre'].'</td>';
                        echo '<td>'.$Equipo['Marca'].'</td>';
                        echo '<td>'.$Equipo['NumeroSerie'].'</td>';
                        echo '<td>'.$Equipo['IMEI'].'</td>';
                        echo '<td>'.$Equipo['DireccionIP'].'</td>';
                        echo '<td>'.$Equipo['NombreTipoEquipo'].'</td>';
                        echo '<td id="tdBtnActivarEquipo_'.$Equipo['Idequipos'].'">'.($Equipo['Estado']==1?'<b>Activar</b> / <a class="btn btn-link" onclick="CambiarEstadoEquipo('.$Equipo['Idequipos'].', 0)">Desactivar</a>':'<a class="btn btn-link" onclick="CambiarEstadoEquipo('.$Equipo['Idequipos'].', 1)">Activar</a> / <b>Desactivar</b>').'</td>';
                        echo '<td><button class="btn btn-primary btn-sm" title="Editar" alt="Editar" onclick="window.location.href = \''.Url::to(['/maestras/equipos/editar', 'IdEquipo' => $Equipo['Idequipos']]).'\'"><span class="glyphicon glyphicon-edit"></span></button></td>';                        
                    echo '</tr>';
                }
            }else{
                echo '<tr class="text-center">';
                    echo '<td colspan="4"><h4>No hay registros</h4></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>