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
class BannersController extends Controller{

    public function beforeAction($action){ 
         $this->layout = '@app/views/layouts/main-interno.php';
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);     
    }

	function actionListar(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

            $Banners = [];

            return $this->render('listar', [
                'Banners' => $Banners
            ]);

        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionCrear(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){

            $TiposBanners = Yii::$app->db->createCommand('SELECT * FROM tiposimagenes WHERE IdTiposImagenesProductos IN (1)')->queryAll();

            return $this->render('crear', [
                'TiposBanners' => $TiposBanners,
            ]);

        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionGuardarBanner(){
        $Estado = 0;
        $Mensaje = null;

        $Datos = $_REQUEST;
        $DatosImagen = $_FILES['Imagen'];
        
        $transaction = Yii::$app->db->begintransaction();
        try{
            //Crear las carpetas donde va a ir almacenado la imagen
            $base = '/images/';
            $urlBase = Yii::getAlias('@webroot').$base; //LOCAL
            //$urlBase = '/images/'; //PRODUCCION

            if (!file_exists($urlBase)) {
                mkdir($urlBase, 0777);
                chmod($urlBase, 0777);
            }
            $urlBase.='banners/';
            $base.='banners/';
            if (!file_exists($urlBase)) {
                mkdir($urlBase, 0777);
                chmod($urlBase, 0777);
            }

            if($Datos['IdTipoBanner'] == 1){
                //Banners principales
                $urlBase.='principales/';
                $base.='principales/';
                if (!file_exists($urlBase)) {
                    mkdir($urlBase, 0777);
                    chmod($urlBase, 0777);
                }
            }

            //Copiar el archivo en la ruta especifica
            if(copy($DatosImagen['tmp_name'], $urlBase.$DatosImagen['name'])){
                //Obtener ultimo consecutivo almacenado en la tabla consecutivos de BANNERS PRINCIPALES
                $Consecutivo = 0;
                $IdConsecutivos = null;

                $UltimoConsecutivo = Yii::$app->db->createCommand('SELECT * FROM consecutivos WHERE IdConsecutivos = 1')->queryOne();
                if(!empty($UltimoConsecutivo)){
                    $Consecutivo = $UltimoConsecutivo['Consecutivo'];
                    $IdConsecutivos = $UltimoConsecutivo['IdConsecutivos'];
                }else{
                    //Crear registro
                    $InsertarConsecutivo = Yii::$app->db->createCommand()->insert('consecutivos', [
                        'Nombre' => 'BANNERS PRINCIPALES',
                        'Consecutivo' => $Consecutivo,                      
                    ])->execute();

                    if($InsertarConsecutivo == 1){
                        $IdConsecutivos = Yii::$app->db->getLastInsertID();
                    }
                }
                $Consecutivo++;

                $NombreArchivo = 'banner_principal-'.$Consecutivo;
                $TipoImagen = "";

                if($DatosImagen['type'] == 'image/jpeg'){
                    $NombreArchivo.='.jpg';
                    $TipoImagen = 'jpg';
                }elseif($DatosImagen['type'] == 'image/png'){
                    $NombreArchivo.='.png';
                    $TipoImagen = 'png';
                }elseif($DatosImagen['type'] == 'image/gif'){
                    $NombreArchivo.='.gif';
                    $TipoImagen = 'gif';
                }else{
                    $NombreArchivo.='.jpg';
                    $TipoImagen = 'jpg';
                }

                if(rename($urlBase.$DatosImagen['name'], $urlBase.$NombreArchivo)){
                    //Crear registro en la tabla imagenes
                    $InsertarImagen = Yii::$app->db->createCommand()->insert('imagenes', [
                        'IdTiposImagenes' => $Datos['IdTipoBanner'],
                        'NombreArchivo' => $NombreArchivo,
                        'Url' => $base,
                        'Tipo' => $TipoImagen,
                    ])->execute();

                    if($InsertarImagen == 1){
                        $IdImagenes = Yii::$app->db->getLastInsertID();

                        $InsertarBanner = Yii::$app->db->createCommand()->insert('banners', [
                            'Nombre' => $Datos['Nombre'],
                            'IdImagenes' => $IdImagenes,
                            'Enlace' => $Datos['Enlace'],                        
                        ])->execute();

                        if($InsertarBanner == 1){
                            $Estado = 1;
                            $Mensaje.='Banner creado con exito. ';

                            //Actualizar el consecutivo

                            $ActualizarConsecutivo = Yii::$app->db->createCommand()->update('consecutivos', [
                                'Consecutivo' => $Consecutivo,                      
                            ], 'IdConsecutivos = '.$IdConsecutivos)->execute();
                        }else{
                            $Mensaje.='Error al crear registro de Banner. ';
                        }
                    }else{
                        $Mensaje.='Error al crear registro de Imagen. ';
                    }
                }else{
                    $Mensaje.='Error al renombrar el archivo. ';
                }
            }else{
                $Mensaje.='Error al copiar la imagen en la carpeta. ';
            }

            if($Estado == 1){
                $transaction->commit();
            }else{
                $transaction->rollback();    
            }            
        } catch (Exception $e) {
            $transaction->rollback();
        }

        echo Json::encode(['Estado' => $Estado, 'Mensaje' => $Mensaje]);
    }

}