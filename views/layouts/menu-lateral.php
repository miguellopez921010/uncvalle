<?php 
if(!Yii::$app->user->isGuest){

    $MenuPermisos = Yii::$app->session->get('Permisos');

    //$MenuPermisos = \Yii::$app->getRequest()->getCookies()->getValue('Permisos');

    if($MenuPermisos != null && !empty($MenuPermisos)){
        ?>
    <div class="panel-group" id="accordionMenuLateral">
        <?php 
        foreach ($MenuPermisos AS $Modulo => $arrayModulo) {
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordionMenuLateral" href="#collapse<?=$Modulo?>"><?=strtoupper(str_replace('-', ' ', $Modulo))?></a>
                    </h4>
                </div>
                <?php 
                $CollapseOpen = '';
                if(Yii::$app->controller->module->id == $Modulo){
                    $CollapseOpen = ' in ';
                }
                ?>
                <div id="collapse<?=$Modulo?>" class="panel-collapse collapse <?=$CollapseOpen?>">
                    <ul class="list-group">
                        <?php 
                        foreach ($arrayModulo AS $Controlador => $arrayControlador) {
                            $UrlIndex = '';
                            $ActiveLink = '';
                            foreach ($arrayControlador AS $Valor) {
                                if($Valor['Index'] == 1){
                                    $UrlIndex = $Valor['Url'];
                                }
                            }

                            if(Yii::$app->controller->id == $Controlador){
                                $ActiveLink = ' active ';
                            }

                            if($UrlIndex == ''){
                                ?>
                            <li class="list-group-item">
                                <?=ucwords(str_replace('-', ' ', $Controlador))?>                                
                            </li>
                                <?php
                            }else{
                                ?>
                            <li class="list-group-item">
                                <a class="btn btn-link <?=$ActiveLink?>" style="padding-top: 0px;padding-bottom: 0px;width: 100%;text-align: left;" href="<?=Yii::getAlias('@web').'/'.$UrlIndex?>">
                                    <?=ucwords(str_replace('-', ' ', $Controlador))?>
                                </a>                            
                            </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                    <!--<div class="panel-footer">Footer</div>-->
                </div>
            </div>
            <?php
        }
        ?>
    </div>
        <?php
    }
}else{
    Yii::$app->session->remove('Permisos');
    //Yii::$app->response->cookies->remove( 'Permisos' );
    Yii::$app->response->redirect(['site/login']);
}
