<?php

use app\assets\EquiposAsset;

EquiposAsset::register($this);
?>

<form id="formCrearEquipo" name="formCrearEquipo" type="POST">
    <?php 
    if(isset($InfoEquipo)){
        if(isset($InfoEquipo['Idequipos'])){
            if($InfoEquipo['Idequipos'] != null){
                ?>
                <input type="hidden" id="Idequipos" name="Idequipos" value="<?=$InfoEquipo['Idequipos']?>">
                <?php
            }
        }
    }
    ?>

    <?php echo $this->render('_datosEquipo.php', ['InfoEquipo' => $InfoEquipo, 'TiposEquipos' => $TiposEquipos]); ?>

    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>