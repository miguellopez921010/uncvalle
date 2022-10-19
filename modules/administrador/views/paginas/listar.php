<?php 
use yii\helpers\Url;
?>

<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <thead>
            <tr>
            	<th class="text-center">Id Pagina</th>
                <th class="text-center">Nombre Pagina</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($Paginas)){
                foreach ($Paginas AS $Pagina){
                    echo '<tr class="text-center">';
                    	echo '<td>'.$Pagina['IdPaginas'].'</td>';
                        echo '<td>'.$Pagina['NombrePagina'].'</td>';
                        echo '<td><button class="btn btn-primary btn-sm" title="Editar" alt="Editar" onclick="window.location.href = \''.Url::to(['/administrador/paginas/editar', 'IdPaginas' => $Pagina['IdPaginas']]).'\'"><span class="glyphicon glyphicon-edit"></span></button></td>';
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
