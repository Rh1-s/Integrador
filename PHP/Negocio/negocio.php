<?php
include_once '../Conexion/conexion.php';

class Negocio
{

    function lisAlu(){
        $sql = "select AlumnoID, CONCAT(Nombres, ' ', Apellidos) as NombreCompleto from `alumnos`";
        $obj = new Conexion();
        $res = mysqli_query($obj->conecta(), $sql) or
            die(mysqli_error($obj->conecta()));
        $vec = array();
        while($fila = mysqli_fetch_array($res)){
            $vec[] = $fila;
        }
        return $vec;
    }

function lisAul(){
    $sql = "SELECT SeccionID, Nombre_Seccion, Cupo_Maximo FROM secciones";
    $obj = new Conexion();
    $res = mysqli_query($obj->conecta(), $sql) or
        die(mysqli_error($obj->conecta()));
    $vec = array();
    while($fila = mysqli_fetch_array($res)){
        $vec[] = $fila;
    }
    return $vec;
}

    function lisSec(){
        $sql = "select SeccionID, Nombre_Seccion from secciones";
        $obj = new Conexion();
        $res = mysqli_query($obj->conecta(), $sql) or
            die(mysqli_error($obj->conecta()));
        $vec = array();
        while($fila = mysqli_fetch_array($res)){
            $vec[] = $fila;
        }
        return $vec;
    }

    function lisMatri(){
        $sql = "select MatriculaID, a.nombres, s.nombre_seccion, Periodo_Inicio, Periodo_Fin, Estado FROM matriculas m JOIN alumnos a ON m.AlumnoID = a.AlumnoID JOIN secciones s ON m.SeccionID = s.SeccionID";
        $obj = new Conexion();
        $res = mysqli_query($obj->conecta(), $sql) or
            die(mysqli_error($obj->conecta()));
        $vec = array();
        while($fila = mysqli_fetch_array($res)){
            $vec[] = $fila;
        }
        return $vec;
    
    }

    function addMatri($AlumnoID,$SeccionID,$Periodo_Inicio,$Periodo_Fin,$Estado){
        $sql = "insert into `matriculas`(`AlumnoID`, `SeccionID`, `Periodo_Inicio`, `Periodo_Fin`, `Estado`) VALUES ($AlumnoID,$SeccionID,'$Periodo_Inicio','$Periodo_Fin','$Estado')";
        $obj = new Conexion();
        $conn = $obj->conecta();
        $res = mysqli_query($conn, $sql);

        return $res;
    }

    function deleteMatri($MatriculaID){
        $sql = "delete from matriculas where MatriculaID = $MatriculaID";
        $obj = new Conexion();
        $conn = $obj->conecta();
        $res = mysqli_query($conn, $sql);

        return $res;
    }

    function Login($Usuario, $Contra){
        $sql = "SELECT * FROM `login` WHERE Nombre_Usuario = '$Usuario' and Contrasena = '$Contra'";
        $obj = new Conexion();
        $conn = $obj->conecta();
        $res = mysqli_query($conn, $sql) or
            die(mysqli_error($conn));
        $vec = array();
        while($fila = mysqli_fetch_array($res)){
            $vec[] = $fila;
        }
        return $vec;
    }

    function LoginExitoso($Usuario, $Contra){
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
    function lisAluCompleto() {
    $sql = "SELECT * FROM alumnos";
    $obj = new Conexion();
    $res = mysqli_query($obj->conecta(), $sql) or die(mysqli_error($obj->conecta()));
    $vec = array();
    while($fila = mysqli_fetch_assoc($res)){
        $vec[] = $fila;
    }
    return $vec;
    }

    
    function addAlumno($DNI, $Nombres, $Apellidos, $Fec_Nacimiento, $Fec_Registro) {
        $sql = "INSERT INTO alumnos (DNI, Nombres, Apellidos, Fec_Nacimiento, Fec_Registro)
                VALUES ('$DNI', '$Nombres', '$Apellidos', '$Fec_Nacimiento', '$Fec_Registro')";
        $obj = new Conexion();
        $conn = $obj->conecta();
        return mysqli_query($conn, $sql);
    }

    function editarAlumno($id, $dni, $nombres, $apellidos, $nac, $reg) {
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

    function lisDocentes() {
    $sql = "SELECT DocenteID, DNI, Nombres, Apellidos, Direccion, Fec_Registro FROM Docentes";
    $obj = new Conexion();
    $res = mysqli_query($obj->conecta(), $sql) or die(mysqli_error($obj->conecta()));
    $vec = array();
    while($fila = mysqli_fetch_assoc($res)){
        $vec[] = $fila;
    }
    return $vec;
}
function addDocente($DNI, $Nombres, $Apellidos, $Direccion, $Fec_Registro) {
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

function addAula($Nombre_Seccion, $Cupo_Maximo) {
    $sql = "INSERT INTO Secciones (Nombre_Seccion, Cupo_Maximo)
            VALUES (?, ?)";
    $obj = new Conexion();
    $conn = $obj->conecta();

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Error al preparar consulta: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "sssss", $Nombre_Seccion, $Cupo_Maximo);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}


function editarDocente($id, $dni, $nombres, $apellidos, $direccion, $registro) {
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

}

?>
