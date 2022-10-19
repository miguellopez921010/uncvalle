<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'UNIVOC',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Mhp4Bw_2RXhY6OrmK_0YplCFa94ePZjt',
            'baseUrl' => str_replace('/web', '', (new \yii\web\Request)->getBaseUrl()),
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [ 
            'linkAssets' => false, 
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mail' => [
             'class' => 'yii\swiftmailer\Mailer',
             'transport' => [
                 'class' => 'Swift_SmtpTransport',
                 'host' => 'localhost',  // ej. smtp.mandrillapp.com o smtp.gmail.com
                 'username' => 'username',
                 'password' => 'password',
                 'port' => '587', // El puerto 25 es un puerto común también
                 'encryption' => 'tls', // Es usado también a menudo, revise la configuración del servidor
             ],
         ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => array(
                '' => 'site/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'menu' => [
            'class' => 'app\components\MenuComponent',
        ],
        'secciones' => [
            'class' => 'app\components\SeccionesComponent',
        ],
        'configuracion' => [
            'class' => 'app\components\ConfiguracionComponent',
        ],
    ],
    'modules' => [
        /*'proyectos' => [
            'class' => 'app\modules\proyectos\Proyectos',
        ],*/
        'maestras' => [
            'class' => 'app\modules\maestras\Maestras',
        ],
        'cuenta' => [
            'class' => 'app\modules\cuenta\Cuenta',
        ],
        'administrador' => [
            'class' => 'app\modules\administrador\Administrador',
        ],
        'gestionNotarias' => [
            'class' => 'app\modules\gestionNotarias\GestionNotarias',
        ],
        /*'menu' => [
            'class' => 'app\modules\menu\Menu',
        ],
        'clientes' => [
            'class' => 'app\modules\clientes\Clientes',
        ],
        'productos' => [
            'class' => 'app\modules\productos\Productos',
        ],*/
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '186.81.12.44'],
    ];
}

return $config;
