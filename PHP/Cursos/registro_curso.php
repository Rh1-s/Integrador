<?php session_start(); ?>
<?php
if (isset($_GET['success'])) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: '¡Curso registrado!',
            text: 'El curso fue registrado correctamente.'
        });
    </script>";
}
if (isset($_GET['error'])) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo registrar el curso.'
        });
    </script>";
}
if (isset($_GET['success_edit'])) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: '¡Curso actualizado!',
            text: 'El curso se ha modificado correctamente.'
        });
    </script>";
}
if (isset($_GET['error_edit'])) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Error en la modificación del curso',
            text: 'Los cambios no han sido guardados.'
        });
    </script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Cursos</title>
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
                <a href="../Cupo.php" class="nav-link"><i class="bi bi-clipboard-data"></i> Reportes</a>
                <a href="../Registro/Docentes.php" class="nav-link"><i class="bi bi-person"></i> Docentes</a>
                <a href="../Cursos/registro_curso.php" class="nav-link active"><i class="bi bi-journal-bookmark-fill"></i> Cursos</a>
                <a href="../Cursos/ver_curso.php" class="nav-link"><i class="bi bi-journal-bookmark-fill"></i> Ver Cursos </a>
                <a href="../Login/config.php" class="nav-link"><i class="bi bi-gear"></i> Administrar usuarios </a>
            </div>
        </div>

        <!-- Main -->
        <div class="col-10 mt-3">
            <h4>Registro de Curso</h4>
            <form action="../Configuracion/controller.php" method="POST" class="row g-3">
                <div class="card">
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre del Curso</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="docente_id" class="form-label">Docente Asignado</label>
                            <select name="docente_id" id="docente_id" class="form-select" required>
                                <option value="">Seleccione un docente</option>
                                <?php
                                include '../Negocio/negocio.php';
                                $obj = new Negocio();
                                foreach ($obj->lisDocentes() as $doc) {
                                    echo "<option value='{$doc['DocenteID']}'>{$doc['Nombres']} {$doc['Apellidos']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="aula_id" class="form-label">Aula Asignada</label>
                            <select name="aula_id" id="aula_id" class="form-select" required>
                                <option value="">Seleccione un aula</option>
                                <?php
                                foreach ($obj->lisAula() as $aula) {
                                    echo "<option value='{$aula['SeccionID']}'>{$aula['Nombre_Aula']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" id="estado" class="form-select">
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" name="guardarCurso" class="btn btn-primary w-100">Registrar Curso</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Botón PDF -->
            <div class="d-flex justify-content-end mt-3">
                <form action="../Reportes/generar_pdf_cursos.php" method="POST">
                    <button name="generarReporte" class="btn btn-success">
                        <i class="bi bi-file-earmark-pdf"></i> Generar Reporte
                    </button>
                </form>
            </div>

            <!-- Tabla -->
            <div class="row mt-4">
                <div class="col" data-simplebar style="max-height: 420px;">
                    <table id="cursos-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Docente</th>
                                <th>Aula</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cursos = $obj->lisCursos();
                            foreach ($cursos as $curso) {
                                echo "<tr>
                                    <td>{$curso['Nombre_Curso']}</td>
                                    <td>{$curso['Docente']}</td>
                                    <td>{$curso['Aula']}</td>
                                    <td>{$curso['Estado']}</td>
                                    <td>
                                        <button 
                                            type='button' 
                                            class='btn btn-sm btn-outline-primary btn-editar'
                                            data-id='{$curso['CursoID']}'
                                            data-nombre=\"".htmlspecialchars($curso['Nombre_Curso'])."\"
                                            data-descripcion=\"".htmlspecialchars($curso['Descripcion'])."\"
                                            data-docente='{$curso['DocenteID']}'
                                            data-aula='{$curso['SeccionID']}'
                                            data-estado='{$curso['Estado']}'
                                            data-bs-toggle='modal' data-bs-target='#modalEditarCurso'
                                        >
                                            <i class='bi bi-pencil'></i>
                                        </button>
                                        <a href='../Configuracion/controller.php?action=deleteCurso&CursoID={$curso['CursoID']}' class='btn btn-sm btn-outline-danger'>
                                            <i class='bi bi-trash'></i>
                                        </a>
                                    </td>
                                </tr>";
                            }
                            ?>
                            </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Editar Curso -->
<div class="modal fade" id="modalEditarCurso" tabindex="-1" aria-labelledby="modalEditarCursoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="../Configuracion/controller.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar Curso</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="CursoID" id="editCursoID">

          <div class="mb-3">
            <label class="form-label">Nombre del Curso</label>
            <input type="text" class="form-control" name="nombre" id="editNombre" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" name="descripcion" id="editDescripcion">
          </div>

          <div class="mb-3">
            <label class="form-label">Docente Asignado</label>
            <select class="form-select" name="docente_id" id="editDocente" required>
              <option value="">Seleccione un docente</option>
              <?php
              foreach ($obj->lisDocentes() as $doc) {
                  echo "<option value='{$doc['DocenteID']}'>{$doc['Nombres']} {$doc['Apellidos']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Aula Asignada</label>
            <select class="form-select" name="aula_id" id="editAula" required>
              <option value="">Seleccione un aula</option>
              <?php
              foreach ($obj->lisAula() as $aula) {
                  echo "<option value='{$aula['SeccionID']}'>{$aula['Nombre_Aula']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Estado</label>
            <select class="form-select" name="estado" id="editEstado" required>
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" name="editarCurso" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- JS DataTables -->
<script>
    $(document).ready(function () {
        $('#cursos-table').DataTable({
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ cursos",
                paginate: { previous: "Anterior", next: "Siguiente" },
                zeroRecords: "No se encontraron resultados",
                infoEmpty: "Mostrando 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)"
            }
        });
    });
    $(document).ready(function () {
        $('.btn-editar').on('click', function () {
            const btn = $(this);
            $('#editCursoID').val(btn.data('id'));
            $('#editNombre').val(btn.data('nombre'));
            $('#editDescripcion').val(btn.data('descripcion'));
            $('#editDocente').val(btn.data('docente'));
            $('#editAula').val(btn.data('aula'));
            $('#editEstado').val(btn.data('estado'));
        });
    });
</script>


</body>
</html>
