<?php
include '../Negocio/negocio.php';
$obj = new Negocio();
$alumnos = $obj->lisAluCompleto(); // Lista de alumnos
$cursos = $obj->lisCursos();       // Lista de cursos
$secciones = $obj->lisSec(); // Lista de secciones
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Estudiantes a Cursos</title>
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
                    <a href="../Cursos/asignar_estudiantes.php" class="nav-link active"><i class="bi bi-people"></i> Asignar Estudiantes</a>
                    <a href="../Matricula/registro.php" class="nav-link"><i class="bi bi-truck"></i> Matrícula</a>
                    <a href="../Aula.php" class="nav-link"><i class="bi bi-globe"></i> Aulas</a>
                    <a href="../Cupo.php" class="nav-link"><i class="bi bi-clipboard-data"></i> Reportes</a>
                    <a href="../Registro/Docentes.php" class="nav-link"><i class="bi bi-person"></i> Docentes</a>
                    <a href="../Cursos/registro_curso.php" class="nav-link"><i class="bi bi-journal-bookmark-fill"></i> Cursos</a>
                    <a href="../Cursos/ver_curso.php" class="nav-link"><i class="bi bi-journal-bookmark-fill"></i> Ver Cursos</a>
                    <a href="../Login/config.php" class="nav-link"><i class="bi bi-gear"></i> Administrar usuarios</a>
                </div>
            </div>

            <!-- Main -->
            <div class="col-10 mt-3">
                <h4>Asignación de Estudiantes a Curso</h4>

                <form action="../Configuracion/controller.php" method="POST" id="formAsignacion">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="seccion" class="form-label">Sección</label>
                            <select name="seccion" id="seccion" class="form-select" required>
                                <option value="">Seleccione</option>
                                <?php foreach ($secciones as $s): ?>
                                    <option value="<?= $s['SeccionID'] ?>"><?= $s['Nombre_Seccion'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="curso" class="form-label">Curso</label>
                            <select name="curso" id="curso" class="form-select" required>
                                <option value="">Seleccione</option>
                                <?php foreach ($cursos as $c): ?>
                                    <option value="<?= $c['CursoID'] ?>"><?= $c['Nombre_Curso'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" name="asignarMultiple" class="btn btn-primary w-100">
                                <i class="bi bi-plus-lg"></i> Asignar Seleccionados
                            </button>
                        </div>
                    </div>

                    <!-- Tabla de alumnos con checkboxes -->
                    <table id="tabla-alumnos" class="table table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>DNI</th>
                                <th>Nombre</th>
                                <th>F. Nacimiento</th>
                                <th>F. Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alumnos as $alu): ?>
                                <tr>
                                    <td><input type="checkbox" name="alumnos[]" value="<?= $alu['AlumnoID'] ?>"></td>
                                    <td><?= $alu['DNI'] ?></td>
                                    <td><?= $alu['Nombres'] . ' ' . $alu['Apellidos'] ?></td>
                                    <td><?= $alu['Fec_Nacimiento'] ?></td>
                                    <td><?= $alu['Fec_Registro'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        $('#tabla-alumnos').DataTable();
        $('#select-all').on('click', function() {
            $('input[name="alumnos[]"]').prop('checked', this.checked);
        });
    });
</script>
</body>
</html>