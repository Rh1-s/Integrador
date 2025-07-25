<?php
require 'library/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;
include '../Conexion/conexion.php';
include '../Negocio/negocio.php';

// Parámetros
$curso_id = isset($_GET['curso_id']) ? (int)$_GET['curso_id'] : 0;
$fecha    = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

$obj      = new Negocio();
$curso    = $obj->getCursoById($curso_id);
$alumnos  = $obj->getAsistenciaByCursoFecha($curso_id, $fecha);

if (!$curso) {
    die("Curso no encontrado.");
}

// HTML para el PDF
$html = '
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2, h4 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: center; }
        .header { text-align: left; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Reporte de Asistencia</h2>
    <h4>Curso: '.htmlspecialchars($curso['Nombre_Curso']).' (Sección: '.htmlspecialchars($curso['Nombre_Seccion']).')</h4>
    <p class="header"><strong>Fecha:</strong> '.$fecha.'</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Alumno</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>';

        $i = 1;
        foreach ($alumnos as $a) {
            $html .= '<tr>
                <td>'.$i++.'</td>
                <td>'.htmlspecialchars($a['Nombres'].' '.$a['Apellidos']).'</td>
                <td>'.htmlspecialchars($a['Estado']).'</td>
            </tr>';
        }

$html .= '
        </tbody>
    </table>
</body>
</html>';

// Configuración de Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Nombre del archivo
$filename = "Asistencia_".$curso['Nombre_Curso']."_".$fecha.".pdf";
$dompdf->stream($filename, ["Attachment" => false]);
exit;