<?php
namespace app\components;


use Yii;
use yii\base\Component;
 
class Menu extends Component{

 	public function ObtenerMenu($Seccion = null){
  		$MenuPrincipal = Yii::$app->db->createCommand('SELECT * FROM menu '.($Seccion!=null?'  WHERE Seccion = "'.$Seccion.'" ':'').' ORDER BY IdPadre DESC, Orden ASC')->queryAll();

  		return $MenuPrincipal;
 	} 
}
?>