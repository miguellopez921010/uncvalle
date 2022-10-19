<?php

namespace app\modules\maestras\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Expression;
use yii\helpers\Json;
use yii\db\Transaction;

/**
 * Default controller for the `usuarios` module
 */
class CargosController extends Controller{

	public static function actionCargosCargoUsuario($IdUsuario){
            $CargosPadre = [];
            $CargoUsuario = Yii::$app->db->createCommand('SELECT cargos.IdCargo, cargos.NombreCargo, cargos.CargoPadre from empleados INNER JOIN cargos ON cargos.IdCargo = empleados.IdCargo WHERE empleados.IdUsuario = '.$IdUsuario)->queryOne();
            if($CargoUsuario != ''){
                if($CargoUsuario['CargoPadre'] != ''){
                    $CargosPadre[] = $CargoUsuario['IdCargo'];
                    $CargosPadre[] = $CargoUsuario['CargoPadre'];
                    $CargoUsuario2 = Yii::$app->db->createCommand('SELECT * from cargos where IdCargo = '.$CargoUsuario['CargoPadre'])->queryAll();
                    
                    if(!empty($CargoUsuario2)){
                        foreach ($CargoUsuario2 AS $CU){
                            if(!in_array($CU['IdCargo'], $CargosPadre)){
                                $CargosPadre[] = $CU['IdCargo'];
                            }
                        }
                    }
                }
            }
            
            return $CargosPadre;
	}
}