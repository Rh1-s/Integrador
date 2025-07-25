<?php
require 'library/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include '../Conexion/conexion.php';


$curso_id = $_GET['curso_id'] ?? null;
$fecha = $_GET['fecha'] ?? null;

if (!$curso_id || !$fecha) {
    die("Faltan parámetros: curso_id o fecha");
}

// Conexión
$obj = new Conexion();

// Consulta de asistencias
$sql = "
    SELECT 
        a.AlumnoID,
        a.DNI,
        CONCAT(a.Nombres, ' ', a.Apellidos) AS Alumno,
        asi.Fecha,
        asi.Estado,
        c.Nombre_Curso
    FROM Asistencias asi
    INNER JOIN Alumnos a ON asi.AlumnoID = a.AlumnoID
    INNER JOIN Matricula_Curso mc ON mc.AlumnoID = a.AlumnoID
    INNER JOIN Cursos c ON mc.CursoID = c.CursoID
    WHERE c.CursoID = '$curso_id' AND asi.Fecha = '$fecha'
    ORDER BY a.Apellidos, a.Nombres
";

$res = mysqli_query($obj->conecta(), $sql) or die(mysqli_error($obj->conecta()));

// Encabezado del reporte
$curso_nombre = '';
if ($fila = mysqli_fetch_assoc($res)) {
    $curso_nombre = $fila['Nombre_Curso'];
    mysqli_data_seek($res, 0); // Volver al inicio del resultado
}

$html = '
    <h2 style="text-align:center;">Reporte de Asistencia</h2>
    <p><strong>Curso:</strong> ' . $curso_nombre . '</p>
    <p><strong>Fecha:</strong> ' . $fecha . '</p>
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr style="background-color: #eee;">
                <th>ID Alumno</th>
                <th>DNI</th>
                <th>Alumno</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>';

// Filas de asistencia
while ($fila = mysqli_fetch_assoc($res)) {
    $html .= '<tr>
        <td>' . $fila['AlumnoID'] . '</td>
        <td>' . $fila['DNI'] . '</td>
        <td>' . $fila['Alumno'] . '</td>
        <td>' . $fila['Estado'] . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("reporte_asistencias.pdf", array("Attachment" => true));
exit;