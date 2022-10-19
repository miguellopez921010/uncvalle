<?php 
use yii\helpers\Url;
use app\assets\MesaAsset;

MesaAsset::register($this);
?>

<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <thead>
            <tr>
                <th class="text-center">Numero Mesa</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($ListaMesas)){
                foreach ($ListaMesas AS $Mesa){
                    echo '<tr class="text-center">';
                        echo '<td>'.$Mesa['NumeroMesa'].'</td>';
                        echo '<td id="tdBtnActivarMesa_'.$Mesa['Idmesas'].'">'.($Mesa['Estado']==1?'<b>Activar</b> / <a class="btn btn-link" onclick="CambiarEstadoMesa('.$Mesa['Idmesas'].', 0)">Desactivar</a>':'<a class="btn btn-link" onclick="CambiarEstadoMesa('.$Mesa['Idmesas'].', 1)">Activar</a> / <b>Desactivar</b>').'</td>';
                    echo '</tr>';
                }
            }else{
                echo '<tr class="text-center">';
                    echo '<td colspan="3"><h4>No hay registros</h4></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>