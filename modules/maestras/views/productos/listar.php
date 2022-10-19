<?php 
use yii\helpers\Url;
use app\assets\EmpleadoAsset;

EmpleadoAsset::register($this);
?>

<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <thead>
            <tr>
                <th class="text-center">Categoria</th>
                <th class="text-center">Codigo</th>
                <th class="text-center">Consecutivo</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Color</th>
                <th class="text-center">Estado</th>
                <th class="text-center"></th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($Productos)){
                foreach ($Productos AS $P) {
                    ?>
            <tr class="text-center">
                <td><?=$P['NombreCategoria']?></td>
                <td><?=$P['Codigo']?></td>
                <td><?=$P['Consecutivo']?></td>
                <td><?=$P['Nombre']?></td>
                <td><?=$P['NombreColor']?></td>
                <td><?=$P['Estado']?></td>
                <td><a type="btn btn-link" href="<?=Yii::getAlias('@web')?>/maestras/productos/editar?IdProductos=<?=$P['IdProductos']?>">Editar</a></td>
                <td><a type="btn btn-link" href="<?=Yii::getAlias('@web')?>/maestras/productos/administrar-imagenes-producto?IdProductos=<?=$P['IdProductos']?>">Imagenes</a></td>
            </tr>
                    <?php
                }
            }else{
                ?>
            <tr class="text-center">
                <td colspan="8"><h1>No hay registros</h1></td>
            </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>