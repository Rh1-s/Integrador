<?php
require 'library/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include '../Conexion/conexion.php';

// Conectar y ejecutar consulta
$obj = new Conexion();
$sql = "SELECT 
            c.CursoID,
            c.Nombre_Curso,
            CONCAT(d.Nombres, ' ', d.Apellidos) AS Docente,
            s.Nombre_Seccion AS Aula,
            cs.Estado
        FROM Cursos c
        INNER JOIN Curso_Seccion cs ON cs.CursoID = c.CursoID
        INNER JOIN Secciones s ON s.SeccionID = cs.SeccionID
        LEFT JOIN Curso_Docente cd ON cd.CursoID = c.CursoID
        LEFT JOIN Docentes d ON d.DocenteID = cd.DocenteID
        ORDER BY c.Nombre_Curso";
$res = mysqli_query($obj->conecta(), $sql) or die(mysqli_error($obj->conecta()));

// Construir HTML
$html = '
    <h2 style="text-align: center;">Reporte de Cursos</h2>
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr style="background-color: #eee;">
                <th>ID</th>
                <th>Curso</th>
                <th>Docente</th>
                <th>Aula</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>';

while ($fila = mysqli_fetch_array($res)) {
    $html .= '<tr>
                <td>' . $fila['CursoID'] . '</td>
                <td>' . htmlspecialchars($fila['Nombre_Curso']) . '</td>
                <td>' . htmlspecialchars($fila['Docente'] ?? 'No Asignado') . '</td>
                <td>' . htmlspecialchars($fila['Aula']) . '</td>
                <td>' . htmlspecialchars($fila['Estado']) . '</td>
            </tr>';
}

$html .= '</tbody></table>';

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("reporte_cursos.pdf", array("Attachment" => true));
exit;