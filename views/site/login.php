<?php



/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */



use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

?>

<div class="site-login">

    <div class="row">

        <div class="col-md-4"></div>

        <div class="col-md-4 col-xs-12" style="border: 1px solid #ddd;">

            <h1 class="text-center">Inicio de sesi&oacute;n</h1>



            <?php $form = ActiveForm::begin([

                'id' => 'login-form',

                'layout' => 'horizontal',

            ]); ?>



                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Usuario'])->label(false) ?>



                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Contrasena'])->label(false) ?>



                <?= $form->field($model, 'rememberMe')->checkbox()->label('Recordar mi contrasena') ?>



                <div class="form-group text-center">

                    <?= Html::submitButton('Iniciar Sesion', ['class' => 'btn btn-primary text-center', 'style' => 'margin: 0px auto;', 'name' => 'login-button']) ?>

                </div>



            <?php ActiveForm::end(); ?>

        </div>

        <div class="col-md-4"></div>

    </div>

</div>

