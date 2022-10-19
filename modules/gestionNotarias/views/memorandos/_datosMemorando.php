<fieldset>
    <legend>Datos Memorandos</legend>

    <?php
    if (isset($InfoMemorando)) {
        if (!empty($InfoMemorando)) {
            ?>
            <input type="hidden" id="IdMemorandos" name="IdMemorandos" value="<?= $InfoMemorando['IdMemorandos'] ?>">
            <?php
        }
    }
    ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="required">Nombre</label>
                <input type="text" name="NombreMemorando" id="NombreMemorando" class="form-control" required="true" value="<?php
                if (isset($InfoMemorando)) {
                    if (!empty($InfoMemorando)) {
                        echo $InfoMemorando['NombreMemorando'];
                    }
                }
                ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required">Categoria</label>
                <select name="IdCategoriasMemorandos" id="IdCategoriasMemorandos" class="form-control" required="true">
                    <?php
                    if (isset($CategoriasMemorandos)) {
                        if (!empty($CategoriasMemorandos)) {
                            foreach ($CategoriasMemorandos AS $CM) {
                                $Seleccionado = "";
                                if (isset($InfoMemorando)) {
                                    if (!empty($InfoMemorando)) {
                                        if($InfoMemorando['IdCategoriasMemorandos'] == $CM['IdCategoriasMemorandos']){
                                            $Seleccionado = 'selected';
                                        }
                                    }
                                }
                                ?>
                                <option value="<?= $CM['IdCategoriasMemorandos'] ?>" <?=$Seleccionado?>><?= $CM['NombreCategoria'] ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
</fieldset>