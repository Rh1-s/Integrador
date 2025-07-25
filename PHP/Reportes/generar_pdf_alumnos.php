<?php
require 'library/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include '../Conexion/conexion.php';

$obj = new Conexion();
$cn = $obj->conecta();

// Consulta de todos los alumnos registrados
$sql = "
    SELECT 
        a.AlumnoID,
        a.DNI,
        CONCAT(a.Nombres, ' ', a.Apellidos) AS Alumno,
        a.Fec_Nacimiento,
        a.Fec_Registro
    FROM Alumnos a
    ORDER BY a.Apellidos, a.Nombres
";
$res = mysqli_query($cn, $sql) or die(mysqli_error($cn));

$html = '
    <h2 style="text-align:center;">Listado General de Alumnos</h2>
    <p><strong>Total de Alumnos:</strong> ' . mysqli_num_rows($res) . '</p>
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr style="background-color: #eee;">
                <th>ID Alumno</th>
                <th>DNI</th>
                <th>Nombre Completo</th>
                <th>Fecha Nac.</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>';

if (mysqli_num_rows($res) == 0) {
    $html .= '<tr><td colspan="5" style="text-align:center;">No hay alumnos registrados.</td></tr>';
} else {
    while ($fila = mysqli_fetch_assoc($res)) {
        $html .= '<tr>
            <td>' . htmlspecialchars($fila['AlumnoID']) . '</td>
            <td>' . htmlspecialchars($fila['DNI']) . '</td>
            <td>' . htmlspecialchars($fila['Alumno']) . '</td>
            <td>' . htmlspecialchars($fila['Fec_Nacimiento'] ?? '-') . '</td>
            <td>' . htmlspecialchars($fila['Fec_Registro']) . '</td>
        </tr>';
    }
}

$html .= '</tbody></table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("alumnos_registrados.pdf", array("Attachment" => true));
exit;