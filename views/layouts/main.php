<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode(Yii::$app->name) ?></title>
        <?php $this->head() ?>
        <link rel="shortcut icon" type="image/png" href="<?=Yii::getAlias('@web')?>/images/logo.png"/>
        
    </head>
    <body>
        <?php $this->beginBody() ?>

        <!--/*background-image: url(<?=Url::to('@web/images/FONDOS/papel-tapiz1.jpg')?>); background-repeat: repeat;
  background-attachment: fixed;
  background-position: center;*/-->
  
        <div class="wrap" style="">
            <?php echo $this->render('header.php'); ?>

            <div class="container" style="padding-top: 30px;">
                <?php //echo $this->render('menu-principal.php'); ?>
                
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <?php echo $this->render('footer.php'); ?>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
