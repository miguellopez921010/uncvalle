<?php
namespace app\components;


use Yii;
use yii\base\Component;
 
class Configuracion extends Component{

 	public function ObtenerConfiguracion(){
  		$Configuracion = Yii::$app->db->createCommand('SELECT * FROM configuracion')->queryOne();

  		return $Configuracion;
 	} 
}
?>