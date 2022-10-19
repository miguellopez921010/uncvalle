<?php

namespace app\modules\gestionNotarias\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Expression;
use yii\helpers\Json;
use yii\db\Transaction;

/**
 * Default controller for the `usuarios` module
 */
class NotariasController extends Controller
{
	public function beforeAction($action){ 
        $this->layout = '@app/views/layouts/main-interno.php';
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);     
    }

    function actionListar(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){            
            $Notarias = Yii::$app->db->createCommand('SELECT N.*, D.NombreDepartamento, C.NombreCiudad FROM notarias N INNER JOIN departamentos D ON N.IdDepartamento = D.IdDepartamento INNER JOIN ciudades C ON N.IdCiudad = C.IdCiudad ORDER BY D.NombreDepartamento ASC, N.NumeroNotaria ASC, C.NombreCiudad ASC')->queryAll();

            return $this->render('listar', [
                'Notarias' => $Notarias
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }    	
    }

    function actionCrear(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

            $Departamentos = Yii::$app->db->createCommand('SELECT * FROM departamentos ORDER BY NombreDepartamento ASC')->queryAll();
            $Ciudades = [];
            $TiposTelefonos = Yii::$app->db->createCommand('SELECT * FROM tipos_telefonos')->queryAll();

            $TelefonosNotaria = [];
            $EmailsNotaria = [];

            return $this->render('crear', [
                'Departamentos' => $Departamentos,
                'Ciudades' => $Ciudades,
                'TiposTelefonos' => $TiposTelefonos,
                'TelefonosNotaria' => $TelefonosNotaria,
                'EmailsNotaria' => $EmailsNotaria,
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }       
    }

    function actionEditar($IdNotarias){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

            $InfoNotaria = Yii::$app->db->createCommand('SELECT N.* FROM notarias N WHERE N.IdNotarias = '.$IdNotarias)->queryOne();
            $InfoNotario = [];
            $TelefonosNotaria = [];
            $EmailsNotaria = [];

            $Departamentos = Yii::$app->db->createCommand('SELECT * FROM departamentos ORDER BY NombreDepartamento ASC')->queryAll();
            $Ciudades = [];
            if(!empty($InfoNotaria)){
                $Ciudades = Yii::$app->db->createCommand('SELECT * FROM ciudades WHERE IdDepartamento = '.$InfoNotaria['IdDepartamento'].' ORDER BY NombreCiudad ASC')->queryAll();

                $InfoNotario = Yii::$app->db->createCommand('SELECT * FROM notarios WHERE IdNotarias = '.$InfoNotaria['IdNotarias'])->queryOne();

                $TelefonosNotaria = Yii::$app->db->createCommand('SELECT * FROM telefonos_notarias WHERE IdNotarias = '.$InfoNotaria['IdNotarias'])->queryAll();

                $EmailsNotaria = Yii::$app->db->createCommand('SELECT * FROM emails_notarias WHERE IdNotarias = '.$InfoNotaria['IdNotarias'])->queryAll();
            }
            
            $TiposTelefonos = Yii::$app->db->createCommand('SELECT * FROM tipos_telefonos')->queryAll();

            return $this->render('editar', [
                'Departamentos' => $Departamentos,
                'Ciudades' => $Ciudades,
                'TiposTelefonos' => $TiposTelefonos,
                'InfoNotaria' => $InfoNotaria,
                'InfoNotario' => $InfoNotario,
                'TelefonosNotaria' => $TelefonosNotaria,
                'EmailsNotaria' => $EmailsNotaria,
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }       
    }

    function actionGuardarNotaria(){
        $estado = 0;
        $mensaje = "";

        $IdNotarias = null;
        if(isset($_REQUEST['IdNotarias'])){
            if($_REQUEST['IdNotarias'] != null){
                $IdNotarias = $_REQUEST['IdNotarias'];
            }
        }
        $DatosNotaria = [
            'NombreNotaria' => trim($_REQUEST['NombreNotaria']),
            'NumeroNotaria' => trim($_REQUEST['NumeroNotaria']),
            'Direccion' => trim($_REQUEST['Direccion']),
            'Barrio' => trim($_REQUEST['Barrio']),
            'IdDepartamento' => trim($_REQUEST['IdDepartamento']),
            'IdCiudad' => trim($_REQUEST['IdCiudad']),
            'Estado' => trim($_REQUEST['Estado']),
        ];

        $DatosTelefonosNotaria = [];

        if(!empty($_REQUEST['IdTiposTelefonosNotaria'])){
            foreach ($_REQUEST['IdTiposTelefonosNotaria'] AS $Indice => $TipoTelefonoNotaria) {
                if($TipoTelefonoNotaria != ''){
                    $DatosTelefonosNotaria[] = [
                        'IdTiposTelefonos' => trim($TipoTelefonoNotaria),
                        'NumeroTelefono' => trim($_REQUEST['NumeroTelefonoNotaria'][$Indice]),
                        'Extension' => trim($_REQUEST['ExtensionNumeroTelefonoNotaria'][$Indice]),
                    ];
                }
            }
        }

        $DatosEmailsNotaria = [];

        if(!empty($_REQUEST['EmailNotaria'])){
            foreach ($_REQUEST['EmailNotaria'] AS $Indice => $EmailNotaria) {
                if($EmailNotaria != ''){
                    $DatosEmailsNotaria[] = [
                        'Email' => trim($EmailNotaria),
                    ];
                }
            }
        }
        
        $DatosNotario = [
            'NombreNotario' => trim($_REQUEST['NombreNotario']),
            'NumeroDocumento' => trim($_REQUEST['NumeroDocumentoNotario']),
            'NumeroTelefono' => trim($_REQUEST['NumeroTelefonoNotario']),
            'Email' => trim($_REQUEST['EmailNotario']),
        ];


        $transaction = Yii::$app->db->beginTransaction();
        try {
            $SQLsLog = "";
            $NumeroDocumentoLogueado = Yii::$app->user->identity->username;

            //Guardar datos de la notaria
            if($IdNotarias == null){
                $DatosNotaria['FechaHoraCreacion'] = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();
            }            
            $DatosNotaria['FechaHoraModificacion'] = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();

            if($IdNotarias == null){
                $Notaria = Yii::$app->db->createCommand()->insert('notarias',$DatosNotaria);
            }else{
                $Notaria = Yii::$app->db->createCommand()->update('notarias',$DatosNotaria, 'IdNotarias = '.$IdNotarias);
            }
            
            $SQLsLog.=$Notaria->getRawSql().PHP_EOL;

            if($Notaria->execute() == 1){
                $estado = 1;
                if($IdNotarias == null){
                    $mensaje.='Se creo la Notaria exitosamente. '.PHP_EOL.PHP_EOL;
                    $IdNotaria = Yii::$app->db->getLastInsertID();
                }else{
                    $mensaje.='Se actualizo la Notaria exitosamente. '.PHP_EOL.PHP_EOL;
                    $IdNotaria = $IdNotarias;
                }                

                if($IdNotarias != null){
                    //Eliminar los telefonos asociados, para mas adelante, registrarlos nuevamente
                    $EliminarTelefonosNotarias = Yii::$app->db->createCommand()->delete('telefonos_notarias', 'IdNotarias = '.$IdNotarias);
                    $SQLsLog.=$EliminarTelefonosNotarias->getRawSql().PHP_EOL;

                    if($EliminarTelefonosNotarias->execute() == 1){
                        $mensaje.='Se eliminaron los telefonos de la notaria. '.PHP_EOL;
                    }
                }

                //Guardar telefonos de la notaria
                if(!empty($DatosTelefonosNotaria)){
                    foreach ($DatosTelefonosNotaria AS $Dato) {
                        $Dato['IdNotarias'] = $IdNotaria;
                        $Dato['FechaHoraCreacion'] = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();
                        $Dato['FechaHoraModificacion'] = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();

                        $TelefonoNotaria = Yii::$app->db->createCommand()->insert('telefonos_notarias',$Dato);
                        $SQLsLog.=$TelefonoNotaria->getRawSql().PHP_EOL;

                        if($TelefonoNotaria->execute() == 1){
                            $mensaje.='Se registro telefono a la notaria. '.PHP_EOL;
                        }else{
                            $estado = 0;
                            $mensaje.='Error al registrar telefono a la notaria. '.PHP_EOL;
                        }
                    }
                    $mensaje.=PHP_EOL;
                }

                if($IdNotarias != null){
                    //Eliminar los telefonos asociados, para mas adelante, registrarlos nuevamente
                    $EliminarEmailsNotarias = Yii::$app->db->createCommand()->delete('emails_notarias', 'IdNotarias = '.$IdNotarias);
                    $SQLsLog.=$EliminarEmailsNotarias->getRawSql().PHP_EOL;

                    if($EliminarEmailsNotarias->execute() == 1){
                        $mensaje.='Se eliminaron los emails de la notaria. '.PHP_EOL;
                    }
                }

                //Guardar emails de la notaria
                if(!empty($DatosEmailsNotaria)){
                    foreach ($DatosEmailsNotaria AS $Dato) {
                        $Dato['IdNotarias'] = $IdNotaria;
                        $Dato['FechaHoraCreacion'] = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();
                        $Dato['FechaHoraModificacion'] = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();

                        $EmailNotaria = Yii::$app->db->createCommand()->insert('emails_notarias',$Dato);
                        $SQLsLog.=$EmailNotaria->getRawSql().PHP_EOL;

                        if($EmailNotaria->execute() == 1){
                            $mensaje.='Se registro email a la notaria. '.PHP_EOL;
                        }else{
                            $estado = 0;
                            $mensaje.='Error al registrar email a la notaria. '.PHP_EOL;
                        }
                    }
                    $mensaje.=PHP_EOL;
                }

                //Guardar datos del notario
                $DatosNotario['IdNotarias'] = $IdNotaria;
                if($IdNotarias == null){
                    $DatosNotario['FechaHoraCreacion'] = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();
                }
                $DatosNotario['FechaHoraModificacion'] = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();

                if($IdNotarias == null){
                    $Notario = Yii::$app->db->createCommand()->insert('notarios',$DatosNotario);
                }else{
                    $InfoNotario = Yii::$app->db->createCommand('SELECT * FROM notarios WHERE IdNotarias = '.$IdNotarias)->queryOne();
                    if(!empty($InfoNotario)){
                        $Notario = Yii::$app->db->createCommand()->update('notarios',$DatosNotario, 'IdNotarios = '.$InfoNotario['IdNotarios']);
                    }else{
                        $Notario = Yii::$app->db->createCommand()->insert('notarios',$DatosNotario);
                    }
                }
                
                $SQLsLog.=$Notario->getRawSql().PHP_EOL;

                if($Notario->execute() == 1){
                    if($IdNotarias == null){
                        $mensaje.='Se registro notario. '.PHP_EOL;
                    }else{
                        $mensaje.='Se actualizo notario. '.PHP_EOL;
                    }                    
                }else{
                    if($IdNotarias == null){
                        $estado = 0;
                        $mensaje.='Error al registrar notario. '.PHP_EOL;
                    }else{
                        $estado = 0;
                        $mensaje.='Error al actualizar notario. '.PHP_EOL;
                    }
                }
                $mensaje.=PHP_EOL;


                /*******************************LOG REGISTRO*********************************/
                $Log = Yii::$app->db->createCommand()->insert('log_notarias',[
                    'IdNotarias' => $IdNotaria,
                    'NumeroDocumento' => $NumeroDocumentoLogueado,
                    'Sql' => $SQLsLog,
                    'FechaHoraCreacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar()
                ])->execute();

                if($Log == 1){
                    $mensaje.='Log registrado. '.PHP_EOL;
                }else{
                    $estado = 0;
                    $mensaje.='Error al guardar el Log. '.PHP_EOL;
                }
                $mensaje.=PHP_EOL;

            }else{
                if($IdNotarias == null){
                    $estado = 0;
                    $mensaje.='Error al crear la Notaria. '.PHP_EOL;
                }else{
                    $estado = 0;
                    $mensaje.='Error al actualizar la Notaria. '.PHP_EOL;
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

}