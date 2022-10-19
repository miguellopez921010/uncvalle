<?php

namespace app\modules\maestras\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Expression;
use yii\helpers\Json;
use yii\db\Transaction;
use app\modules\maestras\controllers\CargosController;
use app\controllers\SiteController;

/**
 * Default controller for the `usuarios` module
 */
class ImagenesController extends Controller
{
    public function beforeAction($action){ 
        $this->layout = '@app/views/layouts/main-interno.php';
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);     
    }
    
    public function actionListar()
    {
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){
            $CargosPadre = CargosController::actionCargosCargoUsuario(Yii::$app->user->identity->IdUsuario); 
            
            $ListaTiposImagenes = [];
            
            $TiposImagenes = Yii::$app->db->createCommand('SELECT * FROM tipos_imagenes')->queryAll();
                
            if(!empty($TiposImagenes)){
                foreach($TiposImagenes AS $TI){
                    $ListaTiposImagenes[$TI['IdTiposImagenes']] = $TI['Nombre'];
                }
            }
            
            $ListaImagenes = Yii::$app->db->createCommand('SELECT * FROM imagenes I INNER JOIN tipos_imagenes TI ON TI.IdTiposImagenes = I.IdTiposImagenes'
                )->queryAll();          
    
            return $this->render('listar', [
                'ListaImagenes' => $ListaImagenes,
                'TiposImagenesPermitido' => $ListaTiposImagenes,
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionCargar(){
        $ListaTiposImagenes = [];
            
        $TiposImagenes = Yii::$app->db->createCommand('SELECT * FROM tipos_imagenes'
            )->queryAll();
            
        if(!empty($TiposImagenes)){
            foreach($TiposImagenes AS $TI){
                $ListaTiposImagenes[$TI['IdTiposImagenes']] = $TI['Nombre'];
            }
        }

        return $this->render('cargar', [
            'TiposImagenesPermitido' => $ListaTiposImagenes,
        ]);
    }

    function actionCambiarEstadoImagen(){
        $Estado = 0;
        $Mensaje = null;

        $IdImagen = $_REQUEST['IdImagen'];
        $NuevoEstado = $_REQUEST['NuevoEstado'];

        $ActualizarImagen = Yii::$app->db->createCommand()->update('imagenes', [
            'Estado' => $NuevoEstado,
        ], 'IdImagenes = '.$IdImagen)->execute();

        if($ActualizarImagen == 1){
            $Estado = 0;
            $Mensaje .= "Se actualizo el estado de la Imagen.";
        }else{
            $Mensaje .= "Error al actualizar el estado de la Imagen.";
        }

        echo Json::encode(['Estado' => $Estado, 'Mensaje' => $Mensaje]);
    }

    function actionEliminarImagen(){
        $Estado = 0;
        $Mensaje = null;

        $IdImagen = $_REQUEST['IdImagen'];

        $Imagen = Yii::$app->db->createCommand('SELECT I.*, TI.Nombre AS RutaCarpeta FROM imagenes I INNER JOIN tipos_imagenes TI ON TI.IdTiposImagenes = I.IdTiposImagenes WHERE I.IdImagenes = '.$IdImagen)->queryOne();

        if(!empty($Imagen)){
            //Eliminar la imagen de la carpeta
            $RutaImagen = Yii::getAlias('@webroot') . '/images/' . $Imagen['RutaCarpeta'] . '/' . $Imagen['NombreImagen'];

            if(file_exists($RutaImagen)){
                unlink($RutaImagen); //Se elimina el archivo de la carpeta

                $EliminarRegistro = Yii::$app->db->createCommand()->delete('imagenes', ['IdImagenes' => $IdImagen])->execute();

                if($EliminarRegistro == 1){
                    $Estado = 1;
                    $Mensaje .= 'Se elimino registro con exito.';
                }else{
                    $Mensaje .= 'Error al eliminar registro.';
                }
            }else{
                $Mensaje .= "No existe la imagen en la carpeta.";
            }
        }else{
            $Mensaje .= 'No existe la imagen seleccionada';
        }

        echo Json::encode(['Estado' => $Estado, 'Mensaje' => $Mensaje]);
    }

    function actionSubirImagenes(){
        $Estado = 1;
        $Mensaje = null;
        $IdTipoImagen = $_REQUEST['IdTipoImagen'];
        $Imagenes = $_FILES['archivo'];

        if(!empty($Imagenes)){
            $CantidadImagenes = count($Imagenes['name']);
            $TipoImagen = Yii::$app->db->createCommand('SELECT * FROM tipos_imagenes WHERE IdTiposImagenes = '.$IdTipoImagen)->queryOne();
            $DirectorioCopiar = Yii::getAlias('@webroot') . '/images/' . $TipoImagen['Nombre'] . '/';

            for($i=0;$i<$CantidadImagenes;$i++){
                $TieneError = $Imagenes['error'][$i];

                if($TieneError == 0){
                    $ArchivoTemporalImagen = $Imagenes['tmp_name'][$i];
                    $NuevoNombreArchivo = self::GenerarTextoAleatorio(20);
                    $TipoArchivo = $Imagenes['type'][$i];
                    $NombreOriginal = $Imagenes['name'][$i];
                    $ExtensionArchivo = 'jpg';

                    switch($TipoArchivo){
                        case "image/png":
                            $ExtensionArchivo = 'png';
                            break;
                        case "image/jpg":
                            $ExtensionArchivo = 'jpg';
                            break;
                        case "image/jpeg":
                            $ExtensionArchivo = 'jpeg';
                            break;
                    }

                    $NombreImagen = $NuevoNombreArchivo.'.'.$ExtensionArchivo;

                    if(move_uploaded_file($ArchivoTemporalImagen, $DirectorioCopiar.$NombreImagen)) { 
                        $Mensaje .= 'Imagen '.$NombreOriginal.' copiada con exito.'.PHP_EOL;
                        //Crear el registro en tabla de imagenes
                        $RegistrarImagen = Yii::$app->db->createCommand()->insert('imagenes',
                            [
                                'NombreImagen' => $NombreImagen,
                                'IdTiposImagenes' => $IdTipoImagen,
                                'Estado' => 1,
                                'FechaHoraRegistro' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                            ]
                        )->execute();

                        if($RegistrarImagen == 1){
                            $Mensaje .= 'Registro imagen creada con exito'.PHP_EOL.PHP_EOL;
                        }else{
                            $Estado = 0;
                            $Mensaje .= 'Error al registrar imagen.'.PHP_EOL.PHP_EOL;
                        }
                    } else {    
                        $Estado = 0;
                        $Mensaje .= 'Error al copiar el archivo con el nombre '.$NombreOriginal.PHP_EOL.PHP_EOL;
                    }
                }else{
                    $Estado = 0;
                    $Mensaje .= 'Error al cargar el archivo con el nombre '.$NombreOriginal.PHP_EOL.PHP_EOL;
                }
            }
        }else{
            $Estado = 0;
            $Mensaje .= "No hay imagenes a cargar";
        }

        $ListaTiposImagenes = [];
            
        $TiposImagenes = Yii::$app->db->createCommand('SELECT * FROM tipos_imagenes'
            )->queryAll();
            
        if(!empty($TiposImagenes)){
            foreach($TiposImagenes AS $TI){
                $ListaTiposImagenes[$TI['IdTiposImagenes']] = $TI['Nombre'];
            }
        }


        return $this->render('cargar', [
            'Mensaje' => $Mensaje,
            'TiposImagenesPermitido' => $ListaTiposImagenes,
        ]);
    }

    public function GenerarTextoAleatorio($CantidadTexto = 10){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, $CantidadTexto);
    }
}