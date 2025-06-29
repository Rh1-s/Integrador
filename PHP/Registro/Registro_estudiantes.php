<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Alumnos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap, Iconos, Estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/Reportes/reportes.css">
    <link rel="icon" href="../../src/images/logo.ico">

    <!-- jQuery + SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php session_start(); ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../../src/images/logo.jpg" alt="Logo SnowBox" class="logo-img">
            </a>
            <span class="navbar-text text-white">Administrador</span>
            <a href="../../index.html" class="text-white"><i class="bi bi-box-arrow-left"></i></a>
        </div>
    </nav>

    <!-- Layout -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-2 custom-sidebar">
                <div class="nav flex-column">
                    <a href="../Inventario/dash.php?user=1" class="nav-link active"><i class="bi bi-box-seam"></i> Estudiantes</a>
                    <a href="../Matricula/registro.php" class="nav-link"><i class="bi bi-truck"></i> Matrícula</a>
                    <a href="../Proveedores/dash.php?user=1" class="nav-link"><i class="bi bi-globe"></i> Aulas</a>
                    <a href="../Reportes/dash.php?user=1" class="nav-link"><i class="bi bi-clipboard-data"></i> Reportes</a>
                    <a href="../Configuracion/dash.php?user=1" class="nav-link"><i class="bi bi-gear"></i> Configuración</a>
                </div>
            </div>

            <!-- Main -->
            <div class="col-10 mt-3">
                <h4>Registro de Alumno</h4>
                <form action="../Configuracion/controller.php" method="POST" class="row g-3">
                    <div class="card">
                        <div class="card-body row g-3">
                            <div class="col-md-6">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" name="dni" id="dni" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="nombres" class="form-label">Nombres</label>
                                <input type="text" name="nombres" id="nombres" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                                <input type="date" name="fecha_registro" id="fecha_registro" class="form-control" required>
                            </div>

                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" name="guardarAlumno" class="btn btn-primary w-100">Registrar Alumno</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Tabla de Alumnos -->
                <form action="../Reportes/generar_pdf_alumnos.php" method="POST">
                    <div class="row mt-4">
                        <div class="col" data-simplebar style="max-height: 420px;">
                            <table class="table table-hover" id="alumno-table">
                                <thead>
                                    <tr>
                                        <th scope="col">DNI</th>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">F. Nacimiento</th>
                                        <th scope="col">F. Registro</th>
                                        <th scope="col">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include '../Negocio/negocio.php';
                                    $obj = new Negocio();
                                    $alumnos = $obj->lisAluCompleto(); // NUEVA FUNCIÓN
                                    foreach ($alumnos as $alu) {
                                    ?>
                                        <tr>
                                            <td><?= $alu['DNI'] ?></td>
                                            <td><?= $alu['Nombres'] . ' ' . $alu['Apellidos'] ?></td>
                                            <td><?= $alu['Fec_Nacimiento'] ?></td>
                                            <td><?= $alu['Fec_Registro'] ?></td>
                                            <td>
                                                <a href="../Configuracion/controller.php?action=delete&AlumnoID=<?= $alu['AlumnoID'] ?>">
                                                    <img style="width: 25px; height: 25px;" src="../../src/images/Eliminar.png" alt="Eliminar" class="logo-img">
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                                    
                    </div>
                    <div class="row mt-5">
                        <div class="d-flex justify-content-center">
                            <td><button id="generarReporte" name="generarReporte" class="btn btn-success w-25">Generar reporte</button></td>
                        </div>
                    </div>
                </form>
                   
            </div>
        </div>
    </div>
</body>

</html>
