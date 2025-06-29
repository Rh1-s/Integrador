<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Matrícula</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Formulario de Matrícula - 2025</h2>
    <form action="../controllers/studentController.php" method="POST">
        <label>DNI o Código:</label>
        <input type="text" name="dni" required><br>

        <label>Apellidos y Nombres:</label>
        <input type="text" name="nombres_apellidos" required><br>

        <label>Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" required><br>

        <label>Sexo:</label>
        <select name="sexo" required>
            <option value="H">Hombre</option>
            <option value="M">Mujer</option>
        </select><br>

        <label>Nacionalidad:</label>
        <input type="text" name="nacionalidad"><br>

        <label>Situación de Matrícula:</label>
        <input type="text" name="situacion_matricula"><br>

        <label>Padre vive:</label>
        <input type="checkbox" name="vive_padre" value="1"><br>

        <label>Madre vive:</label>
        <input type="checkbox" name="vive_madre" value="1"><br>

        <label>Lengua Materna:</label>
        <input type="text" name="lengua_materna"><br>

        <label>Segunda Lengua:</label>
        <input type="text" name="segunda_lengua"><br>

        <label>¿Trabaja?:</label>
        <input type="checkbox" name="trabaja" value="1"><br>

        <label>Horas que trabaja:</label>
        <input type="number" name="horas_trabaja"><br>

        <label>Escolaridad de la madre:</label>
        <input type="text" name="escolaridad_madre"><br>

        <label>Nacimiento registrado:</label>
        <input type="checkbox" name="nacimiento_registrado" value="1"><br>

        <label>Tipo de discapacidad:</label>
        <input type="text" name="tipo_discapacidad"><br>

        <label>País:</label>
        <input type="text" name="pais"><br>

        <label>Fecha de Matrícula:</label>
        <input type="date" name="fecha_matricula"><br>

        <label>Grado y Sección:</label>
        <input type="text" name="grado_seccion"><br>

        <label>Escuela de procedencia:</label>
        <input type="text" name="escuela_procedencia"><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>
