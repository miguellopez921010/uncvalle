<?php 
if(isset($DocumentosSeccion)){
    if(!empty($DocumentosSeccion)){
        ?>
    <div class="row">
        <?php
        foreach($DocumentosSeccion AS $Documento){
            ?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <a href="#" onclick="CargarDocumentoEnModal(<?=$Documento['IdDocumentos']?>)">
                <div style="height:250px; width: 100%; display: table; border: 1px solid #ddd; margin-top:10px;">
                    <div style="display: table-cell; vertical-align: middle; text-align: center;">
                        <?php
                        echo $Documento['NombreDocumento'];
                        //var_dump($Documento);
                        ?>
                    </div>
                </div>
            </button>
        </div>
            <?php
        }
        ?>
    </div>
        <?php
    }
}
?>