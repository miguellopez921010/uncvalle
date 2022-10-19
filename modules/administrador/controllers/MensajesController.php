<?php

namespace app\modules\administrador\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Expression;
use yii\helpers\Json;
use yii\db\Transaction;

/**
 * Default controller for the `Administrador` module
 */
class MensajesController extends Controller
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
            $MensajesContactenos = Yii::$app->db->createCommand('SELECT * FROM mensajes_contactenos ORDER BY FechaHoraRegistro DESC')->queryAll();

            return $this->render('listar', ['MensajesContactenos' => $MensajesContactenos]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }    	
    }
    
    function actionVerMensajeContactenos(){
        $IdMensaje = $_REQUEST['IdMensaje'];
        
        $RegistroMensajeContactenos = Yii::$app->db->createCommand('SELECT * FROM mensajes_contactenos WHERE IdMensajesContactenos = '.$IdMensaje)->queryOne();
        
        return $this->renderPartial('_ver-mensaje-contactenos', [
                    'RegistroMensajeContactenos' => $RegistroMensajeContactenos,
        ]);
    }
}
