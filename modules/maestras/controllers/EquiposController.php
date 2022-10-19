<?php

namespace app\modules\maestras\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Expression;
use yii\helpers\Json;
use yii\db\Transaction;

/**
 * Default controller for the `Administrador` module
 */
class EquiposController extends Controller
{
	public function beforeAction($action){ 
         $this->layout = '@app/views/layouts/main-interno.php';
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);     
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionListar()
    {
    	if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){
        	
            $ListaEquipos = Yii::$app->db->createCommand('SELECT equipos.*, tipos_equipos.Nombre AS NombreTipoEquipo FROM equipos INNER JOIN tipos_equipos ON tipos_equipos.Idtipos_equipos = equipos.Idtipos_equipos ORDER BY tipos_equipos.Prioridad ASC')->queryAll();
            
        	return $this->render('listar', [
                'ListaEquipos' => $ListaEquipos
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        } 
    }

    function actionCrear(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

            $TiposEquipos = Yii::$app->db->createCommand('SELECT * FROM tipos_equipos ORDER BY Prioridad ASC')->queryAll();

            return $this->render('crear', ['TiposEquipos' => $TiposEquipos]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionEditar($IdEquipo){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

            $InfoEquipo = Yii::$app->db->createCommand('SELECT * FROM equipos WHERE Idequipos = '.$IdEquipo)->queryOne();
            
            $TiposEquipos = Yii::$app->db->createCommand('SELECT * FROM tipos_equipos ORDER BY Prioridad ASC')->queryAll();

            return $this->render('editar', ['TiposEquipos' => $TiposEquipos, 'InfoEquipo' => $InfoEquipo]);

        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }        
    }


    function actionGuardarEquipo(){
        $estado = 1;
        $mensaje = "";

        $Idequipos = null;
        if(isset($_REQUEST['Idequipos'])){
            $Idequipos = $_REQUEST['Idequipos'];
        }

        $Nombre = null;
        if(isset($_REQUEST['Nombre'])){
            $Nombre = $_REQUEST['Nombre'];
        }
        $Descripcion = null;
        if(isset($_REQUEST['Descripcion'])){
            $Descripcion = $_REQUEST['Descripcion'];
        }
        $Marca = null;
        if(isset($_REQUEST['Marca'])){
            $Marca = $_REQUEST['Marca'];
        }
        $NumeroSerie = null;
        if(isset($_REQUEST['NumeroSerie'])){
            $NumeroSerie = $_REQUEST['NumeroSerie'];
        }
        $IMEI = null;
        if(isset($_REQUEST['IMEI'])){
            $IMEI = $_REQUEST['IMEI'];
        }
        $DireccionIP = null;
        if(isset($_REQUEST['DireccionIP'])){
            $DireccionIP = $_REQUEST['DireccionIP'];
        }
        $Idtipos_equipos = null;
        if(isset($_REQUEST['Idtipos_equipos'])){
            $Idtipos_equipos = $_REQUEST['Idtipos_equipos'];
        }

        if($Nombre != null || $Marca != null || $NumeroSerie != null || $DireccionIP != null || $Idtipos_equipos != null){
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($Idequipos == null){
                    //Insertar
                    $Equipo = Yii::$app->db->createCommand()->insert('equipos',
                        [
                            'Nombre' => $Nombre,
                            'Descripcion' => $Descripcion,
                            'Marca' => $_REQUEST['Marca'],
                            'NumeroSerie' => $NumeroSerie,
                            'IMEI' => $IMEI,
                            'DireccionIP' => $DireccionIP,
                            'Idtipos_equipos' => $Idtipos_equipos,
                            'Estado' => 1,
                            'FechaCreacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                            'FechaModificacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                        ]
                    )->execute();
                }else{
                    //Actualizar
                    $Equipo = Yii::$app->db->createCommand()->update('equipos',
                        [
                            'Nombre' => $Nombre,
                            'Descripcion' => $Descripcion,
                            'Marca' => $_REQUEST['Marca'],
                            'NumeroSerie' => $NumeroSerie,
                            'IMEI' => $IMEI,
                            'DireccionIP' => $DireccionIP,
                            'Idtipos_equipos' => $Idtipos_equipos,
                            'FechaModificacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                        ], 
                        'Idequipos = '.$Idequipos
                    )->execute();
                }                
                
                if($Equipo == 1){
                    $mensaje.='Se registro equipo con exito.';
                }else{
                    $estado = 0;
                    $mensaje.='Error al registrar equipo.';
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
            $mensaje.='Algunos campos son obligatorios';
        }        

        echo Json::encode(['estado' => $estado, 'mensaje' => $mensaje]);
    }

    function actionCambiarEstadoEquipo(){
        $estado = 0;
        $mensaje = "";
        $IdEquipo = $_REQUEST['IdEquipo'];
        $NuevoEstado = $_REQUEST['NuevoEstado'];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $ActualizarEstadoEquipo = Yii::$app->db->createCommand()->update('equipos',
                [
                    'Estado' => $NuevoEstado
                ], 
                'Idequipos = '.$IdEquipo
            )->execute();

            if($ActualizarEstadoEquipo == 1){
                $estado = 1;
                $mensaje.='Se actualizó estado al equipo. ';
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

}
