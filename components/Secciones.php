<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\components\Menu;

class Secciones extends Component {

    public function ObtenerSeccionesPorBloque($IdBloque) {
        $SeccionesPorBloque = Yii::$app->db->createCommand('SELECT S.* FROM secciones_bloques SB INNER JOIN secciones S ON S.IdSecciones = SB.IdSecciones AND S.Estado = 1 WHERE SB.IdBloques = ' . $IdBloque . ' ORDER BY S.Orden ASC')->queryAll();

        return $SeccionesPorBloque;
    }

    function ObtenerDatosPorSeccion($IdSeccion) {
        $Datos = [];

        switch ($IdSeccion) {
            case 1:
                //Banners
                $Banners = Yii::$app->db->createCommand("SELECT * FROM imagenes I INNER JOIN tipos_imagenes TI ON I.IdTiposImagenes = TI.IdTiposImagenes WHERE I.IdTiposImagenes = 1 AND I.Estado = 1")->queryAll();
                $Datos['Banners'] = $Banners;
                break;
            case 2:
                //Noticias
                $Noticias = Yii::$app->db->createCommand("SELECT * FROM noticias N WHERE NOW() BETWEEN N.FechaHoraInicio AND N.FechaHoraFin ORDER BY Prioridad ASC, FechaPublicacion DESC")->queryAll();
                $Datos['Noticias'] = $Noticias;
                break;
            case 3:
                $Menu = new Menu();
                $OpcionesMenu = $Menu->ObtenerMenu('seccion' . $IdSeccion);
                $Datos['Opciones'] = $OpcionesMenu;
                break;
            case 10:
                //Directorio de notarias
                $Departamentos = Yii::$app->db->createCommand('SELECT * FROM departamentos WHERE DirectorioNotarias = 1 ORDER BY NombreDepartamento ASC')->queryAll();                
                $Datos['Departamentos'] = $Departamentos;
                break;
            case 11:
                $Menu = new Menu();
                $OpcionesMenu = $Menu->ObtenerMenu('seccion' . $IdSeccion);
                $Datos['Opciones'] = $OpcionesMenu;
                $CategoriasMemorandos = Yii::$app->db->createCommand('SELECT * FROM categorias_memorandos ORDER BY Orden ASC')->queryAll();
                $Memorandos = Yii::$app->db->createCommand('SELECT * FROM memorandos ORDER BY NombreMemorando DESC')->queryAll();
                $Datos['Memorandos'] = $Memorandos;
                $Datos['CategoriasMemorandos'] = $CategoriasMemorandos;
                break;
            case 12:
                $Galeria = Yii::$app->db->createCommand('SELECT * FROM imagenes I INNER JOIN tipos_imagenes TI ON I.IdTiposImagenes = TI.IdTiposImagenes WHERE I.IdTiposImagenes = 3 AND I.Estado = 1 ORDER BY IdImagenes ASC')->queryAll(); 
                $Datos['Galeria'] = $Galeria;
                break;
            case 13:
                $Menu = new Menu();
                $OpcionesMenu = $Menu->ObtenerMenu('seccion' . $IdSeccion);
                $Datos['Opciones'] = $OpcionesMenu;
                break;
            case 14:
                $Foros = Yii::$app->db->createCommand('SELECT F.*, I.*, TI.* FROM foros F LEFT JOIN imagenes I ON I.IdImagenes = F.IdImagenes LEFT JOIN tipos_imagenes TI ON I.IdTiposImagenes = TI.IdTiposImagenes 
 	            ORDER BY F.FechaForo DESC, F.HoraForo DESC')->queryAll();
                $Datos['Foros'] = $Foros;
                break;
            case 15:
                $Menu = new Menu();
                $OpcionesMenu = $Menu->ObtenerMenu('seccion' . $IdSeccion);
                $Datos['Opciones'] = $OpcionesMenu;
                $Comunicaciones = Yii::$app->db->createCommand('SELECT * FROM comunicaciones ORDER BY IdComunicaciones DESC')->queryAll();
                $Datos['Comunicaciones'] = $Comunicaciones;
                break;
            default:
                break;
        }

        return $Datos;
    }

}

?>