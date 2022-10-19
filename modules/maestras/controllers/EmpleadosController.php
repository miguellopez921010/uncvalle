<?php

namespace app\modules\maestras\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Expression;
use yii\helpers\Json;
use yii\db\Transaction;
use app\modules\maestras\controllers\CargosController;

/**
 * Default controller for the `usuarios` module
 */
class EmpleadosController extends Controller
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
            $CargosPadre = CargosController::actionCargosCargoUsuario(Yii::$app->user->identity->IdUsuario); 
            
            if(!empty($CargosPadre)){
                $CargosPadre[] = 999;
                $ListaUsuarios = Yii::$app->db->createCommand('SELECT personas.*, cargos.*, usuarios.IdUsuario, usuarios.estado '
                    . 'FROM empleados '
                    . 'INNER JOIN usuarios ON usuarios.IdUsuario = empleados.IdUsuario '
                    . 'INNER JOIN personas ON personas.NumeroDocumento = usuarios.username '
                    . 'INNER JOIN cargos ON cargos.IdCargo = empleados.IdCargo '
                    . 'WHERE empleados.IdCargo NOT IN ('.implode(',', $CargosPadre).')')->queryAll();
            }else{
                $ListaUsuarios = Yii::$app->db->createCommand('SELECT personas.*, cargos.*, usuarios.IdUsuario, usuarios.estado '
                    . 'FROM empleados '
                    . 'INNER JOIN usuarios ON usuarios.IdUsuario = empleados.IdUsuario '
                    . 'INNER JOIN personas ON personas.NumeroDocumento = usuarios.username '
                    . 'INNER JOIN cargos ON cargos.IdCargo = empleados.IdCargo '
                    . 'WHERE empleados.IdCargo NOT IN (999)'
                )->queryAll();
            }            
    
            return $this->render('listar', [
                'ListaUsuarios' => $ListaUsuarios
            ]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionCrear(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){
            $CargosPadre = CargosController::actionCargosCargoUsuario(Yii::$app->user->identity->IdUsuario);             
            if(!empty($CargosPadre)){
                $CargosPadre[] = 999;
                $Cargos = Yii::$app->db->createCommand('SELECT * FROM cargos WHERE IdCargo NOT IN ('.implode(',', $CargosPadre).')')->queryAll();
            }else{
                $Cargos = Yii::$app->db->createCommand('SELECT * FROM cargos WHERE IdCargo NOT IN (999)')->queryAll();
            }
            return $this->render('crear', ['Cargos' => $Cargos]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }
    
    function actionEditar($IdUsuario){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){
            $InfoUsuario = Yii::$app->db->createCommand('SELECT personas.*, usuarios.*, empleados.IdCargo '
                    . 'FROM usuarios '
                    . 'INNER JOIN personas ON personas.NumeroDocumento = usuarios.username '
                    . 'INNER JOIN empleados ON empleados.IdUsuario = usuarios.IdUsuario '
                    . 'INNER JOIN cargos ON cargos.IdCargo = empleados.IdCargo '
                    . 'WHERE usuarios.IdUsuario = '.$IdUsuario)->queryOne();
            
            $CargosPadre = CargosController::actionCargosCargoUsuario(Yii::$app->user->identity->IdUsuario);            
            if(!empty($CargosPadre)){
                $Cargos = Yii::$app->db->createCommand('SELECT * FROM cargos WHERE IdCargo NOT IN ('.implode(',', $CargosPadre).')')->queryAll();
            }else{
                $Cargos = Yii::$app->db->createCommand('SELECT * FROM cargos')->queryAll();
            }            
            return $this->render('editar', ['Cargos' => $Cargos, 'InfoUsuario' => $InfoUsuario]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }        
    }

    function actionGuardarEmpleado(){
        $estado = 1;
        $mensaje = "";
        
        $IdUsuario = null;
        if(isset($_REQUEST['IdUsuario'])){
            $IdUsuario = $_REQUEST['IdUsuario'];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($IdUsuario == null){
                //Registrar empleado
                //Insertar registro en la tabla Personas
                $persona = Yii::$app->db->createCommand()->insert('personas',
                    [
                        'NumeroDocumento' => $_REQUEST['NumeroDocumento'],
                        'Nombres' => $_REQUEST['Nombres'],
                        'Apellidos' => $_REQUEST['Apellidos'],
                        'Email' => $_REQUEST['Email'],
                        'FechaCreacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                        'FechaModificacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                    ]
                )->execute();

                if($persona == 1){
                    $mensaje.='Se creo la Persona exitosamente. ';
                    $IdPersona = Yii::$app->db->getLastInsertID();

                    //Insertar registro en la tabla Usuarios
                    $usuario = Yii::$app->db->createCommand()->insert('usuarios',
                        [
                            'username' => $_REQUEST['NumeroDocumento'],
                            'password' => sha1($_REQUEST['Password1']),
                            'email' => $_REQUEST['Email'],
                            'estado' => 1,
                        ]
                    )->execute();

                    if($usuario == 1){
                        $mensaje.='Se creo el Usuario exitosamente. ';
                        $IdUsuario = Yii::$app->db->getLastInsertID();

                        //Insertar registro en la tabla Usuarios
                        $empleado = Yii::$app->db->createCommand()->insert('empleados',
                            [
                                'IdUsuario' => $IdUsuario,
                                'IdCargo' => $_REQUEST['IdCargo'],
                            ]
                        )->execute();

                        if($empleado == 1){
                            $estado = 1;
                            $mensaje.='Se creo el Empleado exitosamente. ';
                            
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

                            //Asociar el usuario con el Rol en la tabla auth_assigment
                            $InfoCargo = Yii::$app->db->createCommand('SELECT * FROM cargos WHERE IdCargo = '.$_REQUEST['IdCargo'])->queryOne();

                            if($InfoCargo != null){
                                $OkCrearAsociacionPermisoCargo = false;
                                $item_name = str_replace(' ','',ucwords(strtolower($InfoCargo['NombreCargo'])));

                                //Validar que el item exista en la table auth_item, si no es asi, crearlo
                                $auth_item = Yii::$app->db->createCommand('SELECT * FROM auth_item WHERE name LIKE "'.$item_name.'"')->queryOne();

                                if(!$auth_item){      
                                    /*echo Yii::$app->db->createCommand()->insert('auth_item',
                                        [
                                            'name' => $item_name,
                                            'type' => 1,
                                            'description' => null,
                                            'index' => 0,
                                            'datos_request' => 0,
                                            'created_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                            'updated_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                        ]
                                    )->getRawSql();*/

                                    $auth_item = Yii::$app->db->createCommand()->insert('auth_item',
                                        [
                                            'name' => $item_name,
                                            'type' => 1,
                                            'description' => null,
                                            'index' => 0,
                                            'datos_request' => 0,
                                            'created_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                            'updated_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                        ]
                                    )->execute();
                                    
                                    if($auth_item == 1){
                                        $OkCrearAsociacionPermisoCargo = true;
                                    }else{
                                    }
                                }else{
                                    $OkCrearAsociacionPermisoCargo = true;
                                }
                                
                                if($OkCrearAsociacionPermisoCargo){
                                    $auth_assignment = Yii::$app->db->createCommand()->insert('auth_assignment',
                                        [
                                            'item_name' => $item_name,
                                            'user_id' => $IdUsuario,
                                            'created_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                        ]
                                    )->execute();
                                    
                                    if($auth_assignment == 1){
                                        $mensaje.='Se asociaron los permisos del cargo '.$InfoCargo['NombreCargo'].' al usuario. ';
                                    }
                                }
                            }
                        }else{
                            $estado = 0;
                            $mensaje.='Error al crear el Empleado. ';
                        }
                    }else{
                        $estado = 0;
                        $mensaje.='Error al crear el Usuario. ';
                    }
                }else{
                    $estado = 0;
                    $mensaje.='Error al crear la Persona. ';
                }
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

                                $Infoempleado = Yii::$app->db->createCommand('SELECT * FROM empleados WHERE IdUsuario = '.$IdUsuario)->queryOne();

                                if($Infoempleado != null){
                                    if($_REQUEST['IdCargo'] == $Infoempleado['IdCargo']){
                                        $empleado = 1;
                                    }else{
                                        $empleado = Yii::$app->db->createCommand()->update('empleados',
                                            [
                                                'IdCargo' => $_REQUEST['IdCargo'],
                                            ], 
                                            'IdUsuario = '.$IdUsuario
                                        )->execute();
                                    }                                    

                                    if($empleado == 1){
                                        $estado = 1;
                                        $mensaje.='Se actualizó Empleado exitosamente. ';
                                
                                        $InfoCargo = Yii::$app->db->createCommand('SELECT * FROM cargos WHERE IdCargo = '.$_REQUEST['IdCargo'])->queryOne();
                                        if($InfoCargo != null){
                                            $OkCrearAsociacionPermisoCargo = false;
                                            $item_name = str_replace(' ','',ucwords(strtolower($InfoCargo['NombreCargo'])));

                                            $auth_item = Yii::$app->db->createCommand('SELECT * FROM auth_item WHERE name LIKE "'.$item_name.'"')->queryOne();
                                            if($auth_item == null){
                                                $auth_item = Yii::$app->db->createCommand()->insert('auth_item',
                                                    [
                                                        'name' => $item_name,
                                                        'type' => 1,
                                                        'url' => '',
                                                        'created_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                                        'updated_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                                    ]
                                                )->execute();
                                                
                                                if($auth_item == 1){
                                                    $OkCrearAsociacionPermisoCargo = true;
                                                }
                                            }else{
                                                $OkCrearAsociacionPermisoCargo = true;
                                            }

                                            if($OkCrearAsociacionPermisoCargo){
                                                //Validar que dicho usuario tenga ese permiso, si no lo tiene, dse debe eliminar los otros permisos que tiene y colocar este nuevo
                                                $auth_assignment = Yii::$app->db->createCommand('SELECT * FROM auth_assignment WHERE user_id = '.$IdUsuario.' AND item_name = "'.$item_name.'"')->queryOne();

                                                if($auth_assignment != null){
                                                    //Ya tiene ese permiso asignado
                                                }else{
                                                    //Eliminar los permisos que tiene en este momento asignado
                                                    $auth_assignment_usuario = Yii::$app->db->createCommand('SELECT * FROM auth_assignment WHERE user_id = '.$IdUsuario)->queryAll();

                                                    $OkAsignarNuevoPermisoUsuario = false;
                                                    if(!empty($auth_assignment_usuario)){
                                                        //Eliminarlos
                                                        Yii::$app->db->createCommand('DELETE FROM auth_assignment WHERE user_id = '.$IdUsuario)->execute();

                                                        $OkAsignarNuevoPermisoUsuario = true;
                                                    }else{
                                                        //N o hay permisos asignados a este usuario
                                                        $OkAsignarNuevoPermisoUsuario = true;
                                                    }

                                                    if($OkAsignarNuevoPermisoUsuario){
                                                            $auth_assignment = Yii::$app->db->createCommand()->insert('auth_assignment',
                                                            [
                                                                'item_name' => $item_name,
                                                                'user_id' => $IdUsuario,
                                                                'created_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                                            ]
                                                        )->execute();
                                                        
                                                        if($auth_assignment == 1){
                                                            $mensaje.='Se asociaron los permisos del cargo '.$InfoCargo['NombreCargo'].' al usuario. ';
                                                        }
                                                    }
                                                }
                                            }
                                        }

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
                                        $mensaje.='Error al actualizar el Empleado. ';
                                    }
                                }else{
                                    $estado = 0;
                                    $mensaje.='No hay Empleado registrado. ';
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

    function actionCambiarEstadoUsuario(){
        $estado = 0;
        $mensaje = "";
        $IdUsuario = $_REQUEST['IdUsuario'];
        $NuevoEstado = $_REQUEST['NuevoEstado'];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $ActualizarEstadoUsuario = Yii::$app->db->createCommand()->update('usuarios',
                [
                    'estado' => $NuevoEstado
                ], 
                'IdUsuario = '.$IdUsuario
            )->execute();

            if($ActualizarEstadoUsuario == 1){
                $estado = 1;
                $mensaje.='Se actualizó estado al usuario. ';
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

    function actionCambiarContrasena(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){
            $IdUsuario = $_REQUEST['IdUsuario'];

            return $this->render('cambiar-contrasena', ['IdUsuario' => $IdUsuario]);
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        }
    }

    function actionCambiarContrasenaUsuario(){
        $estado = 0;
        $mensaje = '';

        $IdUsuario = $_REQUEST['IdUsuario'];
        $Password1 = trim($_REQUEST['Password1']);
        $Password2 = trim($_REQUEST['Password2']);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($IdUsuario != null && $Password1 != null && $Password2 != null){
                $Password1sha1 = sha1($Password1);
                $Password2sha1 = sha1($Password2);

                $InfoUsuario = Yii::$app->db->createCommand('SELECT * FROM usuarios WHERE IdUsuario = '.$IdUsuario)->queryOne();

                if($InfoUsuario != null){
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

    function actionCargar(){
        if(!Yii::$app->user->isGuest && Yii::$app->user->can(Yii::$app->controller->module->id.'_'.Yii::$app->controller->id.'_'.Yii::$app->controller->action->id)){        
    
            return $this->render('cargar');
        }else{
            return $this->render('//site/error', array('name' => '403 Acceso Denegado' , 'message' => "Usted no tiene permisos para realizar la accion."));
        } 
    }

    /*function actionCargarEmpleadosMasivo(){
        $ruta_archivo = $_FILES['ArchivoEmpleados']['tmp_name'];

        $objPHPExcel = PHPExcel_IOFactory::load($ruta_archivo);

        $NumeroDeLinea = 1;
        $arrayColumnasObligatorias = array(0, 1, 2, 4); //NumeroDocumento, Nombres, Apellidos, Cargo
        
        $Errores = [];
        $CantidadInsertados = 0;
        $CantidadErrores = 0;
        $NitInsertados = '';
        $NitErroneos = '';
        $PrimerRegistroInsertar = true;
        $mensaje = '';

        foreach ($objPHPExcel->getActiveSheet()->getRowIterator() AS $row) {
            if ($NumeroDeLinea > 1) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $NumeroDeColumna = 0;
                $permiteRegistrar = true;                
                $arrayValores = array();

                foreach ($cellIterator as $cell) {
                    if ($permiteRegistrar) {
                        if (in_array($NumeroDeColumna, $arrayColumnasObligatorias) && $cell->getCalculatedValue() == '') {
                            $permiteRegistrar = false;
                        } else {
                            $OkNumerico = true;
                            if($NumeroDeColumna == 0){
                                //Validar que sea un valor numerico
                                if($cell->getCalculatedValue() * 1 == 0){
                                    $OkNumerico = false;
                                }
                            }

                            if($OkNumerico){
                                $arrayValores[] = trim($cell->getCalculatedValue());
                                $NumeroDeColumna++;
                            }else{
                                $permiteRegistrar = false;
                            }
                        }
                    }
                }

                if($permiteRegistrar){
                    $estadoInterno = 0;
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        //Validar que la persona con documento X no exista en la BD, si existe, debe actualizar la informacion de la persona
                        $ExistePersona = Yii::$app->db->createCommand('SELECT * FROM personas WHERE NumeroDocumento = '.$arrayValores[0])->queryOne();

                        $IdPersona = 0;
                        if($ExistePersona == null){
                            //Crear la persona
                            $InsertarPersona = Yii::$app->db->createCommand()->insert('personas', [
                                'NumeroDocumento' => $arrayValores[0],
                                'Nombres' => $arrayValores[1],
                                'Apellidos' => $arrayValores[2],
                                'Email' => $arrayValores[3],
                            ])->execute();

                            if($InsertarPersona == 1){
                                $IdPersona = Yii::$app->db->getLastInsertID();
                                $mensaje.='Se ha registrado la Persona correctamente con Cedula '.$arrayValores[0].'. ';
                            }else{
                                $mensaje.='Error al registrar la persona con Cedula '.$arrayValores[0].'. ';
                            }
                        }else{
                            //Actualizar la Persona
                            $IdPersona = $ExistePersona['IdPersona'];
                            $ActualizarPersona = Yii::$app->db->createCommand()->update('personas', [
                                'Nombres' => $arrayValores[1],
                                'Apellidos' => $arrayValores[2],
                                'Email' => $arrayValores[3],
                                'FechaModificacion' => (new \yii\db\Query)->select(new Expression('NOW()'))->scalar(),
                            ], 
                            'IdPersona = '.$IdPersona)->execute();

                            if($ActualizarPersona == 1){                                
                                $mensaje.='Se actualizó la informacion de la Persona con Cedula '.$arrayValores[0].'. ';
                            }else{
                                $mensaje.='Error al actualizar la informacion de la Persona con Cedula '.$arrayValores[0].'. ';
                            }
                        }

                        if($IdPersona != 0){
                            //Validamos que exista el registro en la tabla usuarios, si existe el registro solo se actualiza el Email si lo ha cambiado, de resto sigue igual
                            $ExisteUsuario = Yii::$app->db->createCommand('SELECT * FROM usuarios WHERE username = '.$arrayValores[0])->queryOne();

                            $IdUsuario = 0;
                            if($ExisteUsuario == null){
                                //Creamos el registro
                                $InsertarUsuario = Yii::$app->db->createCommand()->insert('usuarios',[
                                    'username' => $arrayValores[0],
                                    'password' => sha1($arrayValores[0]),
                                    'email' => $arrayValores[3],
                                    'estado' => 1,
                                ])->execute();

                                if($InsertarUsuario == 1){
                                    $IdUsuario = Yii::$app->db->getLastInsertID();
                                    $mensaje.='Se registró el usuario correctamente con Cedula '.$arrayValores[0].'. ';
                                }else{
                                    $mensaje.='Error al registrar el usuario con Cedula '.$arrayValores[0].'. ';
                                }
                            }else{
                                //Actualizamos el registro usuario solo el campo Email
                                $IdUsuario = $ExisteUsuario['IdUsuario'];
                                if($ExisteUsuario['email'] == $arrayValores[3]){
                                    //No se actualiza el registro
                                }else{
                                    //Actualizamos el email del registro usuario
                                    $ActualizarUsuario = Yii::$app->db->createCommand()->update('usuarios', [
                                        'email' => $arrayValores[3],
                                    ], 
                                    'IdUsuario = '.$IdUsuario)->execute();

                                    if($ActualizarUsuario == 1){                                
                                        $mensaje.='Se actualizó la informacion del Usuario con Cedula '.$arrayValores[0].'. ';
                                    }else{
                                        $mensaje.='Error al actualizar la informacion del Usuario con Cedula '.$arrayValores[0].'. ';
                                    }
                                }
                            }

                            if($IdUsuario != 0){
                                //Obtener el cargo por medio del nombre
                                $InfoCargo = Yii::$app->db->createCommand('SELECT * FROM cargos WHERE NombreCargo = "'.$arrayValores[4].'"')->queryOne();

                                $IdEmpleado = 0;
                                if($InfoCargo != null){
                                    //Validamos si ya existe el registro Empleado con dicho documento y el cargo
                                    $ExisteEmpleado = Yii::$app->db->createCommand('SELECT * FROM empleados WHERE IdUsuario = '.$IdUsuario)->queryOne();

                                    if($ExisteEmpleado == null){
                                        //Creamos la asociacion entre el usuario y el cargo
                                        $InsertarEmpleado = Yii::$app->db->createCommand()->insert('empleados',[
                                            'IdUsuario' => $IdUsuario,
                                            'IdCargo' => $InfoCargo['IdCargo'],
                                        ])->execute();

                                        if($InsertarEmpleado == 1){
                                            $IdEmpleado = Yii::$app->db->getLastInsertID();
                                            $mensaje.='Se registro empleado con exito. ';
                                            $estadoInterno = 1;
                                        }
                                    }else{
                                        //Si el cargo que ahora esta ingresando es diferente al que antes tenia, debe actualizarse
                                        $IdEmpleado = $ExisteEmpleado['IdEmpleado'];
                                        if($ExisteEmpleado['IdCargo'] == $InfoCargo['IdCargo']){
                                            //Es el mismo cargo, no se actualiza el registro en la BD
                                            $estadoInterno = 1;
                                        }else{
                                            $ActualizarEmpleado = Yii::$app->db->createCommand()->update('empleados', [
                                                'IdCargo' => $InfoCargo['IdCargo']
                                            ], 
                                            'IdEmpleado = '.$IdEmpleado)->execute();

                                            if($ActualizarEmpleado == 1){
                                                $mensaje.='Se actualizó el Cargo del empleado. ';
                                                $estadoInterno = 1;
                                            }else{
                                                $mensaje.='Error al actualizar el cargo del empleado. ';
                                            }
                                        }
                                    }

                                    //Asignar los permisos respectivos
                                    if($IdEmpleado != 0){
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

                                        $OkCrearAsociacionPermisoCargo = false;
                                        //Asociar el usuario con el Rol en la tabla auth_assigment
                                        $item_name = str_replace(' ','',ucwords(strtolower($InfoCargo['NombreCargo'])));
                                            
                                        //Validar que el item exista en la table auth_item, si no es asi, crearlo
                                        $auth_item = Yii::$app->db->createCommand('SELECT * FROM auth_item WHERE name LIKE "'.$item_name.'"')->queryOne();
                                        if($auth_item == null){
                                            $auth_item = Yii::$app->db->createCommand()->insert('auth_item',
                                                [
                                                    'name' => $item_name,
                                                    'type' => 1,
                                                    'url' => '',
                                                    'created_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                                    'updated_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                                ]
                                            )->execute();
                                            
                                            if($auth_item == 1){
                                                $OkCrearAsociacionPermisoCargo = true;
                                            }
                                        }else{
                                            $OkCrearAsociacionPermisoCargo = true;
                                        }
                                        
                                        if($OkCrearAsociacionPermisoCargo){
                                            $auth_assignment = Yii::$app->db->createCommand()->insert('auth_assignment',
                                                [
                                                    'item_name' => $item_name,
                                                    'user_id' => $IdUsuario,
                                                    'created_at' => (new \yii\db\Query)->select(new Expression('UNIX_TIMESTAMP(NOW())'))->scalar(),
                                                ]
                                            )->execute();
                                            
                                            if($auth_assignment == 1){
                                                $mensaje.='Se asociaron los permisos del cargo '.$InfoCargo['NombreCargo'].' al usuario. ';
                                            }
                                        }
                                            
                                    }

                                }



                            }
                        }

                        if($estadoInterno == 1){
                            $mensaje.=' OK ';
                            $transaction->commit();
                        }else{
                            $transaction->rollBack();
                        }

                        $mensaje.='<br><br>';
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                    } catch (\Throwable $e) {
                        $transaction->rollBack();
                    }

                }else{
                    $Errores[] = ['Fila' => $NumeroDeLinea, 'Columna' => $NumeroDeColumna];
                }
            }

            $NumeroDeLinea++;
        }

        if(!empty($Errores)){
            $mensaje.='<br><br>';
            $mensaje.='<b>ERRORES</b><br>';
            $mensaje.=json_encode($Errores);
        }

        echo Json::encode([
            'mensaje' => $mensaje,
            'Errores' => $Errores
        ]);

    }*/
}
