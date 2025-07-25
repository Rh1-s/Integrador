<!DOCTYPE html>
<html lang="es">
<?php
if (isset($_GET['success'])) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: '¡Registro exitoso!',
            text: 'El usuario fue registrado correctamente.'
        });
    </script>";
}

if (isset($_GET['error'])) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo registrar el usuario.'
        });
    </script>";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes SnowBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/Reportes/reportes.css">
    <link rel="icon" href="../../src/images/logo.ico">

    <link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css" />
    <script src="https://unpkg.com/simplebar@latest/dist/simplebar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- select search -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- fecha -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="../../JS/Reportes/reportes.js"></script>

</head>

<body>
    <?php
    include '../Negocio/negocio.php';
    session_start();
    $obj = new Negocio();
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../../src/images/logo.png" alt="Logo SnowBox" class="logo-img">
            </a>
            <span class="navbar-text text-white">
                Administrador
            </span>
            <a href="../../index.php" class="text-white"><i class="bi bi-box-arrow-left"></i></a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-2 custom-sidebar">
                <div class="nav flex-column">

                    <a href="../Registro/Registro_estudiantes.php?user=1" class="nav-link "><i class="bi bi-box-seam"></i> Estudiantes</a>
                    <a href="../Matricula/registro.php" class="nav-link "><i class="bi bi-truck"></i> Matrícula</a>
                    <a href="../Aula.php" class="nav-link"><i class="bi bi-globe"></i> Aulas</a>
                    <a href="../Cupo.php" class="nav-link"><i class="bi bi-clipboard-data"></i> Reportes</a>
                    <a href="../Registro/Docentes.php" class="nav-link"><i class="bi bi-person"></i> Docentes</a>
                    <a href="../Cursos/registro_curso.php" class="nav-link"><i class="bi bi-journal-bookmark-fill"></i> Cursos</a>
                    <a href="../Cursos/ver_curso.php" class="nav-link"><i class="bi bi-journal-bookmark-fill"></i> Ver Cursos </a>
                    <a href="../Login/config.php" class="nav-link active"><i class="bi bi-gear"></i> Administrar usuarios </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-10 mt-3">
                <h4>Registro de Usuarios</h4>
                <!-- Formulario de Registro de Usuario -->
                <form action="../Configuracion/controller.php" method="POST">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body row g-3">
                                    <!-- Nombre de Usuario -->
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Nombre de usuario</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>

                                    <!-- Contraseña -->
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>

                                    <!-- Tipo de Usuario -->
                                    <div class="col-md-6">
                                        <label for="tipoUsuario" class="form-label">Tipo de Usuario</label>
                                        <select class="form-select" id="tipoUsuario" name="tipoUsuario" required>
                                            <option selected disabled>Seleccione tipo</option>
                                            <option value="Administrador">Administrador</option>
                                            <option value="Docente">Docente</option>
                                        </select>
                                    </div>

                                    <!-- Botón Registrar Usuario -->
                                    <div class="col-md-6 d-flex align-items-end">
                                        <button id="registrarUsuario" name="registrarUsuario" class="btn btn-primary w-100">Registrar Usuario</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>