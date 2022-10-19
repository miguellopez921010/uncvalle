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
class ComunicacionesController extends Controller
{
	public function beforeAction($action){ 
        $this->layout = '@app/views/layouts/main-interno.php';
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);     
    }

    function actionListar(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){            
            $Comunicaciones = Yii::$app->db->createCommand('SELECT * FROM comunicaciones ORDER BY IdComunicaciones ASC')->queryAll();

            return $this->render('listar', [
                'Comunicaciones' => $Comunicaciones
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }    	
    }

    function actionCrear(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

            return $this->render('crear', [
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }       
    }

    function actionEditar($IdComunicaciones){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

            $InfoComunicacion = Yii::$app->db->createCommand('SELECT * FROM comunicaciones WHERE IdComunicaciones =  '.$IdComunicaciones)->queryOne();
            
            return $this->render('editar', [
                'InfoComunicacion' => $InfoComunicacion,
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }       
    }

    function actionGuardarComunicacion(){
        $estado = 0;
        $mensaje = "";

        $IdComunicaciones = null;
        if(isset($_REQUEST['IdComunicaciones'])){
            if($_REQUEST['IdComunicaciones'] != null){
                $IdComunicaciones = $_REQUEST['IdComunicaciones'];
            }
        }
        
        $DatosMemorando = [
            'NombreComunicacion' => trim($_REQUEST['NombreComunicacion']),
        ];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $SQLsLog = "";
            $NumeroDocumentoLogueado = Yii::$app->user->identity->username;

            //Guardar datos del memorando
            if($IdComunicaciones == null){
                $DatosMemorando['FechaHoraRegistro'] = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();
            }            
            $DatosMemorando['FechaHoraModificacion'] = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();

            if($IdComunicaciones == null){
                $Memorando = Yii::$app->db->createCommand()->insert('comunicaciones',$DatosMemorando);
            }else{
                $Memorando = Yii::$app->db->createCommand()->update('comunicaciones',$DatosMemorando, 'IdComunicaciones = '.$IdComunicaciones);
            }
            
            $SQLsLog.=$Memorando->getRawSql().PHP_EOL;

            if($Memorando->execute() == 1){
                $estado = 1;
                if($IdComunicaciones == null){
                    $mensaje.='Se creo el comunicado exitosamente. '.PHP_EOL.PHP_EOL;
                    $IdComunicaciones = Yii::$app->db->getLastInsertID();
                }else{
                    $mensaje.='Se actualizo el comunicado exitosamente. '.PHP_EOL.PHP_EOL;
                }
                
                $mensaje.=PHP_EOL;


                /*******************************LOG REGISTRO*********************************/
                /*$Log = Yii::$app->db->createCommand()->insert('log_memorandos',[
                    'IdMemorandos' => $IdMemorandos,
                    'NumeroDocumento' => $NumeroDocumentoLogueado,
                    'SqlGenerado' => $SQLsLog,
                    'FechaHoraCreacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar()
                ])->execute();

                if($Log == 1){
                    $mensaje.='Log registrado. '.PHP_EOL;
                }else{
                    $estado = 0;
                    $mensaje.='Error al guardar el Log. '.PHP_EOL;
                }*/
                $mensaje.=PHP_EOL;

            }else{
                if($IdComunicaciones == null){
                    $estado = 0;
                    $mensaje.='Error al crear el comunicado. '.PHP_EOL;
                }else{
                    $estado = 0;
                    $mensaje.='Error al actualizar el comunicado. '.PHP_EOL;
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

        echo Json::encode(['estado' => $estado, 'mensaje' => $mensaje, 'IdComunicaciones' => $IdComunicaciones,]);
    }
    
    function actionCargarArchivos($IdComunicaciones){
        return $this->render('cargar-archivos', [
            'IdComunicaciones' => $IdComunicaciones
        ]);
    }
    
    function actionCargarArchivosTmpComunicaciones(){
        $Estado = 0;
        $Mensaje = null;
        
        $IdComunicaciones = $_REQUEST['IdComunicaciones'];
        
        if(!empty($_FILES)){
            if(isset($_FILES['file'])){
                if(!empty($_FILES['file'])){
                    //if($_FILES['file']['type'] == 'application/pdf'){
                        //Solo se aceptan PDF
                        $NombreDocumento = self::sanear_string($_FILES['file']['name']);
                        $NombreDocumento = self::sanear_string(utf8_decode($NombreDocumento));
                        $RutaDocumento = 'comunicaciones'.DIRECTORY_SEPARATOR.$NombreDocumento;
                        
                        $DatosDocumento = [
                            'NombreDocumento' => $NombreDocumento,
                            'RutaDocumento' => $RutaDocumento,
                        ];
                        
                        if(copy($_FILES['file']['tmp_name'], Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$RutaDocumento)){
                            
                            //Crear el registro en Documentos
                            $Documento = Yii::$app->db->createCommand()->insert('documentos',$DatosDocumento)->execute();
                            
                            if($Documento == 1){
                                $IdDocumentos = Yii::$app->db->getLastInsertID();
                                
                                //Asociar el documento al memorando
                                $DocumentosMemorando = Yii::$app->db->createCommand()->insert('documentos_comunicaciones',['IdComunicaciones' => $IdComunicaciones, 'IdDocumentos' => $IdDocumentos])->execute();
                                
                                if($DocumentosMemorando == 1){
                                    $Estado = 1;
                                }
                            }
                        }
                    /*}else{
                        $Mensaje.= 'Solo debe subir archivos con extension .pdf';
                    }*/
                }
            }
            
        }
        
        echo Json::encode(['Estado' => $Estado, 'Mensaje' => $Mensaje]);
        
        
    }
    
    function sanear_string($string)
    {
     
        $string = trim($string);
     
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
     
        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );
     
        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î',),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );
     
        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );
     
        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );
     
        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );
        
        $trans = array("ñ" => "n", "Ñ" => "N");
        $string = strtr($string, $trans);

     
        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "-", "~","#", "@", "|", "!",
                 "·", "$", "%", "&", "/","?", "'", "¡",
                 "¿", "[", "^", "<code>", "]",
                 "+", "}", "{", "¨", "´",
                 ">", "<",
                 ),
            '',
            $string
        );
     
     
        return $string;
    }
    
    function actionEliminarMemorando(){
        $estado = 0;
        $mensaje = null;
        $IdMemorandos = $_REQUEST['IdMemorandos'];
        
        $transaction = Yii::$app->db->beginTransaction();
        try {
            Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0;')->execute();
            
            //Validamos que el memorando exista
            $Memorando = Yii::$app->db->createCommand('SELECT * FROM memorandos WHERE IdMemorandos = '.$IdMemorandos)->queryOne();
            
            if(!empty($Memorando)){
                //Validar los documentos asociados a ese memorando
                $DocumentosMemorandos = Yii::$app->db->createCommand('SELECT * FROM documentos_memorandos WHERE IdMemorandos = '.$IdMemorandos)->queryAll();
                
                if(!empty($DocumentosMemorandos)){
                    //Eliminar cada registro de documento y posterior cada registro de documentos_memorandos
                    foreach($DocumentosMemorandos AS $DocumentoMemorando){
                        $Documento = Yii::$app->db->createCommand('SELECT * FROM documentos WHERE IdDocumentos = '.$DocumentoMemorando['IdDocumentos'])->queryOne();
                        
                        if(!empty($Documento)){
                            Yii::$app->db->createCommand()->delete('documentos', 'IdDocumentos = '.$Documento['IdDocumentos'])->execute();
                        }
                    }
                    
                    Yii::$app->db->createCommand()->delete('documentos_memorandos', 'IdMemorandos = '.$IdMemorandos)->execute();
                }
                
                //Eliminar rgistro de la tabla memorandos
                $EliminarMemorando = Yii::$app->db->createCommand()->delete('memorandos', 'IdMemorandos = '.$IdMemorandos)->execute();
                
                if($EliminarMemorando == 1){
                    $estado = 1;
                    $mensaje = 'Memorando eliminado con exito.';
                }else{
                    $mensaje.= 'Error al eliminar el memorando';
                }
            }else{
                $mensaje.='Memorando no existe';
            }
            
            Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 1;')->execute();
            
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
    
    function actionEliminarComunicado(){
        $estado = 0;
        $mensaje = null;
        $IdComunicaciones = $_REQUEST['IdComunicaciones'];
        
        $transaction = Yii::$app->db->beginTransaction();
        try {
            Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0;')->execute();
            
            //Validamos que el memorando exista
            $Memorando = Yii::$app->db->createCommand('SELECT * FROM comunicaciones WHERE IdComunicaciones = '.$IdComunicaciones)->queryOne();
            
            if(!empty($Memorando)){
                //Validar los documentos asociados a ese memorando
                $DocumentosMemorandos = Yii::$app->db->createCommand('SELECT * FROM documentos_comunicaciones WHERE IdComunicaciones = '.$IdComunicaciones)->queryAll();
                
                if(!empty($DocumentosMemorandos)){
                    //Eliminar cada registro de documento y posterior cada registro de documentos_memorandos
                    foreach($DocumentosMemorandos AS $DocumentoMemorando){
                        $Documento = Yii::$app->db->createCommand('SELECT * FROM documentos WHERE IdDocumentos = '.$DocumentoMemorando['IdDocumentos'])->queryOne();
                        
                        if(!empty($Documento)){
                            Yii::$app->db->createCommand()->delete('documentos', 'IdDocumentos = '.$Documento['IdDocumentos'])->execute();
                        }
                    }
                    
                    Yii::$app->db->createCommand()->delete('documentos_comunicaciones', 'IdComunicaciones = '.$IdComunicaciones)->execute();
                }
                
                //Eliminar rgistro de la tabla memorandos
                $EliminarMemorando = Yii::$app->db->createCommand()->delete('comunicaciones', 'IdComunicaciones = '.$IdComunicaciones)->execute();
                
                if($EliminarMemorando == 1){
                    $estado = 1;
                    $mensaje = 'Comunicado eliminado con exito.';
                }else{
                    $mensaje.= 'Error al eliminar el comunicado';
                }
            }else{
                $mensaje.='Comunicado no existe';
            }
            
            Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 1;')->execute();
            
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