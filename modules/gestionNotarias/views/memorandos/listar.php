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
                <th class="text-center">Nombre memorando</th>
                <th class="text-center">Categoria</th>
                <th class="text-center">Fecha hora registro</th>
                <th class="text-center">Fecha hora modificacion</th>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($Memorandos)){
                foreach ($Memorandos AS $Memorando){
                    echo '<tr class="text-center">';
                        echo '<td>'.$Memorando['NombreMemorando'].'</td>';
                        echo '<td>'.$Memorando['NombreCategoria'].'</td>';                        
                        echo '<td>'.$Memorando['FechaHoraRegistro'].'</td>';
                        echo '<td>'.$Memorando['FechaHoraModificacion'].'</td>';
                        echo '<td><button class="btn btn-success" title="Cargar archivos" alt="Cargar archivos" onclick="window.location.href = \''.Url::to(['/gestionNotarias/memorandos/cargar-archivos', 'IdMemorandos' => $Memorando['IdMemorandos']]).'\'"><span class="glyphicon glyphicon-book"></span></button></td>';
                        echo '<td><button class="btn btn-primary" title="Editar" alt="Editar" onclick="window.location.href = \''.Url::to(['/gestionNotarias/memorandos/editar', 'IdMemorandos' => $Memorando['IdMemorandos']]).'\'"><span class="glyphicon glyphicon-edit"></span></button></td>';
                        echo '<td><button class="btn btn-danger" title="Eliminar" alt="Eliminar" onclick="EliminarMemorando('.$Memorando['IdMemorandos'].')"><span class="glyphicon glyphicon-remove"></span></button></td>';
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