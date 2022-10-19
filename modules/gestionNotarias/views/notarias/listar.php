<?php 
use yii\helpers\Url;
//use app\assets\EmpleadoAsset;

//EmpleadoAsset::register($this);
?>

<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <thead>
            <tr>
                <th class="text-center">Nombre Notaria</th>
                <th class="text-center">Numero Notaria</th>
                <th class="text-center">Departamento</th>
                <th class="text-center">Ciudad</th>
                <th class="text-center">Direccion</th>
                <th class="text-center">Barrio</th>
                <th class="text-center">Estado</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($Notarias)){
                foreach ($Notarias AS $Notaria){
                    echo '<tr class="text-center">';
                        echo '<td>'.$Notaria['NombreNotaria'].'</td>';
                        echo '<td>'.$Notaria['NumeroNotaria'].'</td>';
                        echo '<td>'.$Notaria['NombreDepartamento'].'</td>';
                        echo '<td>'.$Notaria['NombreCiudad'].'</td>';
                        echo '<td>'.$Notaria['Direccion'].'</td>';
                        echo '<td>'.$Notaria['Barrio'].'</td>';
                        echo '<td id="tdBtnActivarNotaria_'.$Notaria['IdNotarias'].'">'.($Notaria['Estado']==1?'<b>Activar</b> / <a class="btn btn-link" onclick="CambiarEstadoEquipo('.$Notaria['IdNotarias'].', 0)">Desactivar</a>':'<a class="btn btn-link" onclick="CambiarEstadoEquipo('.$Notaria['IdNotarias'].', 1)">Activar</a> / <b>Desactivar</b>').'</td>';
                        echo '<td><button class="btn btn-primary btn-sm" title="Editar" alt="Editar" onclick="window.location.href = \''.Url::to(['/gestionNotarias/notarias/editar', 'IdNotarias' => $Notaria['IdNotarias']]).'\'"><span class="glyphicon glyphicon-edit"></span></button></td>';
                    echo '</tr>';
                }
            }else{
                echo '<tr class="text-center">';
                    echo '<td colspan="8"><h4>No hay registros</h4></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>