<?php

namespace app\modules\maestras\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Expression;
use yii\helpers\Json;
use yii\db\Transaction;
use app\modules\maestras\controllers\CargosController;
require_once(Yii::getAlias('@vendor/PHPExcel/Classes/PHPExcel.php'));
use PHPExcel_IOFactory;     
use PHPExcel_Cell; 

/**
 * Default controller for the `usuarios` module
 */
class ProductosController extends Controller
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
            
            $Productos = Yii::$app->db->createCommand('SELECT p.*, c.NombreCategoria, c.Codigo, co.Nombre AS NombreColor FROM productos p INNER JOIN categorias c on c.Idcategorias = p.IdCategorias INNER JOIN colores co ON co.IdColores = p.IdColor ORDER BY c.Codigo ASC, p.Consecutivo ASC')->queryAll();
    
            return $this->render('listar', [
                'Productos' => $Productos,
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }        
    }

    function actionCrear(){
    	if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){
            
            $Categorias = Yii::$app->db->createCommand('SELECT * FROM categorias WHERE Estado = 1')->queryAll();
            $Colores = Yii::$app->db->createCommand('SELECT * FROM colores')->queryAll();

            return $this->render('crear', [
                'Categorias' => $Categorias,
                'Colores' => $Colores,
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionObtenerConsecutivoCategoriaProducto(){
        $IdCategorias = $_REQUEST['IdCategorias'];
        $SiguienteConsecutivo = 0;

        $InfoCategoria = Yii::$app->db->createCommand('SELECT * FROM categorias WHERE Idcategorias = '.$IdCategorias)->queryOne();
        if(!empty($InfoCategoria)){
            $SiguienteConsecutivo = $InfoCategoria['Consecutivo'];
        }

        $SiguienteConsecutivo++;

        echo Json::encode(['SiguienteConsecutivo' => $SiguienteConsecutivo]);
    }

    function actionGuardarProducto(){
        $estado = 0;
        $mensaje = null;

        $IdProductos = null;
        if(isset($_REQUEST['IdProductos'])){
            $IdProductos = $_REQUEST['IdProductos'];
        }

        $ArrayProducto = [
            'IdCategorias' => $_REQUEST['IdCategorias'],
            'Consecutivo' => $_REQUEST['Consecutivo'],
            'Nombre' => $_REQUEST['Nombre'],
            'Descripcion' => $_REQUEST['Descripcion'],
            'IdColor' => $_REQUEST['IdColor'],
        ];

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if($IdProductos == null){
                //Crear registro
                $ArrayProducto['Estado'] = 1;
                $ArrayProducto['FechaCreacion'] = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();

                $RegistrarProducto = Yii::$app->db->createCommand()->insert('productos', $ArrayProducto)->execute();

                if($RegistrarProducto == 1){
                    $estado = 1;
                    $mensaje.='Se registro Producto con exito.';
                }else{
                    $mensaje.='Error al registrar el Producto.';
                }
            }else{
                //Actualizar registro
                $RegistrarProducto = Yii::$app->db->createCommand()->update('productos', $ArrayProducto, 'IdProductos = '.$IdProductos)->execute();

                if($RegistrarProducto == 1){
                    $estado = 1;
                    $mensaje.='Se actualizo Producto con exito.';
                }else{
                    $mensaje.='Error al actualizar el Producto.';
                }
            }

            if($estado == 1){
                $mensaje.=' OK Producto ';

                //Actualizar el consecutivo en la categoria que se le selecciono
                $RegistrarConsecutivo = Yii::$app->db->createCommand()->update('categorias', ['Consecutivo' => $_REQUEST['Consecutivo']], 'Idcategorias = '.$_REQUEST['IdCategorias'])->execute();

                if($RegistrarConsecutivo == 1){
                    $mensaje.='OK consecutivo. ';
                }else{
                    $mensaje.='Error consecutivo. ';
                    $estado = 0;
                }

                if($estado == 1){
                    $transaction->commit();
                }else{
                    $transaction->rollBack();
                }                
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

    function actionEditar($IdProductos){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){
            
            $InfoProducto = Yii::$app->db->createCommand('SELECT * FROM productos WHERE IdProductos = '.$IdProductos)->queryOne();

            $Categorias = Yii::$app->db->createCommand('SELECT * FROM categorias WHERE Estado = 1')->queryAll();
            $Colores = Yii::$app->db->createCommand('SELECT * FROM colores')->queryAll();

            return $this->render('editar', [
                'Categorias' => $Categorias,
                'Colores' => $Colores,
                'InfoProducto' => $InfoProducto,
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionAdministrarImagenesProducto($IdProductos){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){
            
            $InfoProducto = Yii::$app->db->createCommand('SELECT * FROM productos WHERE IdProductos = '.$IdProductos)->queryOne();

            return $this->render('administrar-imagenes-producto', [
                'InfoProducto' => $InfoProducto,
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionActualizarImagenProducto(){
        $estado = 0;
        $mensaje = "";

        $Imagen = $_FILES['Imagen'];
        $Tipo = $_REQUEST['Tipo'];
        $IdProductos = $_REQUEST['IdProductos'];

        $transaction = Yii::$app->db->begintransaction();
        try{
            $InfoProducto = Yii::$app->db->createCommand('SELECT * FROM productos WHERE IdProductos = '.$IdProductos)->queryOne();
            if(!empty($InfoProducto)){
                $CategoriaProducto = Yii::$app->db->createCommand('SELECT * FROM categorias WHERE Idcategorias = '.$InfoProducto['IdCategorias'])->queryOne();

                $NombreArchivoImagen = $CategoriaProducto['Codigo'].'-'.$InfoProducto['Consecutivo'];

                $TipoImagen = "";

                if($Imagen['type'] == 'image/jpeg'){
                    $NombreArchivoImagen.='.jpg';
                    $TipoImagen = 'jpg';
                }elseif($Imagen['type'] == 'image/png'){
                    $NombreArchivoImagen.='.png';
                    $TipoImagen = 'png';
                }elseif($Imagen['type'] == 'image/gif'){
                    $NombreArchivoImagen.='.gif';
                    $TipoImagen = 'gif';
                }else{
                    $NombreArchivoImagen.='.jpg';
                    $TipoImagen = 'jpg';
                }

                $base = '/images/';
                $urlBase = Yii::getAlias('@webroot').$base; //LOCAL
                //$urlBase = '/images/'; //PRODUCCION

                if (!file_exists($urlBase)) {
                    mkdir($urlBase, 0777);
                    chmod($urlBase, 0777);
                }
                $urlBase.='productos/';
                $base.='productos/';
                if (!file_exists($urlBase)) {
                    mkdir($urlBase, 0777);
                    chmod($urlBase, 0777);
                }

                if(copy($Imagen['tmp_name'], $urlBase.$Imagen['name'])){
                    if(rename($urlBase.$Imagen['name'], $urlBase.$NombreArchivoImagen)){
                        $InsertarImagen = Yii::$app->db->createCommand()->insert('imagenes', [
                            'IdTiposImagenes' => 2,
                            'NombreArchivo' => $NombreArchivoImagen,
                            'Url' => $base,
                            'Tipo' => $TipoImagen,
                        ])->execute();

                        if($InsertarImagen == 1){
                            $IdImagenes = Yii::$app->db->getLastInsertID();

                            $ProductosImagenes = Yii::$app->db->createCommand('SELECT * FROM productos_imagenes WHERE IdProductos = '.$IdProductos.' AND Principal = 1')->queryOne();

                            if(!empty($ProductosImagenes)){
                                //Actualizar registro con el IdImagen
                                $InsertarProductoImagen = Yii::$app->db->createCommand()->update('productos_imagenes', [
                                    'IdImagenes' => $IdImagenes,                       
                                ], 'IdProductosImagenes = '.$ProductosImagenes['IdProductosImagenes'])->execute();
                            }else{
                                //Insertar registro
                                $InsertarProductoImagen = Yii::$app->db->createCommand()->insert('productos_imagenes', [
                                    'IdProductos' => $IdProductos,
                                    'IdImagenes' => $IdImagenes,
                                    'Principal' => 1,
                                    'Orden' => 1,                        
                                ])->execute();
                            }

                            if($InsertarProductoImagen == 1){
                                $estado = 1;
                                $mensaje.='Se actualizo imagen con exito'.PHP_EOL;
                            }else{
                                $mensaje.='Error al actualizar imagen'.PHP_EOL;
                            }
                        }else{
                            $mensaje.='Error al crear registro de Imagen. ';
                        }
                    }else{
                        $mensaje.='No se pudo renombrar la imagen'.PHP_EOL;
                    }
                }else{
                    $mensaje.='No se pudo copiar el archivo'.PHP_EOL;
                }
            }else{
                $mensaje.='No existe producto'.PHP_EOL;
            }

            if($estado == 1){
                $transaction->commit();
            }else{
                $transaction->rollback();    
            }            
        } catch (Exception $e) {
            $transaction->rollback();
        }                

        echo Json::encode(['estado' => $estado, 'mensaje' => $mensaje]);
    }
}