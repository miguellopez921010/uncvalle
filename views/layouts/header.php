<?php



/* @var $this \yii\web\View */

/* @var $content string */



use app\widgets\Alert;

use yii\helpers\Html;

use yii\bootstrap\Nav;

use yii\bootstrap\NavBar;

use yii\widgets\Breadcrumbs;

use app\assets\AppAsset;



AppAsset::register($this);



use app\components\Menu;



$Menu = new Menu();

$MostrarMenu = $Menu->ObtenerMenu('menu');

?>



<style type="text/css">

    @import url('https://fonts.googleapis.com/css?family=Catamaran&display=swap');

    *{

        font-family: 'Catamaran', sans-serif;

    }

</style>

<?php

$urlWeb = (new \yii\web\Request)->getBaseUrl();



$baseUrl = str_replace('/web', '', $urlWeb);

?>



<nav class="navbar navbar-expand-lg navbar-light">

    <div class="container">

        <a class="navbar-brand" href="/" style="padding: 0px;">

            <img src="<?=Yii::getAlias('@web')?>/images/logo.png" title="<?=Yii::$app->name?>" width="70" class="img-responsive">

        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>



        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="display: table !important;">

            <div style="float: right !important;">

                <ul class="navbar-nav mr-auto">

                    <?php

                    if(!empty($MostrarMenu)){

                        $Submenu = [];

                        

                        foreach ($MostrarMenu AS $OpcionMenu) {

                            if($OpcionMenu['IdPadre'] == 0){

                                if(isset($Submenu[$OpcionMenu['IdMenu']])){

                                    if(!empty($Submenu[$OpcionMenu['IdMenu']])){

                                        ?>

                                    <li class="nav-item dropdown">

                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                          <?=$OpcionMenu['Nombre']?>

                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                            <?php 

                                            foreach($Submenu[$OpcionMenu['IdMenu']] AS $Sub){

                                                ?>

                                            <a class="dropdown-item" href="<?=$baseUrl.$Sub['Url']?>">

                                                <?=$Sub['Nombre']?>

                                            </a>

                                                <?php

                                            }

                                            ?>

                                        </div>

                                    </li>

                                        <?php

                                    }else{

                                        ?>

                                        <li class="nav-item">

                                            <a class="nav-link" href="<?=$baseUrl.$OpcionMenu['Url']?>">

                                                <?=$OpcionMenu['Nombre']?>

                                            </a>

                                        </li>

                                        <?php

                                    }

                                }else{

                                    ?>

                                    <li class="nav-item">

                                        <a class="nav-link" href="<?=$baseUrl.$OpcionMenu['Url']?>">

                                            <?=$OpcionMenu['Nombre']?>

                                        </a>

                                    </li>

                                    <?php

                                }                        

                            }else{

                                $Submenu[$OpcionMenu['IdPadre']][] = $OpcionMenu;

                            }                  

                        }

                    }

                    ?>

                </ul>

                

                <ul class="navbar-nav">

                   	<?php

                    if(Yii::$app->user->isGuest){

                        ?>

                        <li class="nav-item">

                            <a class="nav-link" onclick="window.location.href='<?=Yii::getAlias('@web')?>/site/login'">INICIAR SESI&Oacute;N</a>

                        </li>

                        <?php    

                    }else{

                        ?>

                        <li class="nav-item">

                            <a class="nav-link" onclick="window.location.href='<?=Yii::getAlias('@web')?>/cuenta/cuenta/mi-cuenta'">MI CUENTA (<?=Yii::$app->user->identity->username?>)

                            </a>

                        </li>

                        <li class="nav-item">

                            <form type="POST" action="<?=Yii::getAlias('@web')?>/site/cerrarsesion">

                                <button type="submit" class="btn btn-link" style="margin-top: 10px; color: #000; text-decoration: none; text-transform: uppercase; font-weight: bold; color: #613947 !important;">CERRAR SESI&Oacute;N</button>

                            </form>

                        </li>

                        <?php

                    }

                    ?>

                </ul>

            </div>

        </div>

    </div>    

</nav>



<input type="hidden" name="urlBase" id="urlBase" value="<?=$baseUrl?>">

<input type="hidden" name="urlWeb" id="urlWeb" value="<?=$urlWeb?>">



<?php echo $this->render('modals.php'); ?>