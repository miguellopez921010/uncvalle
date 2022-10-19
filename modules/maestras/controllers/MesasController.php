<?php

namespace app\modules\maestras\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Expression;
use yii\helpers\Json;
use yii\db\Transaction;

class MesasController extends Controller
{
    public function beforeAction($action){ 
         $this->layout = '@app/views/layouts/main-interno.php';
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);     
    }


    public function actionListar()
    {
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

        	$ListaMesas = Yii::$app->db->createCommand('SELECT * FROM mesas ORDER BY NumeroMesa ASC')->queryAll();

        	return $this->render('listar', [
                'ListaMesas' => $ListaMesas
            ]);

        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    public function actionCrear(){
    	if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

            return $this->render('crear', []);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionGuardarMesa(){
    	$estado = 1;
        $mensaje = "";

        $NumeroMesa = null;
        if(isset($_REQUEST['NumeroMesa'])){
            $NumeroMesa = $_REQUEST['NumeroMesa'];
        }

        if($NumeroMesa != null){
        	$transaction = Yii::$app->db->beginTransaction();
	        try {
	        	//Validar que el registro con el numero de la mesa que se ingreso, ya no existe, si existe debe sacar error
	        	$ValidarMesa = Yii::$app->db->createCommand('SELECT * FROM mesas WHERE NumeroMesa = '.$NumeroMesa)->queryOne();

	        	if(!$ValidarMesa){
	        		$Mesa = Yii::$app->db->createCommand()->insert('mesas',
                        [
                            'NumeroMesa' => $NumeroMesa,
                            'Estado' => $_REQUEST['Estado'],
                            'FechaCreacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                            'FechaModificacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                        ]
                    )->execute();
                    
                    if($Mesa == 1){
                        $mensaje.='Se registro mesa con exito.';
                    }else{
                    	$estado = 0;
                    	$mensaje.='Error al registrar mesa.';
                    }
	        	}else{
	        		$estado = 0;
	        		$mensaje.='La mesa con el numero '.$NumeroMesa.' ya esta creada en la base de datos.';
	        	}

	        	if($estado == 1){
	                $mensaje.=' OK ';
	                $transaction->commit();
	            }else{
	                $transaction->rollBack();
	            }
	        } catch (\Exception $e) {
	            $transaction->rollBack();
	        } catch (\Throwable $e) {
	            $transaction->rollBack();
	        }
        }else{
        	$estado = 0;
        	$mensaje.='No se ingreso numero de mesa';
        }        

        echo Json::encode(['estado' => $estado, 'mensaje' => $mensaje]);
    }

    function actionCambiarEstadoMesa(){
        $estado = 0;
        $mensaje = "";
        $IdMesa = $_REQUEST['IdMesa'];
        $NuevoEstado = $_REQUEST['NuevoEstado'];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $ActualizarEstadoMesa = Yii::$app->db->createCommand()->update('mesas',
                [
                    'Estado' => $NuevoEstado
                ], 
                'Idmesas = '.$IdMesa
            )->execute();

            if($ActualizarEstadoMesa == 1){
                $estado = 1;
                $mensaje.='Se actualizó estado a la mesa. ';
            }else{
                $mensaje.='Error al actualizar el estado. ';
            }

            if($estado == 1){
                $mensaje.=' OK ';
                $transaction->commit();
            }else{
                $transaction->rollBack();
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }

        echo Json::encode(['estado' => $estado, 'mensaje' => $mensaje, 'NuevoEstado' => $NuevoEstado]);
    }

    function actionAsignarEquipoMesa(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

            //Obtener los equipos que son de Tipo MESA 
            $EquiposMesas = Yii::$app->db->createCommand('SELECT * FROM equipos WHERE Idtipos_equipos = 3 AND Estado = 1')->queryAll();

            //Mesas activas
            $MesasDisponibles = Yii::$app->db->createCommand('SELECT * FROM mesas WHERE Estado = 1 ORDER BY NumeroMesa ASC')->queryAll();

            $EquiposMesasAsignados = Yii::$app->db->createCommand('SELECT * FROM equipos_mesas')->queryAll();

            return $this->render('asignar-equipo-mesa', ['MesasDisponibles' => $MesasDisponibles, 'EquiposMesas' => $EquiposMesas, 'EquiposMesasAsignados' => $EquiposMesasAsignados]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionGuardarAsignacionEquipoMesa(){        
        $mensaje = "";

        $IdMesas = $_REQUEST['IdMesa'];
        if(!empty($IdMesas)){
            $HayEquiposRepetidos = false;
            $ArrayContadorEquipos = [];
            foreach ($IdMesas AS $IdMesa) {
                $Equipo = $_REQUEST['EquipoMesa_'.$IdMesa];
                if(array_key_exists($Equipo, $ArrayContadorEquipos)){
                    $ArrayContadorEquipos[$Equipo] = $ArrayContadorEquipos[$Equipo] + 1;
                    $HayEquiposRepetidos = true;
                }else{
                    $ArrayContadorEquipos[$Equipo] = 1;
                }
            }

            if(!$HayEquiposRepetidos){
                foreach ($IdMesas AS $IdMesa) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        $estado = 0;
                        $InfoMesa = Yii::$app->db->createCommand('SELECT * FROM mesas WHERE Idmesas = '.$IdMesa)->queryOne();
                        $ExisteRegistro = Yii::$app->db->createCommand('SELECT * FROM equipos_mesas WHERE Idmesas = '.$IdMesa)->queryOne();

                        if(!empty($ExisteRegistro)){
                            //Actualizar registro
                            if($ExisteRegistro['Idequipos'] != $_REQUEST['EquipoMesa_'.$IdMesa]){
                                $Mesa = Yii::$app->db->createCommand()->update('equipos_mesas',
                                    [
                                        'Idmesas' => $IdMesa,
                                        'Idequipos' => $_REQUEST['EquipoMesa_'.$IdMesa],
                                        'FechaAsignacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                                        'UsuarioAsignacion' => Yii::$app->user->identity->username,
                                    ], 
                                    'Idequipos_mesas = '.$ExisteRegistro['Idequipos_mesas']
                                )->execute();

                                if($Mesa == 1){
                                    $mensaje.='Se asigno mesa '.$InfoMesa['NumeroMesa'].' con exito.'.PHP_EOL;
                                    $estado = 1;
                                }else{
                                    $mensaje.='Error al asignar mesa '.$InfoMesa['NumeroMesa'].'.'.PHP_EOL;
                                }
                            }else{
                                $estado = 1;
                                $mensaje.='Sigue igual la mesa '.$InfoMesa['NumeroMesa'].'.'.PHP_EOL;
                            }
                        }else{
                            //Insertar registro
                            $Mesa = Yii::$app->db->createCommand()->insert('equipos_mesas',
                                [
                                    'Idmesas' => $IdMesa,
                                    'Idequipos' => $_REQUEST['EquipoMesa_'.$IdMesa],
                                    'FechaAsignacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                                    'UsuarioAsignacion' => Yii::$app->user->identity->username,
                                ]
                            )->execute();

                            if($Mesa == 1){
                                $mensaje.='Se asigno mesa '.$InfoMesa['NumeroMesa'].' con exito.'.PHP_EOL;
                                $estado = 1;
                            }else{
                                $mensaje.='Error al asignar mesa '.$InfoMesa['NumeroMesa'].'.'.PHP_EOL;
                            }
                        }
                        if($estado == 1){
                            $transaction->commit();
                        }else{
                            $transaction->rollBack();
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                    } catch (\Throwable $e) {
                        $transaction->rollBack();
                    }                    
                }
            }else{
                $mensaje.='Un equipo solo puede estar asignado a una mesa.'.PHP_EOL;
            }
        }

        echo Json::encode(['mensaje' => $mensaje]);
    }

}

?>