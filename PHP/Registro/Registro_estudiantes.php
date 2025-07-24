<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Alumnos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jQuery + SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap, Iconos, Estilos -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/Reportes/reportes.css">
    <link rel="icon" href="../../src/images/logo.ico">

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
            <a href="../../index.php" class="text-white"><i class="bi bi-box-arrow-left"></i></a>
        </div>
    </nav>

    <!-- Layout -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-2 custom-sidebar">
                <div class="nav flex-column">
                    <a href="../Registro/Registro_estudiantes.php?user=1" class="nav-link active"><i class="bi bi-box-seam"></i> Estudiantes</a>
                    <a href="../Matricula/registro.php" class="nav-link"><i class="bi bi-truck"></i> Matrícula</a>
                    <a href="../Aula.php" class="nav-link"><i class="bi bi-globe"></i> Aulas</a>
                    <a href="../Cupo.php" class="nav-link"><i class="bi bi-clipboard-data"></i> Reportes</a>
                    <a href="../Registro/Docentes.php" class="nav-link"><i class="bi bi-gear"></i> Docentes</a>
                    <a href="../Cursos/registro_curso.php" class="nav-link"><i class="bi bi-journal-bookmark-fill"></i> Cursos</a>
                    <a href="../Cursos/ver_curso.php" class="nav-link"><i class="bi bi-journal-bookmark-fill"></i> Ver Cursos </a>
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
                <div class="d-flex justify-content-end mb-2">
                    <form action="../Reportes/generar_pdf_alumnos.php" method="POST">
                        <button id="generarReporte" name="generarReporte" class="btn btn-success">
                            <i class="bi bi-file-earmark-pdf"></i> Generar Reporte
                        </button>
                    </form>
                </div>
                <!-- Tabla de Alumnos -->
                <form action="../Reportes/generar_pdf_alumnos.php" method="POST">
                    <div class="row mt-4">
                        <div class="col" data-simplebar style="max-height: 420px;">
                            <table id="alumnos-table" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">DNI</th>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">F. Nacimiento</th>
                                        <th scope="col">F. Registro</th>
                                        <th scope="col">Acciones</th>
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
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-outline-primary me-2 btn-editar"
                                                    data-id="<?= $alu['AlumnoID'] ?>"
                                                    data-dni="<?= $alu['DNI'] ?>"
                                                    data-nombres="<?= $alu['Nombres'] ?>"
                                                    data-apellidos="<?= $alu['Apellidos'] ?>"
                                                    data-nacimiento="<?= $alu['Fec_Nacimiento'] ?>"
                                                    data-registro="<?= $alu['Fec_Registro'] ?>"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditarAlumno"
                                                >
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <a href="../Configuracion/controller.php?action=delete&AlumnoID=<?= $alu['AlumnoID'] ?>" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
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
                </form>
                   
            </div>
        </div>
    </div>

    <!-- Modal Editar Alumno -->
    <div class="modal fade" id="modalEditarAlumno" tabindex="-1" aria-labelledby="modalEditarAlumnoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="../Configuracion/controller.php" method="POST">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Editar Alumno</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
            <input type="hidden" name="AlumnoID" id="editAlumnoID">

            <div class="mb-3">
                <label for="editDNI" class="form-label">DNI</label>
                <input type="text" name="dni" id="editDNI" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="editNombres" class="form-label">Nombres</label>
                <input type="text" name="nombres" id="editNombres" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="editApellidos" class="form-label">Apellidos</label>
                <input type="text" name="apellidos" id="editApellidos" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="editNacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="editNacimiento" class="form-control">
            </div>

            <div class="mb-3">
                <label for="editRegistro" class="form-label">Fecha de Registro</label>
                <input type="date" name="fecha_registro" id="editRegistro" class="form-control" required>
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" name="editarAlumno" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
        </form>
    </div>
    </div>
<script>
$(document).ready(function() {
    $('#alumnos-table').DataTable({
        language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros por página",
            info: "Mostrando _START_ a _END_ de _TOTAL_ alumnos",
            paginate: {
                previous: "Anterior",
                next: "Siguiente"
            },
            zeroRecords: "No se encontraron resultados",
            infoEmpty: "Mostrando 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros totales)"
        }
    });
});
$(document).ready(function() {
    $('.btn-editar').on('click', function() {
        const button = $(this);
        $('#editAlumnoID').val(button.data('id'));
        $('#editDNI').val(button.data('dni'));
        $('#editNombres').val(button.data('nombres'));
        $('#editApellidos').val(button.data('apellidos'));
        $('#editNacimiento').val(button.data('nacimiento'));
        $('#editRegistro').val(button.data('registro'));
    });
});
</script>
</body>

</html>
