<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f1f8e9, #e3f2fd);
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            background: #ffffff;
            padding: 40px;
            margin-top: 50px;
            border-radius: 40px;
            box-shadow: 20px 30px 35px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 30px;
        }

        table {
            border-radius: 35px;
            font-size: 18px;
            overflow: hidden;
        }

        thead {
            background: #42a5f5;
            color: goldenrod;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-warning {
            font-weight: 700;
            background-color: #ffca28;
            border: salmon;
        }

        .btn-warning:hover {
            background-color: #fdd835;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="text-center">📚 Lista de Alumnos Registrados</h3>
    <table class="table table-bordered table-hover align-middle text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>DNI</th>
                <th>F. Nacimiento</th>
                <th>F. Registro</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = new mysqli("localhost", "root", "", "COLEGIO");
            $result = $conn->query("SELECT * FROM Alumnos");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['AlumnoID']}</td>
                        <td>{$row['Nombres']} {$row['Apellidos']}</td>
                        <td>{$row['DNI']}</td>
                        <td>{$row['Fec_Nacimiento']}</td>
                        <td>{$row['Fec_Registro']}</td>
                        <td>
                            <a href='editar_alumno.php?id={$row['AlumnoID']}' class='btn btn-warning btn-sm'>✏️ Editar</a>
                        </td>
                      </tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
