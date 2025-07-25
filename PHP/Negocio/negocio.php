<?php
include_once '../Conexion/conexion.php';
class Negocio
{

    private function getConn()
    {
        $c = new Conexion();
        return $c->conecta();
    }

    private function fetchAll($stmt)
    {
        $res = $stmt->get_result();
        $data = [];
        while ($row = $res->fetch_assoc()) $data[] = $row;
        return $data;
    }
    function lisAlu()
    {
        $sql = "select AlumnoID, CONCAT(Nombres, ' ', Apellidos) as NombreCompleto from `alumnos`";
        $obj = new Conexion();
        $res = mysqli_query($obj->conecta(), $sql) or
            die(mysqli_error($obj->conecta()));
        $vec = array();
        while ($fila = mysqli_fetch_array($res)) {
            $vec[] = $fila;
        }
        return $vec;
    }

    function lisAul()
    {
        $sql = "SELECT SeccionID, Nombre_Seccion, Cupo_Maximo FROM secciones";
        $obj = new Conexion();
        $res = mysqli_query($obj->conecta(), $sql) or
            die(mysqli_error($obj->conecta()));
        $vec = array();
        while ($fila = mysqli_fetch_array($res)) {
            $vec[] = $fila;
        }
        return $vec;
    }

    function lisSec()
    {
        $sql = "select SeccionID, Nombre_Seccion from secciones";
        $obj = new Conexion();
        $res = mysqli_query($obj->conecta(), $sql) or
            die(mysqli_error($obj->conecta()));
        $vec = array();
        while ($fila = mysqli_fetch_array($res)) {
            $vec[] = $fila;
        }
        return $vec;
    }

    function lisMatri()
    {
        $sql = "select MatriculaID, a.nombres, s.nombre_seccion, Periodo_Inicio, Periodo_Fin, Estado FROM matriculas m JOIN alumnos a ON m.AlumnoID = a.AlumnoID JOIN secciones s ON m.SeccionID = s.SeccionID";
        $obj = new Conexion();
        $res = mysqli_query($obj->conecta(), $sql) or
            die(mysqli_error($obj->conecta()));
        $vec = array();
        while ($fila = mysqli_fetch_array($res)) {
            $vec[] = $fila;
        }
        return $vec;
    }

    function addMatri($AlumnoID, $SeccionID, $Periodo_Inicio, $Periodo_Fin, $Estado)
    {
        $sql = "insert into `matriculas`(`AlumnoID`, `SeccionID`, `Periodo_Inicio`, `Periodo_Fin`, `Estado`) VALUES ($AlumnoID,$SeccionID,'$Periodo_Inicio','$Periodo_Fin','$Estado')";
        $obj = new Conexion();
        $conn = $obj->conecta();
        $res = mysqli_query($conn, $sql);

        return $res;
    }

    function deleteMatri($MatriculaID)
    {
        $sql = "delete from matriculas where MatriculaID = $MatriculaID";
        $obj = new Conexion();
        $conn = $obj->conecta();
        $res = mysqli_query($conn, $sql);

        return $res;
    }

    function Login($Usuario, $Contra)
    {
        $sql = "SELECT * FROM `login` WHERE Nombre_Usuario = '$Usuario' and Contrasena = '$Contra'";
        $obj = new Conexion();
        $conn = $obj->conecta();
        $res = mysqli_query($conn, $sql) or
            die(mysqli_error($conn));
        $vec = array();
        while ($fila = mysqli_fetch_array($res)) {
            $vec[] = $fila;
        }
        return $vec;
    }

