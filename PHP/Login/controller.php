<?php
require '../Negocio/negocio.php';

//Capturamos la acción
$action = $_REQUEST['action'];

//Logueo
if ($action === 'login') {
    $user = $_POST['username'];
    $contrasena = $_POST['password'];
    $obj = new Negocio();
    $data = $obj->Login($user, $contrasena);
    $login = $obj->LoginExitoso($user, $contrasena);


    if ($login == 1) {
        session_start();
        $_SESSION["IDUSUARIO"][0] = $data[0];
        header("Location: ../Matricula/registro.php");
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Usuario no encontrado'
            }).then(() => {
                window.location.href = '../../index.html';
            });
        </script>";
        exit;
    }
}





/*
    echo "<h1></h1>";

    $pass = hash('sha256', $contrasenia);

    $sqlLogin = "SELECT id,dni,contrasenia from Usuario WHERE dni='$dni' AND contrasenia='$pass'";
    $consulta = mysqli_query($conn, $sqlLogin);

    $array = mysqli_fetch_array($consulta);

    if ($consulta && mysqli_num_rows($consulta) > 0) {
        if ($array['id'] == 1) {
            header("Location: ../Inventario/dash.php?user=1");
        } else {
            header("Location: ../Inventario/dash.php?user=" . $array['id']);
        }
        exit;
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Usuario no encontrado'
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.href = '../../index.html';
                        }
                    });
        </script>";
        exit;
    }
}*/
?>
