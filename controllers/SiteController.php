<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Cookie;
use yii\db\Expression;
use yii\helpers\Json;
use yii\db\Transaction;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $NombrePagina = Yii::$app->controller->action->id;

        //SumarCantidadTotalVisitas
        Yii::$app->db->createCommand('UPDATE configuracion SET TotalVisitas = TotalVisitas+1')->execute();

        $BloquesPagina = Yii::$app->db->createCommand("SELECT B.* FROM paginas P INNER JOIN bloques_paginas BP ON BP.IdPaginas = P.IdPaginas INNER JOIN bloques B ON B.IdBloques = BP.IdBloques WHERE P.NombrePagina LIKE '" . $NombrePagina . "'")->queryAll();

        return $this->render('index', [
                    'NombrePagina' => $NombrePagina,
                    'BloquesPagina' => $BloquesPagina,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //Crear una cookie con los permisos de cada uno
            self::PermisosUsuarioMenuLateral();
            return $this->redirect(Yii::getAlias('@web') . '/cuenta/cuenta/mi-cuenta');
        }

        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    function actionCerrarsesion() {
        self::actionLogout();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContactenos() {
        $NombrePagina = Yii::$app->controller->action->id;

        $BloquesPagina = Yii::$app->db->createCommand("SELECT B.* FROM paginas P INNER JOIN bloques_paginas BP ON BP.IdPaginas = P.IdPaginas INNER JOIN bloques B ON B.IdBloques = BP.IdBloques WHERE P.NombrePagina LIKE '" . $NombrePagina . "'")->queryAll();

        return $this->render('contactenos', [
                    'NombrePagina' => $NombrePagina,
                    'BloquesPagina' => $BloquesPagina,
        ]);
    }

    function actionQuienesSomos() {
        $NombrePagina = Yii::$app->controller->action->id;

        $BloquesPagina = Yii::$app->db->createCommand("SELECT B.* FROM paginas P INNER JOIN bloques_paginas BP ON BP.IdPaginas = P.IdPaginas INNER JOIN bloques B ON B.IdBloques = BP.IdBloques WHERE P.NombrePagina LIKE '" . $NombrePagina . "'")->queryAll();

        return $this->render('quienes-somos', [
                    'NombrePagina' => $NombrePagina,
                    'BloquesPagina' => $BloquesPagina,
        ]);
    }

    function actionEstatutos() {
        $NombrePagina = Yii::$app->controller->action->id;

        $BloquesPagina = Yii::$app->db->createCommand("SELECT B.* FROM paginas P INNER JOIN bloques_paginas BP ON BP.IdPaginas = P.IdPaginas INNER JOIN bloques B ON B.IdBloques = BP.IdBloques WHERE P.NombrePagina LIKE '" . $NombrePagina . "'")->queryAll();

        return $this->render('estatutos', [
                    'NombrePagina' => $NombrePagina,
                    'BloquesPagina' => $BloquesPagina,
        ]);
    }

    function actionConsejoDirectivo() {
        $NombrePagina = Yii::$app->controller->action->id;

        $BloquesPagina = Yii::$app->db->createCommand("SELECT B.* FROM paginas P INNER JOIN bloques_paginas BP ON BP.IdPaginas = P.IdPaginas INNER JOIN bloques B ON B.IdBloques = BP.IdBloques WHERE P.NombrePagina LIKE '" . $NombrePagina . "'")->queryAll();

        return $this->render('consejo-directivo', [
                    'NombrePagina' => $NombrePagina,
                    'BloquesPagina' => $BloquesPagina,
        ]);
    }

    function actionGuardarContactenos() {
        date_default_timezone_set('America/Bogota');
        $estado = 0;
        $mensaje = null;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $Datos['Nombre'] = $_REQUEST['Nombre'];
            $Datos['Correo'] = $_REQUEST['Correo'];
            $Datos['Asunto'] = $_REQUEST['Asunto'];
            $Datos['Mensaje'] = $_REQUEST['Mensaje'];

            $Insertar = Yii::$app->db->createCommand()->insert('mensajes_contactenos', $Datos)->execute();

            if ($Insertar == 1) {
                $estado = 1;
                $mensaje .= 'Se registro mensaje con exito. ';
            } else {
                $mensaje .= 'Error al registrar mensaje. ';
            }

            if ($estado == 1) {
                $transaction->commit();

                /* if(Yii::$app->mailer->compose()
                  //->setFrom('admin@uncvalle.com')
                  ->setTo('sistemas@uncvalle.com')
                  ->setSubject('Nuevo mensaje de contactenos')
                  ->setHtmlBody('<ul><li>Nombre persona: '.$Nombres.'<li>Email persona: '.$Email.'</li><li>Telefono persona: '.$Telefono.'</li><li>Mensaje: '.$MensajeC.'</li><li>Fecha hora: '.date("Y-m-d H:i:s").'</li></ul>')
                  ->send()){
                  $mensaje.='Se envio correo';
                  }else{
                  $mensaje.='Error al enviar correo';
                  } */
            } else {
                $transaction->rollBack();
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }

        echo Json::encode(['estado' => $estado, 'mensaje' => $mensaje]);
    }

    function actionDirectorioNotarias() {
        $NombrePagina = Yii::$app->controller->action->id;

        $BloquesPagina = Yii::$app->db->createCommand("SELECT B.* FROM paginas P INNER JOIN bloques_paginas BP ON BP.IdPaginas = P.IdPaginas INNER JOIN bloques B ON B.IdBloques = BP.IdBloques WHERE P.NombrePagina LIKE '" . $NombrePagina . "'")->queryAll();

        return $this->render('directorio-notarias', [
                    'NombrePagina' => $NombrePagina,
                    'BloquesPagina' => $BloquesPagina,
        ]);
    }

    function actionMemorandos() {
        $NombrePagina = Yii::$app->controller->action->id;

        $BloquesPagina = Yii::$app->db->createCommand("SELECT B.* FROM paginas P INNER JOIN bloques_paginas BP ON BP.IdPaginas = P.IdPaginas INNER JOIN bloques B ON B.IdBloques = BP.IdBloques WHERE P.NombrePagina LIKE '" . $NombrePagina . "'")->queryAll();

        return $this->render('memorandos', [
                    'NombrePagina' => $NombrePagina,
                    'BloquesPagina' => $BloquesPagina,
        ]);
    }

    function actionGaleriaFotos() {
        $NombrePagina = Yii::$app->controller->action->id;

        $BloquesPagina = Yii::$app->db->createCommand("SELECT B.* FROM paginas P INNER JOIN bloques_paginas BP ON BP.IdPaginas = P.IdPaginas INNER JOIN bloques B ON B.IdBloques = BP.IdBloques WHERE P.NombrePagina LIKE '" . $NombrePagina . "'")->queryAll();

        return $this->render('galeria-fotos', [
                    'NombrePagina' => $NombrePagina,
                    'BloquesPagina' => $BloquesPagina,
        ]);
    }

    function actionPermanenciaEsalDian() {
        $NombrePagina = Yii::$app->controller->action->id;
        $AnioDefecto = 2021;

        $BloquesPagina = Yii::$app->db->createCommand("SELECT B.* FROM paginas P INNER JOIN bloques_paginas BP ON BP.IdPaginas = P.IdPaginas INNER JOIN bloques B ON B.IdBloques = BP.IdBloques WHERE P.NombrePagina LIKE '" . $NombrePagina . "'")->queryAll();

        return $this->render('galeria-fotos', [
                    'NombrePagina' => $NombrePagina,
                    'BloquesPagina' => $BloquesPagina,
                    'AnioDefecto' => $AnioDefecto,
        ]);
    }

    function actionPruebaCkeditor() {
        return $this->render('prueba-ckeditor', [
        ]);
    }

    function actionCargarMemorandosAnio() {
        var_dump($_REQUEST);
    }

    function actionCargarPermanenciaesaldianAnio() {
        $Anio = $_REQUEST['Anio'];

        $DocumentosSeccion = Yii::$app->db->createCommand("SELECT DS.*, D.NombreDocumento, D.RutaDocumento FROM documentos_secciones DS INNER JOIN documentos D ON D.IdDocumentos = DS.IdDocumentos WHERE DS.IdSecciones = 13 AND DS.Subcarpeta = '" . $Anio . "' ORDER BY DS.Orden ASC")->queryAll();

        return $this->renderPartial('_permanencia-esal-dian', [
                    'DocumentosSeccion' => $DocumentosSeccion,
                    'Anio' => $Anio,
        ]);
    }

    function PermisosUsuarioMenuLateral() {
        if (!Yii::$app->user->isGuest) {
            $UsuarioLogueado = Yii::$app->user->id;

            $Permisos = [];

            $ArrayPerfilesUsuarioLogueado = [];
            $ArrayPermisosUsuarioLogueado = [];

            $PerfilesUsuarioLogueado = Yii::$app->db->createCommand('SELECT * FROM auth_assignment WHERE user_id = ' . $UsuarioLogueado)->queryAll();

            if (!empty($PerfilesUsuarioLogueado)) {
                foreach ($PerfilesUsuarioLogueado AS $Perfil) {
                    if (!in_array($Perfil['item_name'], $ArrayPerfilesUsuarioLogueado)) {
                        array_push($ArrayPerfilesUsuarioLogueado, $Perfil['item_name']);
                    }
                }
            }

            if (!empty($ArrayPerfilesUsuarioLogueado)) {
                $PermisosUsuarioLogueado = Yii::$app->db->createCommand("SELECT * FROM auth_item_child WHERE parent IN ('" . implode("','", $ArrayPerfilesUsuarioLogueado) . "')")->queryAll();

                if (!empty($PermisosUsuarioLogueado)) {
                    foreach ($PermisosUsuarioLogueado AS $Permiso) {
                        if (!in_array($Permiso['child'], $ArrayPermisosUsuarioLogueado)) {
                            array_push($ArrayPermisosUsuarioLogueado, $Permiso['child']);
                        }
                    }
                }
            }


            if (!empty($ArrayPermisosUsuarioLogueado)) {
                foreach ($ArrayPermisosUsuarioLogueado AS $P) {
                    $InfoAuthItem = Yii::$app->db->createCommand('SELECT * FROM auth_item WHERE name = "' . $P . '"')->queryOne();

                    if ($InfoAuthItem != null) {
                        $array_permiso_interno = explode('_', $P);
                        if (count($array_permiso_interno) == 3) {
                            $Permisos[$array_permiso_interno[0]][$array_permiso_interno[1]][] = [
                                'Permiso' => $array_permiso_interno[2],
                                'Url' => $InfoAuthItem['description'],
                                'Index' => $InfoAuthItem['index'],
                                'DataRequest' => $InfoAuthItem['datos_request'],
                            ];
                        }
                    }
                }
            }

            ksort($Permisos);

            /* $cookie = new Cookie([
              'name' => 'Permisos',
              'value' => $Permisos,
              'expire' => time() + 86400 * 365,
              ]); */

            Yii::$app->session->set('Permisos', $Permisos);
            //Yii::$app->getResponse()->getCookies()->add($cookie);
        } else {
            Yii::$app->session->remove('Permisos');
            //Yii::$app->response->cookies->remove( 'Permisos' );
        }
    }

    function actionCargarCiudadesPorDepartamento() {
        $IdDepartamento = $_REQUEST['IdDepartamento'];

        if ($IdDepartamento != '') {
            $Ciudades = Yii::$app->db->createCommand('SELECT * FROM ciudades ' . ($IdDepartamento != '' ? ' WHERE IdDepartamento = ' . $IdDepartamento : '') . ' ORDER BY NombreCiudad ASC')->queryAll();
        } else {
            $Ciudades = [];
        }

        echo Json::encode(['Ciudades' => $Ciudades]);
    }

    function actionListarDirectorioNotarias() {
        $IdDepartamento = '';
        $IdCiudad = '';
        if (isset($_REQUEST['IdDepartamento'])) {
            $IdDepartamento = $_REQUEST['IdDepartamento'];
        }
        if (isset($_REQUEST['IdCiudad'])) {
            $IdCiudad = $_REQUEST['IdCiudad'];
        }

        if ($IdDepartamento != '' || $IdCiudad != '') {
            $Notarias = Yii::$app->db->createCommand('SELECT N.*, D.NombreDepartamento, C.NombreCiudad FROM notarias N INNER JOIN departamentos D ON N.IdDepartamento = D.IdDepartamento INNER JOIN ciudades C ON N.IdCiudad = C.IdCiudad ' . ($IdDepartamento != '' || $IdCiudad != '' ? ' WHERE ' . ($IdDepartamento != '' ? ' N.IdDepartamento = ' . $IdDepartamento : '') . ($IdCiudad != '' ? ' AND N.IdCiudad = ' . $IdCiudad : '') : '') . ' ORDER BY D.NombreDepartamento ASC, N.NumeroNotaria ASC, C.NombreCiudad ASC')->queryAll();            
            if(!empty($Notarias)){
                foreach ($Notarias AS $Contador => $N){
                    $Notarios = Yii::$app->db->createCommand('SELECT * FROM notarios WHERE IdNotarias = '.$N['IdNotarias'])->queryAll();
                    $EmailsNotarias = Yii::$app->db->createCommand('SELECT * FROM emails_notarias WHERE IdNotarias = '.$N['IdNotarias'])->queryAll();
                    $TelefonosNotarias = Yii::$app->db->createCommand('SELECT TN.*, TT.Nombre FROM telefonos_notarias TN INNER JOIN tipos_telefonos TT ON TT.IdTiposTelefonos = TN.IdTiposTelefonos  WHERE IdNotarias = '.$N['IdNotarias'])->queryAll();
                    $Notarias[$Contador]['Notarios'] = $Notarios;
                    $Notarias[$Contador]['EmailsNotarias'] = $EmailsNotarias;
                    $Notarias[$Contador]['TelefonosNotarias'] = $TelefonosNotarias;
                }
            }
        } else {
            $Notarias = [];
        }

        return $this->renderPartial('_listar-directorio-notarias', [
                    'Notarias' => $Notarias,
        ]);
    }

    function actionVerDocumento() {
        $IdDocumento = $_REQUEST['IdDocumento'];

        $Documento = Yii::$app->db->createCommand('SELECT * from documentos WHERE IdDocumentos = ' . $IdDocumento)->queryOne();

        return $this->renderPartial('_ver-documento', [
                    'IdDocumento' => $IdDocumento,
                    'Documento' => $Documento,
        ]);
    }

    function actionForos() {
        $NombrePagina = Yii::$app->controller->action->id;

        $BloquesPagina = Yii::$app->db->createCommand("SELECT B.* FROM paginas P INNER JOIN bloques_paginas BP ON BP.IdPaginas = P.IdPaginas INNER JOIN bloques B ON B.IdBloques = BP.IdBloques WHERE P.NombrePagina LIKE '" . $NombrePagina . "'")->queryAll();

        return $this->render('quienes-somos', [
                    'NombrePagina' => $NombrePagina,
                    'BloquesPagina' => $BloquesPagina,
        ]);
    }

    function actionCargarInformacionForo() {
        $IdForo = $_REQUEST['IdForo'];

        $Foro = Yii::$app->db->createCommand("SELECT * FROM foros F WHERE IdForos = " . $IdForo)->queryOne();

        return $this->renderPartial('_cargar-informacion-foro', [
                    'Foro' => $Foro,
        ]);
    }

    function actionVerNoticia() {
        $IdNoticia = $_REQUEST['IdNoticia'];
        $NombrePagina = Yii::$app->controller->action->id;

        $Noticia = Yii::$app->db->createCommand('SELECT * FROM noticias WHERE IdNoticias = ' . $IdNoticia)->queryOne();

        return $this->render('ver-noticia', [
                    'IdNoticia' => $IdNoticia,
                    'Noticia' => $Noticia,
                    'NombrePagina' => $NombrePagina,
        ]);
    }

    function actionVerMemorando() {
        $IdMemorandos = $_REQUEST['IdMemorandos'];
        $NombrePagina = Yii::$app->controller->action->id;

        //Obtener los archivos del memorando
        $DocumentosMemorando = Yii::$app->db->createCommand('SELECT * FROM documentos_memorandos DM INNER JOIN documentos D ON DM.IdDocumentos = D.IdDocumentos WHERE DM.IdMemorandos = ' . $IdMemorandos)->queryAll();

        return $this->render('ver-memorando', [
                    'IdMemorandos' => $IdMemorandos,
                    'DocumentosMemorando' => $DocumentosMemorando,
                    'NombrePagina' => $NombrePagina,
        ]);
    }

    function actionVerComunicado() {
        $IdComunicaciones = $_REQUEST['IdComunicaciones'];
        $NombrePagina = Yii::$app->controller->action->id;

        //Obtener los archivos del memorando
        $DocumentosComunicaciones = Yii::$app->db->createCommand('SELECT * FROM documentos_comunicaciones DM INNER JOIN documentos D ON DM.IdDocumentos = D.IdDocumentos WHERE DM.IdComunicaciones = ' . $IdComunicaciones)->queryAll();

        return $this->render('ver-comunicado', [
                    'IdComunicaciones' => $IdComunicaciones,
                    'DocumentosComunicaciones' => $DocumentosComunicaciones,
                    'NombrePagina' => $NombrePagina,
        ]);
    }

    function actionComunicaciones() {
        $NombrePagina = Yii::$app->controller->action->id;

        $BloquesPagina = Yii::$app->db->createCommand("SELECT B.* FROM paginas P INNER JOIN bloques_paginas BP ON BP.IdPaginas = P.IdPaginas INNER JOIN bloques B ON B.IdBloques = BP.IdBloques WHERE P.NombrePagina LIKE '" . $NombrePagina . "'")->queryAll();

        return $this->render('comunicaciones', [
                    'NombrePagina' => $NombrePagina,
                    'BloquesPagina' => $BloquesPagina,
        ]);
    }

    public function GenerarTextoAleatorio($CantidadTexto = 10){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, $CantidadTexto);
    }

    function actionVerImagen() {
        $IdImagen = $_REQUEST['IdImagen'];

        $Imagen = Yii::$app->db->createCommand('SELECT I.*, TI.Nombre AS RutaCarpeta from imagenes I INNER JOIN tipos_imagenes TI ON TI.IdTiposImagenes = I.IdTiposImagenes WHERE I.IdImagenes = ' . $IdImagen)->queryOne();

        return $this->renderPartial('_ver-imagen', [
                    'IdImagen' => $IdImagen,
                    'Imagen' => $Imagen,
        ]);
    }

}