    function LoginExitoso($Usuario, $Contra)
    {
        $sql = "SELECT * FROM `login` WHERE Nombre_Usuario = '$Usuario' and Contrasena = '$Contra'";
        $obj = new Conexion();
        $conn = $obj->conecta();
        $res = mysqli_query($conn, $sql) or
            die(mysqli_error($conn));
        if (mysqli_num_rows($res) == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    // Funciones Registro de alumnos
    function lisAluCompleto()
    {
        $sql = "SELECT * FROM alumnos";
        $obj = new Conexion();
        $res = mysqli_query($obj->conecta(), $sql) or die(mysqli_error($obj->conecta()));
        $vec = array();
        while ($fila = mysqli_fetch_assoc($res)) {
            $vec[] = $fila;
        }
        return $vec;
    }


    function addAlumno($DNI, $Nombres, $Apellidos, $Fec_Nacimiento, $Fec_Registro)
    {
        $sql = "INSERT INTO alumnos (DNI, Nombres, Apellidos, Fec_Nacimiento, Fec_Registro)
                VALUES ('$DNI', '$Nombres', '$Apellidos', '$Fec_Nacimiento', '$Fec_Registro')";
        $obj = new Conexion();
        $conn = $obj->conecta();
        return mysqli_query($conn, $sql);
    }

    function editarAlumno($id, $dni, $nombres, $apellidos, $nac, $reg)
    {
        $sql = "UPDATE alumnos SET DNI=?, Nombres=?, Apellidos=?, Fec_Nacimiento=?, Fec_Registro=? WHERE AlumnoID=?";
        $obj = new Conexion();
        $conn = $obj->conecta();

        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die("Error al preparar consulta: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "sssssi", $dni, $nombres, $apellidos, $nac, $reg, $id);

        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    function lisDocentes()
    {
        $sql = "SELECT DocenteID, DNI, Nombres, Apellidos, Direccion, Fec_Registro FROM Docentes";
        $obj = new Conexion();
        $res = mysqli_query($obj->conecta(), $sql) or die(mysqli_error($obj->conecta()));
        $vec = array();
        while ($fila = mysqli_fetch_assoc($res)) {
            $vec[] = $fila;
        }
        return $vec;
    }
    function addDocente($DNI, $Nombres, $Apellidos, $Direccion, $Fec_Registro)
    {
        $sql = "INSERT INTO Docentes (DNI, Nombres, Apellidos, Direccion, Fec_Registro)
            VALUES (?, ?, ?, ?, ?)";
        $obj = new Conexion();
        $conn = $obj->conecta();

        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die("Error al preparar consulta: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "sssss", $DNI, $Nombres, $Apellidos, $Direccion, $Fec_Registro);

        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }




    function editarDocente($id, $dni, $nombres, $apellidos, $direccion, $registro)
    {
        $sql = "UPDATE Docentes SET DNI=?, Nombres=?, Apellidos=?, Direccion=?, Fec_Registro=? WHERE DocenteID=?";
        $obj = new Conexion();
        $conn = $obj->conecta();

        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die("Error al preparar consulta: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "sssssi", $dni, $nombres, $apellidos, $direccion, $registro, $id);

        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }


    function lisAula()
    {
        $sql = "SELECT s.SeccionID, CONCAT(c.Nombre_Categoria, ' - Sección ', s.Nombre_Seccion) AS Nombre_Aula 
                FROM Secciones s
                INNER JOIN Categoria c ON c.CategoriaID = s.CategoriaID";
        $conn = $this->getConn();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $this->fetchAll($stmt);
    }

    function addAula($Nombre_Seccion, $Cupo_Maximo)
    {
        $sql = "INSERT INTO Secciones (Nombre_Seccion, Cupo_Maximo) VALUES (?, ?)";
        $conn = $this->getConn();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $Nombre_Seccion, $Cupo_Maximo);
        return $stmt->execute();
    }

    /* ----------------- CURSOS ----------------- */
    // Nuevo: curso + docente + aula + estado
    function addCurso($nombre, $descripcion, $docente_id, $seccion_id, $estado)
    {
        $conn = $this->getConn();
        $conn->begin_transaction();

        try {
            // Curso
            $sql1 = "INSERT INTO cursos (Nombre_Curso, Descripcion) VALUES (?, ?)";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("ss", $nombre, $descripcion);
            $stmt1->execute();
            $curso_id = $conn->insert_id;

            // Curso-Docente
            $sql2 = "INSERT INTO curso_docente (CursoID, DocenteID) VALUES (?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("ii", $curso_id, $docente_id);
            $stmt2->execute();

            // Curso-Sección (nuevo)
            $sql3 = "INSERT INTO curso_seccion (CursoID, SeccionID, Estado) VALUES (?, ?, ?)";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param("iis", $curso_id, $seccion_id, $estado);
            $stmt3->execute();

            $conn->commit();
            return true;
        } catch (\Throwable $th) {
            $conn->rollback();
            return false;
        }
    }

    function lisCursos()
    {
        $sql = "SELECT 
                        c.CursoID,
                        c.Nombre_Curso,
                        c.Descripcion,
                        cd.DocenteID,
                        CONCAT(d.Nombres, ' ', d.Apellidos) AS Docente,
                        cs.SeccionID,
                        CONCAT(cat.Nombre_Categoria, ' - Sección ', s.Nombre_Seccion) AS Aula,
                        cs.Estado
                    FROM cursos c
                    LEFT JOIN curso_docente cd ON c.CursoID = cd.CursoID
                    LEFT JOIN docentes d ON cd.DocenteID = d.DocenteID
                    LEFT JOIN curso_seccion cs ON cs.CursoID = c.CursoID
                    LEFT JOIN secciones s ON cs.SeccionID = s.SeccionID
                    LEFT JOIN categoria cat ON cat.CategoriaID = s.CategoriaID";
        $conn = $this->getConn();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();
        $data = [];
        while ($row = $res->fetch_assoc()) $data[] = $row;
        return $data;
    }

    function deleteCurso($CursoID)
    {
        $sql = "DELETE FROM cursos WHERE CursoID = ?";
        $conn = $this->getConn();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $CursoID);
        return $stmt->execute();
    }

    function updateCurso($cursoId, $nombre, $descripcion, $docenteId, $seccionId, $estado)
    {
        $conn = $this->getConn();
        $conn->begin_transaction();
        try {
            // 1) Actualiza datos del curso
            $sql1 = "UPDATE cursos SET Nombre_Curso = ?, Descripcion = ? WHERE CursoID = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("ssi", $nombre, $descripcion, $cursoId);
            $stmt1->execute();

            // 2) Reemplaza relación curso-docente
            $conn->query("DELETE FROM curso_docente WHERE CursoID = " . (int)$cursoId);
            $sql2 = "INSERT INTO curso_docente (CursoID, DocenteID) VALUES (?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("ii", $cursoId, $docenteId);
            $stmt2->execute();

            // 3) Reemplaza relación curso-sección
            $conn->query("DELETE FROM curso_seccion WHERE CursoID = " . (int)$cursoId);
            $sql3 = "INSERT INTO curso_seccion (CursoID, SeccionID, Estado) VALUES (?, ?, ?)";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param("iis", $cursoId, $seccionId, $estado);
            $stmt3->execute();

            $conn->commit();
            return true;
        } catch (\Throwable $e) {
            $conn->rollback();
            return false;
        }
    }

    function getCursoById($curso_id)
    {
        $curso_id = (int)$curso_id;
        $sql = "SELECT 
                    c.CursoID,
                    c.Nombre_Curso,
                    c.Descripcion,
                    cs.Estado,
                    s.SeccionID,
                    s.Nombre_Seccion,
                    s.Cupo_Maximo,
                    cat.Nombre_Categoria
                FROM Cursos c
                JOIN Curso_Seccion cs   ON cs.CursoID   = c.CursoID
                JOIN Secciones s        ON s.SeccionID  = cs.SeccionID
                LEFT JOIN Categoria cat ON cat.CategoriaID = s.CategoriaID
                WHERE c.CursoID = ?";

        $obj = new Conexion();
        $cn  = $obj->conecta();
        $stmt = mysqli_prepare($cn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $curso_id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);

        return $data;
    }

    function getDocentesByCurso($curso_id)
    {
        $curso_id = (int)$curso_id;
        $sql = "SELECT d.DocenteID, d.Nombres, d.Apellidos
                FROM Curso_Docente cd
                INNER JOIN Docentes d ON d.DocenteID = cd.DocenteID
                WHERE cd.CursoID = ?";

        $obj = new Conexion();
        $cn  = $obj->conecta();
        $stmt = mysqli_prepare($cn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $curso_id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        $docentes = [];
        while ($fila = mysqli_fetch_assoc($res)) {
            $docentes[] = $fila;
        }
        mysqli_stmt_close($stmt);
        return $docentes;
    }

    function getDocenteById($docente_id)
    {
        $docente_id = (int)$docente_id;
        $sql = "SELECT DocenteID, DNI, Nombres, Apellidos, Direccion, Fec_Registro
            FROM Docentes
            WHERE DocenteID = ?";

        $obj = new Conexion();
        $cn = $obj->conecta();
        $stmt = mysqli_prepare($cn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $docente_id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);

        return $data;
    }

    function getCursosByDocente($docente_id)
    {
        $docente_id = (int)$docente_id;
        $sql = "SELECT 
                    c.CursoID, 
                    c.Nombre_Curso, 
                    c.Descripcion,
                    s.Nombre_Seccion,
                    cs.Estado
                FROM Curso_Docente cd
                INNER JOIN Cursos c ON cd.CursoID = c.CursoID
                INNER JOIN Curso_Seccion cs ON cs.CursoID = c.CursoID
                INNER JOIN Secciones s ON s.SeccionID = cs.SeccionID
                WHERE cd.DocenteID = ?";

        $obj = new Conexion();
        $cn = $obj->conecta();
        $stmt = mysqli_prepare($cn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $docente_id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        $cursos = [];
        while ($fila = mysqli_fetch_assoc($res)) {
            $cursos[] = $fila;
        }
        mysqli_stmt_close($stmt);
        return $cursos;
    }
    
    function addUsuario($nombre, $contra, $tipo)
    {
        $sql = "INSERT INTO login (Nombre_Usuario, Contrasena, Tipo) VALUES ('$nombre', '$contra', '$tipo')";
        $obj = new Conexion();
        $conn = $obj->conecta();
        $res = mysqli_query($conn, $sql);

        return $res;
    }
}
