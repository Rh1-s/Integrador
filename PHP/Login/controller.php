<?php
require '../Negocio/negocio.php';

// Capturamos la acción
$action = $_REQUEST['action'];

// Logueo
if ($action === 'login') {

    $user = $_POST['username'];
    $contrasena = $_POST['password'];
    $rol = $_POST['rol']; // ← recibes el rol por POST

    $obj = new Negocio();
    $data = $obj->Login($user, $contrasena);
    $login = $obj->LoginExitoso($user, $contrasena);

    if ($login == 1) {
        session_start();
        $_SESSION["IDUSUARIO"][0] = $data[0];

        // Redirigir según el rol
        if ($rol === 'administrador') {
            header("Location: ../Matricula/registro.php");
        } elseif ($rol === 'director') {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Rol no desarrollado',
                    text: 'El rol proporcionado no es válido'
                }).then(() => {
                    window.location.href = '../../index.php';
                });
            </script>";
            exit;
            //header("Location: ../Director/inicio.php");
        } else {
            // Rol desconocido
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Rol inválido',
                    text: 'El rol proporcionado no es válido'
                }).then(() => {
                    window.location.href = '../../index.php';
                });
            </script>";
            exit;
        }

    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Usuario no encontrado'
            }).then(() => {
                window.location.href = '../../index.php';
            });
        </script>";
        exit;
    }
}
?>
