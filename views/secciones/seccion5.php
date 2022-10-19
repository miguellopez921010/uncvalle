<?php 
use app\components\Secciones;

$Secciones = new Secciones();
$Datos = $Secciones->ObtenerDatosPorSeccion(5);

if (!Yii::$app->user->isGuest) {
    $UsuarioLogueado = Yii::$app->user->id;

    if ($UsuarioLogueado == 1) {
        //Mostrar en que seccion esta
        echo '<i style="color:red;">---seccion5---</i>';
    }
}
?>

<p class="text-justify">
    Persona  jurídica de derecho privado, sin ánimo de lucro, de carácter gremial, con patrimonio autónomo, conformada por personas naturales que ejercen como Notarios en la circunscripción de los Departamentos de Valle del Cauca, Cauca, Nariño, Caldas y Risaralda, inspirada en los principios y valores universales, solidarios y democráticos, organizada como la expresión del derecho de libre asociación consagrado en la Constitución Política de Colombia, para atender las necesidades de sus asociados, que se rige por la legislación establecida para las entidades sin ánimo de lucro y el presente estatuto, denominada UNION COLEGIADA DE NOTARIADO VALLECAUCANO Y DEL SUROCCIDENTE COLOMBIANO, quien también podrá identificarse con la sigla UNIVOC, para todos los efectos legales.
    <br>
    En la actualidad ejerce como Presidente de “UNIVOC�? el Doctor Holmes Rafael Cardona Montoya.

</p>