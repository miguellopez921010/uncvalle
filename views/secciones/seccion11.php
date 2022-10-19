<?php

use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(11);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion11---</i>';
    }
}

if (isset($Datos['CategoriasMemorandos'])) {
    if (!empty($Datos['CategoriasMemorandos'])) {
        ?>
        <div id="accordion">
            <?php
            foreach ($Datos['CategoriasMemorandos'] AS $CM) {
                ?>
                <div class="card">
                    <div class="card-header" id="heading<?= $CM['IdCategoriasMemorandos'] ?>">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?= $CM['IdCategoriasMemorandos'] ?>" aria-expanded="true" aria-controls="collapse<?= $CM['IdCategoriasMemorandos'] ?>">
                                <?= $CM['NombreCategoria'] ?>
                            </button>
                        </h5>
                    </div>

                    <div id="collapse<?= $CM['IdCategoriasMemorandos'] ?>" class="collapse" aria-labelledby="heading<?= $CM['IdCategoriasMemorandos'] ?>" data-parent="#accordion">
                        <div class="card-body">
                            <?php
                            if (isset($Datos['Memorandos'])) {
                                if (!empty($Datos['Memorandos'])) {
                                    ?>
                                    <div class="list-group list-group-flush">
                                        <?php
                                        foreach ($Datos['Memorandos'] AS $Memorando) {
                                            if ($Memorando['IdCategoriasMemorandos'] == $CM['IdCategoriasMemorandos']) {
                                                ?>
                                                <a href="/site/ver-memorando?IdMemorandos=<?= $Memorando['IdMemorandos'] ?>" class="list-group-item list-group-item-action"><?= $Memorando['NombreMemorando'] ?></a>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                            }
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