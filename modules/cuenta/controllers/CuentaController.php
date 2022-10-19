<?php

namespace app\modules\cuenta\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Expression;
use yii\helpers\Json;
use yii\db\Transaction;

/**
 * Default controller for the `cuenta` module
 */
class CuentaController extends Controller
{
    
    public function beforeAction($action){ 
         $this->layout = '@app/views/layouts/main-interno.php';
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);     
    }

    function actionMiCuenta(){
    	if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

    		$IdUsuario = Yii::$app->user->id;
    		$InfoUsuario = Yii::$app->db->createCommand('SELECT personas.*, usuarios.*, empleados.IdCargo '
                    . 'FROM usuarios '
                    . 'INNER JOIN personas ON personas.NumeroDocumento = usuarios.username '
                    . 'INNER JOIN empleados ON empleados.IdUsuario = usuarios.IdUsuario '
                    . 'INNER JOIN cargos ON cargos.IdCargo = empleados.IdCargo '
                    . 'WHERE usuarios.IdUsuario = '.$IdUsuario)->queryOne();

    		return $this->render('mi-cuenta', ['InfoUsuario' => $InfoUsuario]);

    	}else{
    		return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
    	}
    }

    function actionGuardarMiCuenta(){
        $estado = 1;
        $mensaje = "";
        
        $IdUsuario = null;
        if(isset($_REQUEST['IdUsuario'])){
            $IdUsuario = $_REQUEST['IdUsuario'];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($IdUsuario == null){

            }else{
                //Actualizar empleado
                //Validar que existe el usuario en la BD
                $Infousuario = Yii::$app->db->createCommand('SELECT * FROM usuarios WHERE IdUsuario = '.$IdUsuario)->queryOne();

                if($Infousuario != null){
                    $Infopersona = Yii::$app->db->createCommand('SELECT * FROM personas WHERE NumeroDocumento = '.$Infousuario['username'])->queryOne();

                    if($Infopersona != null){
                        $persona = Yii::$app->db->createCommand()->update('personas',
                            [
                                'NumeroDocumento' => $_REQUEST['NumeroDocumento'],
                                'Nombres' => $_REQUEST['Nombres'],
                                'Apellidos' => $_REQUEST['Apellidos'],
                                'Email' => $_REQUEST['Email'],
                                'FechaModificacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                            ],
                            'IdPersona = '.$Infopersona['IdPersona']
                        )->execute();

                        if($persona == 1){
                            $IdPersona = $persona['IdPersona'];
                            $mensaje.='Se actualizó Persona exitosamente. ';

                            if($_REQUEST['NumeroDocumento'] == $Infousuario['username'] && $_REQUEST['Email'] == $Infousuario['email']){
                                $usuario = 1;
                            }else{
                                $usuario = Yii::$app->db->createCommand()->update('usuarios',
                                    [
                                        'username' => $_REQUEST['NumeroDocumento'],
                                        'email' => $_REQUEST['Email'],
                                    ],
                                    'IdUsuario = '.$IdUsuario
                                )->execute();
                            }                            

                            if($usuario == 1){
                                $mensaje.='Se actualizó el Usuario exitosamente. ';

                                //Validar que el usuario tenga el Permiso EMPLEADO asociado
                                $ValidarPerfilEmpleado = Yii::$app->db->createCommand('SELECT * FROM auth_assignment WHERE user_id = '.$IdUsuario.' AND item_name = "EMPLEADO"')->queryOne();

                                if($ValidarPerfilEmpleado == null){
                                	//No existe la asociacion, debe crearse
                                	$auth_assignment = Yii::$app->db->createCommand()->insert('auth_assignment',
                                        [
                                            'item_name' => 'EMPLEADO',
                                            'user_id' => $IdUsuario,
                                            'created_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                        ]
                                    )->execute();
                                }                                
                            }else{
                                $estado = 0;
                                $mensaje.='Error al actualizar el Usuario. ';
                            }
                        }else{
                            $estado = 0;
                            $mensaje.='Error al actualizar Persona. ';
                        }
                    }else{
                        $estado = 0;
                        $mensaje.='No hay Persona registrada. ';
                    }
                }else{
                    $estado = 0;
                    $mensaje.='No hay Usuario registrado. ';
                }
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

        echo Json::encode(['estado' => $estado, 'mensaje' => $mensaje]);
    }

    function actionCambiarContrasena(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){
            $IdUsuario = Yii::$app->user->id;

            return $this->render('cambiar-contrasena', ['IdUsuario' => $IdUsuario]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionCambiarContrasenaMiCuenta(){
    	$estado = 0;
        $mensaje = '';

        $IdUsuario = $_REQUEST['IdUsuario'];
        $PasswordActual = trim($_REQUEST['PasswordActual']);
        $Password1 = trim($_REQUEST['Password1']);
        $Password2 = trim($_REQUEST['Password2']);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($IdUsuario != null && $PasswordActual != null && $Password1 != null && $Password2 != null){
            	$PasswordActualsha1 = sha1($PasswordActual);
                $Password1sha1 = sha1($Password1);
                $Password2sha1 = sha1($Password2);

                $InfoUsuario = Yii::$app->db->createCommand('SELECT * FROM usuarios WHERE IdUsuario = '.$IdUsuario)->queryOne();

                if($InfoUsuario != null){
                	if($PasswordActualsha1 == $InfoUsuario['password']){
                		if($Password1sha1 == $Password2sha1){
	                        if($InfoUsuario['password'] != $Password1sha1){
	                            $ActualizarContrasenaUsuario = Yii::$app->db->createCommand()->update('usuarios',
	                                [
	                                    'password' => $Password1sha1
	                                ], 
	                                'IdUsuario = '.$IdUsuario
	                            )->execute();

	                            if($ActualizarContrasenaUsuario == 1){
	                                $estado = 1;
	                                $mensaje.='Cambio de contraseña exitoso. ';
	                            }else{
	                                $mensaje.='Error al actualizar la contraseña. ';
	                            }
	                        }else{
	                            $estado = 1;
	                            $mensaje.='Cambio de contraseña exitoso. ';
	                        }
	                    }else{
	                        $mensaje.='Las contraseñas no coinciden. ';
	                    } 
                	}else{
                		$mensaje.='La contraseña actual no es la correcta. Vuelva a ingresarla por favor. ';
                	}                                                   
                }else{
                    $mensaje.='No hay usuario registrado. ';
                }            
            }else{
                $mensaje.='Todos los campos son obligatorios. ';
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

        echo Json::encode(['estado' => $estado, 'mensaje' => $mensaje]);
    }

}