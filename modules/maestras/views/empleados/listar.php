<?php 
use yii\helpers\Url;
use app\assets\EmpleadoAsset;

EmpleadoAsset::register($this);
?>

<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <thead>
            <tr>
                <th class="text-center">Numero Documento</th>
                <th class="text-center">Nombre Completo</th>
                <th class="text-center">Email</th>
                <th class="text-center">Cargo</th>
                <th class="text-center">Estado</th>
                <th class="text-center"></th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($ListaUsuarios)){
                foreach ($ListaUsuarios AS $Usuario){
                    echo '<tr class="text-center">';
                        echo '<td>'.$Usuario['NumeroDocumento'].'</td>';
                        echo '<td>'.$Usuario['Nombres'].' '.$Usuario['Apellidos'].'</td>';
                        echo '<td>'.$Usuario['Email'].'</td>';
                        echo '<td>'.$Usuario['NombreCargo'].'</td>';
                        echo '<td id="tdBtnActivarUsuario_'.$Usuario['IdUsuario'].'">'.($Usuario['estado']==1?'<b>Activar</b> / <a class="btn btn-link" onclick="CambiarEstadoUsuario('.$Usuario['IdUsuario'].', 0)">Desactivar</a>':'<a class="btn btn-link" onclick="CambiarEstadoUsuario('.$Usuario['IdUsuario'].', 1)">Activar</a> / <b>Desactivar</b>').'</td>';
                        echo '<td><button class="btn btn-default btn-sm" alt="Cambiar contraseña" title="Cambiar contraseña" onclick="window.location.href = \''.Url::to(['/maestras/empleados/cambiar-contrasena', 'IdUsuario' => $Usuario['IdUsuario']]).'\'"><span class="glyphicon glyphicon-random"></span></button></td>';
                        echo '<td><button class="btn btn-primary btn-sm" title="Editar" alt="Editar" onclick="window.location.href = \''.Url::to(['/maestras/empleados/editar', 'IdUsuario' => $Usuario['IdUsuario']]).'\'"><span class="glyphicon glyphicon-edit"></span></button></td>';
                    echo '</tr>';
                }
            }else{
                echo '<tr class="text-center">';
                    echo '<td colspan="7"><h4>No hay registros</h4></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>