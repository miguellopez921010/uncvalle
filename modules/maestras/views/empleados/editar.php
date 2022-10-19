<?php

use app\assets\EmpleadoAsset;

EmpleadoAsset::register($this);
?>

<form id="formCrearEmpleado" name="formCrearEmpleado" type="POST">
    <?php 
    if(isset($InfoUsuario)){
        if(isset($InfoUsuario['IdUsuario'])){
            if($InfoUsuario['IdUsuario'] != null){
                ?>
                <input type="hidden" id="IdUsuario" name="IdUsuario" value="<?=$InfoUsuario['IdUsuario']?>">
                <?php
            }
        }
    }
    ?>

    <?php echo $this->render('_datosPersona.php', ['InfoUsuario' => $InfoUsuario]); ?>

    <fieldset>
        <legend>Datos Empleado</legend>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="required">Cargo</label>
                    <select class="form-control" id="IdCargo" name="IdCargo" required="true">
                        <option value="">Seleccionar Cargo</option>
                        <?php
                        if (isset($Cargos)) {
                            if (!empty($Cargos)) {
                                foreach ($Cargos AS $Cargo) {
                                    $selected = "";
                                    if(isset($InfoUsuario)){
                                        if(isset($InfoUsuario['IdCargo'])){
                                            if($InfoUsuario['IdCargo'] != null){
                                                if($Cargo['IdCargo'] == $InfoUsuario['IdCargo']){
                                                    $selected = ' selected ';
                                                }
                                            }
                                        }
                                    }
                                    echo '<option value="' . $Cargo['IdCargo'] . '" '.$selected.'>' . $Cargo['NombreCargo'] . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>