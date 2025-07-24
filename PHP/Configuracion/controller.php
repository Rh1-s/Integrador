<?php
include '../Negocio/negocio.php';

// Registrar Matrícula
if (isset($_POST["guardarMatricula"])) {
    $obj = new Negocio();
    $matricula = $obj->addMatri(
        $_POST["alumnoID"],
        $_POST["seccionID"],
        $_POST["periodoInicio"],
        $_POST["periodoFin"],
        $_POST["estado"]
    );

    if ($matricula) {
        header("location: ../Matricula/registro.php");
        exit();
    }
}

// Eliminar Matrícula
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['MatriculaID'])) {
    $MatriculaID = $_GET['MatriculaID'];
    $negocio = new Negocio();
    $resultado = $negocio->deleteMatri($MatriculaID);

    if ($resultado) {
        header("location: ../Matricula/registro.php");
        exit();
    }
}

// Registrar Alumno
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
        exit();
    } else {
        echo "<script>alert('Error al registrar alumno');</script>";
    }
}

// Editar Alumno
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

// Editar Docente
if (isset($_POST['editarDocente'])) {
    $id = $_POST['DocenteID'];
    $dni = $_POST['dni'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $reg = $_POST['fecha_registro'];

    $obj = new Negocio();
    $res = $obj->editarDocente($id, $dni, $nombres, $apellidos, $direccion, $reg);

    if ($res) {
        echo "<script>alert('Los datos del docente han sido editados'); window.location.href = '../Registro/Docentes.php';</script>";
    } else {
        echo "<script>alert('Error al editar docente');</script>";
    }
}

// Eliminar Alumno
if (isset($_GET["action"]) && $_GET["action"] === "delete" && isset($_GET["AlumnoID"])) {
    $id = $_GET["AlumnoID"];
    $sql = "DELETE FROM Alumnos WHERE AlumnoID = $id";
    $obj = new Conexion();
    $conn = $obj->conecta();
    $res = mysqli_query($conn, $sql);

    if ($res) {
        header("Location: ../Registro/Registro_estudiantes.php");
        exit();
    } else {
        echo "<script>alert('Error al eliminar Alumno');</script>";
    }
}

// Eliminar Docente
if (isset($_GET["action"]) && $_GET["action"] === "delete" && isset($_GET["DocenteID"])) {
    $id = $_GET["DocenteID"];
    $sql = "DELETE FROM Docentes WHERE DocenteID = $id";
    $obj = new Conexion();
    $conn = $obj->conecta();
    $res = mysqli_query($conn, $sql);

    if ($res) {
        header("Location: ../Registro/Docentes.php");
        exit();
    } else {
        echo "<script>alert('Error al eliminar docente');</script>";
    }
}




// Registrar Docente
if (isset($_POST["addDocente"])) {
    $dni = $_POST["DNI"];
    $nombres = $_POST["Nombres"];
    $apellidos = $_POST["Apellidos"];
    $direccion = $_POST["Direccion"];
    $fecha_reg = $_POST["Fec_Registro"];

    $obj = new Negocio();
    $res = $obj->addDocente($dni, $nombres, $apellidos, $direccion, $fecha_reg);

    if ($res) {
        header("Location: ../Registro/Docentes.php?success=1");
        exit();
    } else {
        header("Location: ../Registro/Docentes.php?error=1");
        exit();
    }
}