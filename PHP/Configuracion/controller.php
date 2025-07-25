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

//Registrar Usuario
if (isset($_POST["registrarUsuario"])) {
    $nombres = $_POST["username"];
    $contra = $_POST["password"];
    $tipo = $_POST["tipoUsuario"];
    
    $obj = new Negocio();
    $res = $obj->addUsuario($nombres, $contra, $tipo);

    if ($res) {
        header("Location: ../Login/config.php?success=1");
        exit();
    } else {
        header("Location: ../Login/config.php?error=1");
        exit();
    }
}


if (isset($_POST['guardarCurso'])) {
    $nombre      = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $docente_id  = (int)$_POST['docente_id'];
    $seccion_id  = (int)$_POST['aula_id'];
    $estado      = $_POST['estado'];
    $negocio = new Negocio();
    $ok = $negocio->addCurso($nombre, $descripcion, $docente_id, $seccion_id, $estado);
    if ($ok) {
        header("Location: ../Cursos/registro_curso.php?success=1");
    } else {
        header("Location: ../Cursos/registro_curso.php?error=1");
    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'deleteCurso' && isset($_GET['CursoID'])) {
    $negocio = new Negocio();
    $negocio->deleteCurso((int)$_GET['CursoID']);
    header("Location: ../Cursos/registro_curso.php?deleted=1");
    exit();
}

if (isset($_POST['editarCurso'])) {
    $negocio = new Negocio();
    $cursoId     = (int)$_POST['CursoID'];
    $nombre      = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $docente_id  = (int)$_POST['docente_id'];
    $seccion_id  = (int)$_POST['aula_id'];
    $estado      = $_POST['estado'];

    if ($negocio->updateCurso($cursoId, $nombre, $descripcion, $docente_id, $seccion_id, $estado)) {
        header("Location: ../Cursos/registro_curso.php?success_edit=1");
    } else {
        header("Location: ../Cursos/registro_curso.php?error_edit=1");
    }
    exit();
}

// Obtener lista de alumnos de un curso
if (isset($_GET['action']) && $_GET['action'] === 'getAsistencia') {
    $curso_id = (int)$_GET['curso_id'];
    $obj = new Negocio();
    $alumnos = $obj->getAlumnosByCurso($curso_id);
    $curso = $obj->getCursoById($curso_id);

    echo json_encode([
        'success' => true,
        'curso' => $curso['Nombre_Curso'],
        'alumnos' => $alumnos
    ]);
    exit;
}

// Guardar asistencia
if (isset($_POST['action']) && $_POST['action'] === 'saveAsistencia') {
    $curso_id = (int)$_POST['curso_id'];
    $fecha = date('Y-m-d'); // Puedes cambiar para usar un input específico

    include '../Negocio/negocio.php';
    $obj = new Negocio();

    // Iterar sobre los alumnos enviados
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'estado_') === 0) {
            $alumnoID = str_replace('estado_', '', $key);
            $estado = $value;
            $obj->saveAsistencia($alumnoID, $fecha, $estado);
        }
    }

    echo json_encode(['success' => true]);
    exit;
}

if (isset($_POST['asignarCurso'])) {
    $obj = new Negocio();

    $alumno_id = $_POST['alumno'];
    $seccion_id = $_POST['seccion'];
    $curso_id = $_POST['curso'];

    $res = $obj->asignarEstudianteCurso($alumno_id, $seccion_id, $curso_id);

    if ($res) {
        header("Location: ../Registro/asignar_estudiantes.php?success=1");
    } else {
        header("Location: ../Registro/asignar_estudiantes.php?error=1");
    }
}

if (isset($_POST['asignarMultiple'])) {
    $obj = new Negocio();

    $alumnos = $_POST['alumnos'] ?? [];
    $seccion = $_POST['seccion'];
    $curso = $_POST['curso'];

    foreach ($alumnos as $alumno) {
        $obj->asignarEstudianteCurso($alumno, $seccion, $curso);
    }
    header("Location: ../Registro/asignar_estudiantes.php?success=1");
}