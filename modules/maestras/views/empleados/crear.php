<?php

use app\assets\EmpleadoAsset;

EmpleadoAsset::register($this);

?>

<form id="formCrearEmpleado" name="formCrearEmpleado" type="POST">
    <?php echo $this->render('_datosPersona.php'); ?>

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
                                    echo '<option value="' . $Cargo['IdCargo'] . '">' . $Cargo['NombreCargo'] . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Datos de acceso al sistema</legend>
    <?php echo $this->render('_crearContrasena.php'); ?>
    </fieldset>
    
    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>		
    </div>	
</form>
