<?php
echo '<div style="margin-top: 15px;">';
echo '<label>Se encontraron ' . count($Notarias) . ' resultados</label>';
if (!empty($Notarias)) {
    ?>
    <div class="table-responsive">
        <table class="table table-bordered table-condensed table-striped">
            <thead>
                <tr>
                    <th>Notar&iacute;a</th>
                    <th>Direcci&oacute;n</th>
                    <th>Tel&eacute;fono(s)</th>
                    <th>Email(s)</th>
                    <th>Notario(s)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($Notarias AS $Notaria) {
                    ?>
                    <tr>
                        <td><?= 'NOTARIA ' . $Notaria['NombreNotaria'] . ' DE ' . $Notaria['NombreCiudad'] . ' - ' . $Notaria['NombreDepartamento'] ?></td>
                        <td><?= $Notaria['Direccion'] . ($Notaria['Barrio'] != null ? ' Barrio ' . $Notaria['Barrio'] : '') ?></td>
                        <td>
                            <?php
                            $ArrayTelefono = [];
                            if (!empty($Notaria['TelefonosNotarias'])) {
                                foreach ($Notaria['TelefonosNotarias'] AS $TN) {
                                    $ArrayTelefono[] = $TN['NumeroTelefono'];
                                }
                            }
                            echo implode(' - ', $ArrayTelefono);
                            ?>
                        </td>
                        <td>
                            <?php
                            $ArrayEmails = [];
                            if (!empty($Notaria['EmailsNotarias'])) {
                                foreach ($Notaria['EmailsNotarias'] AS $TN) {
                                    $ArrayEmails[] = $TN['Email'];
                                }
                            }
                            echo implode('<br>', $ArrayEmails);
                            ?>
                        </td>
                        <td>
                            <?php
                            $ArrayNotarios = [];
                            if (!empty($Notaria['Notarios'])) {
                                foreach ($Notaria['Notarios'] AS $TN) {
                                    $ArrayNotarios[] = $TN['NombreNotario'];
                                }
                            }
                            echo implode('<br>', $ArrayNotarios);
                            ?>
                        </td>



                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    /* echo '<div class="row">';
      foreach($Notarias AS $Notaria){
      echo '<div class="col-md-4 col-sm-6">';
      echo '<div class="panel panel-primary">';
      echo '<div class="panel-heading" style="font-weight: bold;">NOTARIA '.$Notaria['NombreNotaria'].' DE '.$Notaria['NombreCiudad'].' - '.$Notaria['NombreDepartamento'].'</div>';
      echo '<div class="panel-body">';
      echo '<div class="row">';
      echo '<div class="col-md-6">';
      echo '<label>Direcci&oacute;n:</label><br>';
      echo $Notaria['Direccion'];
      echo '</div>';
      echo '<div class="col-md-6">';
      echo '<label>Barrio:</label><br>';
      echo $Notaria['Barrio'];
      echo '</div>';
      echo '</div>';



      var_dump($Notaria);
      echo '</div>';
      echo '</div>';
      echo '</div>';
      }
      echo '</div>'; */
} else {
    echo '<h3 class="text-center">No hay notarias registradas para esta ciudad</h3>';
}
echo '</div>';
?>