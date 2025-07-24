<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #fce4ec);
            font-family: 'Segoe UI', sans-serif;
        }
        .form-card {
            background: #fff;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 40px;
            max-width: 850px;
            margin: 60px auto;
            position: relative;
        }
        .form-card h3 {
            margin-bottom: 40px;
            font-weight: bold;
            color: #2c3e50;
        }
        .form-label {
            font-weight: 800;
            color: #333;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .top-banner {
            background: linear-gradient(to right, #42a5f5, #ab47bc);
            padding: 20px;
            color: white;
            text-align: center;
            border-radius: 30px 15px 0 0;
            margin: -40px -40px 30px -40px;
        }
        .emoji {
            font-size: 30px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="form-card">
    <div class="top-banner">
        <span class="emoji">👨‍🎓</span> <strong>Editar Datos del Alumno</strong>
    </div>

    <?php
    $conn = new mysqli("localhost", "root", "", "Institucion");
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $result = $conn->query("SELECT * FROM Alumnos WHERE AlumnoID = $id");
        $alumno = $result->fetch_assoc();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $dni = $_POST['dni'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $nacimiento = $_POST['nacimiento'];
        $registro = $_POST['registro'];

        $stmt = $conn->prepare("UPDATE Alumnos SET DNI=?, Nombres=?, Apellidos=?, Fec_Nacimiento=?, Fec_Registro=? WHERE AlumnoID=?");
        $stmt->bind_param("sssssi", $dni, $nombres, $apellidos, $nacimiento, $registro, $id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success text-center mt-3'>✅ Alumno actualizado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>❌ Ocurrió un error al actualizar.</div>";
        }
        $stmt->close();
    }
    ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $alumno['AlumnoID'] ?>">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control" value="<?= $alumno['DNI'] ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha de Nacimiento</label>
                <input type="date" name="nacimiento" class="form-control" value="<?= $alumno['Fec_Nacimiento'] ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nombres</label>
                <input type="text" name="nombres" class="form-control" value="<?= $alumno['Nombres'] ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" value="<?= $alumno['Apellidos'] ?>" required>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Fecha de Registro</label>
            <input type="date" name="registro" class="form-control" value="<?= $alumno['Fec_Registro'] ?>" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success me-2">💾 Guardar Cambios</button>
            <a href="alumnos.php" class="btn btn-outline-secondary">↩ Volver</a>
        </div>
    </form>
</div>

</body>
</html>
