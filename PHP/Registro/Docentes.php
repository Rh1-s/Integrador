<?php session_start(); ?>
<?php
if (isset($_GET['success'])) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: '¡Registro exitoso!',
            text: 'El docente fue registrado correctamente.'
        });
    </script>";
}

if (isset($_GET['error'])) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo registrar el docente.'
        });
    </script>";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Docentes</title>
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light custom-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../../src/images/logo.png" alt="Logo SnowBox" class="logo-img">
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
                <a href="../Registro/Registro_estudiantes.php?user=1" class="nav-link"><i class="bi bi-box-seam"></i> Estudiantes</a>
                <a href="../Matricula/registro.php" class="nav-link"><i class="bi bi-truck"></i> Matrícula</a>
                <a href="../Aula.php" class="nav-link"><i class="bi bi-globe"></i> Aulas</a>
                <a href="../Cupo.php?user=1" class="nav-link"><i class="bi bi-clipboard-data"></i> Reportes</a>
                <a href="../Registro/Docentes.php" class="nav-link active"><i class="bi bi-person"></i> Docentes</a>
                <a href="../Cursos/registro_curso.php" class="nav-link"><i class="bi bi-journal-bookmark-fill"></i> Cursos</a>
                <a href="../Cursos/ver_curso.php" class="nav-link"><i class="bi bi-journal-bookmark-fill"></i> Ver Cursos </a>
            </div>
        </div>

        <!-- Main -->
        <div class="col-10 mt-3">
            <h4>Registro de Docente</h4>
            <form action="../Configuracion/controller.php" method="POST" class="row g-3">
                <div class="card">
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label for="DNI" class="form-label">DNI</label>
                            <input type="text" name="DNI" id="DNI" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Nombres" class="form-label">Nombres</label>
                            <input type="text" name="Nombres" id="Nombres" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Apellidos" class="form-label">Apellidos</label>
                            <input type="text" name="Apellidos" id="Apellidos" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Direccion" class="form-label">Dirección</label>
                            <input type="text" name="Direccion" id="Direccion" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Fec_Registro" class="form-label">Fecha de Registro</label>
                            <input type="date" name="Fec_Registro" id="Fec_Registro" class="form-control" required>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" name="addDocente" class="btn btn-primary w-100">Registrar Docente</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Tabla -->
            <div class="row mt-4">
                <div class="col" data-simplebar style="max-height: 420px;">
                    <table id="docentes-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>DNI</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Dirección</th>
                                <th>Fecha de Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../Negocio/negocio.php';
                            $obj = new Negocio();
                            $docentes = $obj->lisDocentes();
                            foreach ($docentes as $d) {
                            ?>
                                <tr>
                                    <td><?= $d['DNI'] ?></td>
                                    <td><?= $d['Nombres']?></td>
                                    <td><?= $d['Apellidos'] ?></td>
                                    <td><?= $d['Direccion'] ?></td>
                                    <td><?= $d['Fec_Registro'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary me-2 btn-editar"
                                            data-id="<?= $d['DocenteID'] ?>"
                                            data-dni="<?= $d['DNI'] ?>"
                                            data-nombres="<?= $d['Nombres'] ?>"
                                            data-apellidos="<?= $d['Apellidos'] ?>"
                                            data-direccion="<?= $d['Direccion'] ?>"
                                            data-fecha="<?= $d['Fec_Registro'] ?>"
                                            data-bs-toggle="modal" data-bs-target="#modalEditarDocente">
                                            <i class="bi bi-pencil"></i>
                                        </button>


<?php echo '<a href="../Configuracion/controller.php?action=delete&DocenteID=' . $d['DocenteID'] . '" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>'; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Editar -->
            <div class="modal fade" id="modalEditarDocente" tabindex="-1" aria-labelledby="modalEditarDocenteLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="../Configuracion/controller.php" method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Docente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="DocenteID" id="editDocenteID">
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
                                    <label for="editDireccion" class="form-label">Dirección</label>
                                    <input type="text" name="direccion" id="editDireccion" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editFecha" class="form-label">Fecha de Registro</label>
                                    <input type="date" name="fecha_registro" id="editFecha" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" name="editarDocente" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script>
$(document).ready(function () {
    $('#docentes-table').DataTable({
        language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_ docentes",
            paginate: { previous: "Anterior", next: "Siguiente" },
            zeroRecords: "No se encontraron resultados"
        }
    });

    $('.btn-editar').on('click', function () {
        const btn = $(this);
        $('#editDocenteID').val(btn.data('id'));
        $('#editDNI').val(btn.data('dni'));
        $('#editNombres').val(btn.data('nombres'));
        $('#editApellidos').val(btn.data('apellidos'));
        $('#editDireccion').val(btn.data('direccion'));
        $('#editFecha').val(btn.data('fecha'));
    });
});
</script>

</body>
</html>