<?php

namespace app\modules\administrador\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Expression;
use yii\helpers\Json;
use yii\db\Transaction;

/**
 * Default controller for the `usuarios` module
 */
class PaginasController extends Controller
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
            
            $Paginas = Yii::$app->db->createCommand('SELECT * FROM paginas')->queryAll();
    
            return $this->render('listar', [
                'Paginas' => $Paginas,
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    public function actionCrear()
    {
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){
                
            return $this->render('crear');
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }
}
?>