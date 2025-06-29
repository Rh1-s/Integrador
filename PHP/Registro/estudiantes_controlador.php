<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO students (
        dni, nombres_apellidos, fecha_nacimiento, sexo, nacionalidad, situacion_matricula,
        vive_padre, vive_madre, lengua_materna, segunda_lengua, trabaja, horas_trabaja,
        escolaridad_madre, nacimiento_registrado, tipo_discapacidad, pais,
        fecha_matricula, grado_seccion, escuela_procedencia
    ) VALUES (
        :dni, :nombres_apellidos, :fecha_nacimiento, :sexo, :nacionalidad, :situacion_matricula,
        :vive_padre, :vive_madre, :lengua_materna, :segunda_lengua, :trabaja, :horas_trabaja,
        :escolaridad_madre, :nacimiento_registrado, :tipo_discapacidad, :pais,
        :fecha_matricula, :grado_seccion, :escuela_procedencia
    )");

    $stmt->execute([
        ':dni' => $_POST['dni'],
        ':nombres_apellidos' => $_POST['nombres_apellidos'],
        ':fecha_nacimiento' => $_POST['fecha_nacimiento'],
        ':sexo' => $_POST['sexo'],
        ':nacionalidad' => $_POST['nacionalidad'],
        ':situacion_matricula' => $_POST['situacion_matricula'],
        ':vive_padre' => isset($_POST['vive_padre']) ? 1 : 0,
        ':vive_madre' => isset($_POST['vive_madre']) ? 1 : 0,
        ':lengua_materna' => $_POST['lengua_materna'],
        ':segunda_lengua' => $_POST['segunda_lengua'],
        ':trabaja' => isset($_POST['trabaja']) ? 1 : 0,
        ':horas_trabaja' => $_POST['horas_trabaja'],
        ':escolaridad_madre' => $_POST['escolaridad_madre'],
        ':nacimiento_registrado' => isset($_POST['nacimiento_registrado']) ? 1 : 0,
        ':tipo_discapacidad' => $_POST['tipo_discapacidad'],
        ':pais' => $_POST['pais'],
        ':fecha_matricula' => $_POST['fecha_matricula'],
        ':grado_seccion' => $_POST['grado_seccion'],
        ':escuela_procedencia' => $_POST['escuela_procedencia'],
    ]);

    echo "Registro exitoso. <a href='../modules/student_form.php'>Volver</a>";
}
?>
