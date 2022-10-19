<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(14);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion14---</i>';
    }
}

if(isset($Datos['Foros'])){
    if(!empty($Datos['Foros'])){
        ?>
        <div class="row">
            <?php
            foreach($Datos['Foros'] AS $Foro){
                ?>
            <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php 
                            if($Foro['EnlaceExterno'] != null){
                                ?>
                            <button type='button' onclick="AbrirUrlExterna('<?=$Foro['EnlaceExterno']?>')">
                                <?php
                            }elseif($Foro['CargarContenido'] == 1){
                                ?>
                                <button type='button' onclick="CargarModal('modalNormal', 1, '/site/cargar-informacion-foro', {'IdForo':<?=$Foro['IdForos'] ?>})">
                                <?php
                            }
                            ?>
                            
                            <?php
                            if($Foro['IdImagenes'] != null && $Foro['IdImagenes'] != 0){
                                ?>
                            <div>
                                
                    		    <img src="<?=Yii::getAlias('@web').'/images/'.$Foro['RutaCarpeta'].'/'.$Foro['NombreImagen']?>" class="img-responsive" title='<?=$Foro['NombreForo'].' - Fecha y hora: '. $Foro['FechaForo'].' '.$Foro['HoraForo'];?>'>
                    		</div>
                                <?php
                            }else{
                                ?>
                            <div style="height:150px; width: 100%; display: table;">
                                <div style="display: table-cell; vertical-align: middle; text-align: center;">
                                    <?php
                                    echo $Foro['NombreForo'];
                                    ?>
                                </div>
                            </div>
                                <?php
                            }
                            ?>
                            
                            <?php 
                            if($Foro['EnlaceExterno'] != null || $Foro['CargarContenido'] == 1 ){
                                ?>
                            </button>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="panel-footer text-center">
                            Fecha y hora: 
                            <?php
                            echo $Foro['FechaForo'].' '.$Foro['HoraForo'];
                            ?>
                        </div>
                    </div>
            </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}
?>