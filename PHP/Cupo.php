<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Cupos por Aula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f2f2f2;
            padding: 30px;
        }
        .header {
            background-color: #dc3545;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 30px;
        }
        .card {
            box-shadow: 10px 10px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="header">
    <h3>Administrador - Consulta de Cupos por Aula</h3>
</div>

<div class="container">
    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-6 offset-md-3">
            <label class="form-label">Seleccione un aula</label>
            <select name="aula" class="form-select" required>
                <option value="">-- Aula --</option>
                <?php
                $conn = new mysqli("localhost", "root", "", "COLEGIO");
                $aulas = $conn->query("SELECT Nombre_Seccion FROM Secciones");
                while ($s = $aulas->fetch_assoc()) {
                    echo "<option value='{$s['Nombre_Seccion']}'>{$s['Nombre_Seccion']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Buscar Aula</button>
        </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $aula = $_POST['aula'];
        $sql = "
            SELECT 
                s.Nombre_Seccion,
                s.Cupo_Maximo,
                COUNT(m.MatriculaID) AS Matriculados,
                (s.Cupo_Maximo - COUNT(m.MatriculaID)) AS Cupos_Disponibles
            FROM Secciones s
            LEFT JOIN Matriculas m ON s.SeccionID = m.SeccionID
            WHERE s.Nombre_Seccion = ?
            GROUP BY s.SeccionID, s.Nombre_Seccion, s.Cupo_Maximo
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $aula);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $ocupado = $row['Matriculados'];
            $max = $row['Cupo_Maximo'];
            $disponibles = $row['Cupos_Disponibles'];
            $porcentaje = round(($ocupado / $max) * 100);

            echo "
            <div class='card mx-auto p-4 mb-4' style='max-width: 700px;'>
                <h4 class='mb-3 text-center'>📋 Reporte de Aula: <strong>{$row['Nombre_Seccion']}</strong></h4>
                <p><strong>Cupo máximo:</strong> {$max}</p>
                <p><strong>Matriculados:</strong> {$ocupado}</p>
                <p><strong>Cupos disponibles:</strong> {$disponibles}</p>
                <label class='form-label'>Ocupación del aula:</label>
                <div class='progress'>
                    <div class='progress-bar bg-success' style='width: {$porcentaje}%;'>
                        {$porcentaje}%
                    </div>
                </div>
                <div class='text-center mt-4'>
                    <a href='Cupo2.php' class='btn btn-outline-secondary'>Volver a consultar</a>
                </div>
            </div>";
        } else {
            echo "<div class='alert alert-warning text-center'>No se encontró información para el aula <strong>$aula</strong>.</div>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</div>

</body>
</html>
