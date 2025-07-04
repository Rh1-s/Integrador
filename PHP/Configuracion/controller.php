<?php
include '../Negocio/negocio.php';

//Registrar Matricula
if (isset($_POST["guardarMatricula"])) {
    $obj = new Negocio();
    $matricula = $obj->addMatri($_POST["alumnoID"], $_POST["seccionID"], $_POST["periodoInicio"], $_POST["periodoFin"], $_POST["estado"]);
    if (!$matricula) {
    } else {
        header("location: ../Matricula/registro.php");
    }
}

//Boton Eliminar
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['MatriculaID'])) {
    $MatriculaID = $_GET['MatriculaID'];
    $negocio = new Negocio();
    $resultado = $negocio->deleteMatri($MatriculaID);

    if (!$resultado) {
    } else {
        header("location: ../Matricula/registro.php");
    }
}

// Registrar alumno
if (isset($_POST["guardarAlumno"])) {
    $dni = $_POST["dni"];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $fecha_nac = $_POST["fecha_nacimiento"];
    $fecha_reg = $_POST["fecha_registro"];

    $obj = new Negocio();
    $res = $obj->addAlumno($dni, $nombres, $apellidos, $fecha_nac, $fecha_reg);

    if ($res) {
        header("Location: ../Registro/Registro_estudiantes.php");
    } else {
        echo "<script>alert('Error al registrar alumno');</script>";
    }
}

if (isset($_POST['editarAlumno'])) {
    $id = $_POST['AlumnoID'];
    $dni = $_POST['dni'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $nac = $_POST['fecha_nacimiento'];
    $reg = $_POST['fecha_registro'];

    $obj = new Negocio();
    $res = $obj->editarAlumno($id, $dni, $nombres, $apellidos, $nac, $reg);

    if ($res) {
        echo "<script>alert('Los datos del alumno han sido editados'); window.location.href = '../Registro/Registro_estudiantes.php';</script>";
    } else {
        echo "<script>alert('Error al editar alumno');</script>";
    }
}
//Boton Editar
/*
if (isset($_POST["botoneditar"])) {
    $objeto = new Negocio();
    $id_alumno = $_POST["id_alumno"];
    $dni = $_POST["dni"];
    $nombre = $_POST["nombres"];
    $apellido = $_POST["apellidos"];
    $aula = $_POST["id_aula"];
    $lenguaje = $_POST["lenguaje"];
    $mate = $_POST["matematica"];
    $edad = $_POST["edad"];

    $edit = $objeto->editMatri($id_alumno, $dni, $nombre, $apellido, $aula, $lenguaje, $mate, $edad);
    if (!$edit) {
    } else {
        header("location: ../dashboard.php");
    }
}*/
?>