<?php
require 'library/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

include '../Conexion/conexion.php';

// Consulta a la base de datos
$obj = new Conexion();
$sql = "SELECT AlumnoID, DNI, Nombres, Apellidos, Fec_Nacimiento, Fec_Registro FROM alumnos";
$res = mysqli_query($obj->conecta(), $sql) or die(mysqli_error($obj->conecta()));

// Armar HTML
$html = '
    <h2 style="text-align: center;">Reporte de Alumnos</h2>
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr style="background-color: #eee;">
                <th>ID</th>
                <th>DNI</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>F. Nacimiento</th>
                <th>F. Registro</th>
            </tr>
        </thead>
        <tbody>';

while ($fila = mysqli_fetch_array($res)) {
    $html .= '<tr>
                <td>' . $fila['AlumnoID'] . '</td>
                <td>' . $fila['DNI'] . '</td>
                <td>' . $fila['Nombres'] . '</td>
                <td>' . $fila['Apellidos'] . '</td>
                <td>' . $fila['Fec_Nacimiento'] . '</td>
                <td>' . $fila['Fec_Registro'] . '</td>
            </tr>';
}

$html .= '</tbody></table>';

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("reporte_alumnos.pdf", array("Attachment" => true));
exit;
