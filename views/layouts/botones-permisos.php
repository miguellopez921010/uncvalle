<style>
	#panel-botones-permisos .btn-group>button{
		margin-right: 2px;
	}
</style>

<?php 
//$MenuPermisos = \Yii::$app->getRequest()->getCookies()->getValue('Permisos');

$MenuPermisos = Yii::$app->session->get('Permisos');

if($MenuPermisos != null && !empty($MenuPermisos)){
	?>
	<div class="panel panel-default" id="panel-botones-permisos">
		<div class="panel-body text-center" style="padding: 10px !important;">
		<?php 
		foreach ($MenuPermisos AS $Modulo => $arrayModulo) {
			if(Yii::$app->controller->module->id == $Modulo){
				foreach ($arrayModulo AS $Controlador => $arrayControlador) {
					if(Yii::$app->controller->id == $Controlador){
						if(!empty($arrayControlador)){
							?>
							<div class="btn-group">
								<?php 
								foreach ($arrayControlador AS $Valor) {
									if($Valor['DataRequest'] == 0){
										?>
										<button type="button" class="btn btn-primary" onclick="window.location.href = '<?=Yii::getAlias('@web').'/'.$Valor['Url']?>'"><?=ucwords(str_replace('-', ' ', $Valor['Permiso']))?></button>
										<?php
									}
								}
								?>
							</div>
							<?php
						}
					}
				}
			}
    	}
		?>			
		</div>
	</div>
	<?php    
}
?>