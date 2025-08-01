<?php
include '../Negocio/negocio.php';

if (!isset($_GET['docente_id'])) {
    die("Docente no encontrado.");
}
$docente_id = (int)$_GET['docente_id'];

$obj      = new Negocio();
$docente  = $obj->getDocenteById($docente_id);
$cursos   = $obj->getCursosByDocente($docente_id);

if (!$docente) {
    die("Docente no encontrado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: #f8f9fa; }
        .docente-card {
            max-width: 950px;
            margin: 30px auto;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,.1);
        }
        .docente-header {
            background: #0d6efd;
            color: white;
            padding: 20px;
            border-radius: 12px 12px 0 0;
        }
        .attendance-section {
            margin-top: 30px;
        }
        .attendance-section table th,
        .attendance-section table td {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container mt-4">

    <!-- Tarjeta del docente -->
    <div class="card docente-card">
        <div class="docente-header">
            <h3 class="fw-bold mb-0"><?= htmlspecialchars($docente['Nombres'] . ' ' . $docente['Apellidos']) ?></h3>
            <small>DNI: <?= htmlspecialchars($docente['DNI']) ?></small>
        </div>
        <div class="card-body">
            <p><strong>Dirección:</strong> <?= htmlspecialchars($docente['Direccion'] ?? 'No registrada') ?></p>
            <p><strong>Fecha de registro:</strong> <?= htmlspecialchars($docente['Fec_Registro']) ?></p>

            <hr>
            <h5 class="fw-bold"><i class="bi bi-journal"></i> Cursos que dicta:</h5>
            <?php if (count($cursos) === 0) : ?>
                <p class="text-muted">Este docente no tiene cursos asignados.</p>
            <?php else : ?>
                <ul class="list-group">
                    <?php foreach ($cursos as $curso) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <?= htmlspecialchars($curso['Nombre_Curso']) ?>
                                <small>(Sección: <?= htmlspecialchars($curso['Nombre_Seccion']) ?>)</small>
                            </span>
                            <div class="d-flex gap-2">
                                <a href="../Cursos/detalle_curso.php?curso_id=<?= $curso['CursoID'] ?>" class="btn btn-sm btn-outline-primary">
                                    Ver Curso
                                </a>
                                <button class="btn btn-sm btn-outline-info" onclick="cargarAsistencia(<?= (int)$curso['CursoID'] ?>)">
                                    Asistencia
                                </button>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <hr>
            <h5 class="fw-bold mt-4"><i class="bi bi-emoji-smile"></i> Registro de conducta por Docente</h5>

            <?php if (count($cursos) === 0) : ?>
                <p class="text-muted">No hay cursos para mostrar conductas.</p>
            <?php else : ?>
                <?php foreach ($cursos as $curso) : ?>
                    <div class="mt-3">
                        <h6 class="text-primary">
                            <?= htmlspecialchars($curso['Nombre_Curso']) ?>
                            - <small>Sección: <?= htmlspecialchars($curso['Nombre_Seccion']) ?></small>
                        </h6>
                        <?php
                        $conductas = $obj->getConductaByCurso($curso['CursoID']);
                        ?>
                        <?php if (empty($conductas)) : ?>
                            <p class="text-muted">No hay registros de conducta.</p>
                        <?php else : ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Comentario</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($conductas as $c) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($c[0]) ?></td>
                                                <td><?= htmlspecialchars($c[1]) ?></td>
                                                <td><?= htmlspecialchars($c[2]) ?></td>
                                                <td><?= htmlspecialchars($c[3]) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>

    <!-- Módulo de Asistencia -->
    <div class="card docente-card attendance-section" id="attendance-card" style="display:none;">
        <div class="card-body">
            <h5 class="fw-bold">Asistencia del Curso: <span id="nombreCurso"></span></h5>

            <form id="asistenciaForm" method="POST">
                <div class="d-flex justify-content-start mb-2">
                    <label for="fechaPDF" class="me-2">Fecha:</label>
                    <input type="date" id="fechaPDF" value="<?= date('Y-m-d') ?>" class="form-control w-auto">
                </div>

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Presente</th>
                            <th>Ausente</th>
                        </tr>
                    </thead>
                    <tbody id="alumnosAsistencia">
                        <!-- Se llena dinámicamente -->
                    </tbody>
                </table>

                <button type="submit" class="btn btn-success mt-2">Guardar Asistencia</button>
            </form>

            <div class="d-flex justify-content-between mt-3">
                <a id="btnExportPDF" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Exportar PDF</a>
            </div>
        </div>
    </div>

    <div class="text-center mt-3 mb-5">
        <a href="../Registro/Docentes.php" class="btn btn-secondary">Volver a Docentes</a>
    </div>

</div> <!-- /container -->

<script>
function cargarAsistencia(cursoID) {
    $.ajax({
        url: '../Configuracion/controller.php',
        type: 'GET',
        data: { action: 'getAsistencia', curso_id: cursoID },
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                $('#attendance-card').show();
                $('#nombreCurso').text(data.curso);

                // Guardamos cursoID en el formulario
                $('#asistenciaForm').attr('data-curso', cursoID);

                let alumnosHTML = '';
                data.alumnos.forEach(a => {
                    alumnosHTML += `
                        <tr>
                            <td>${a.Nombres} ${a.Apellidos}</td>
                            <td><input type="radio" name="estado_${a.AlumnoID}" value="Presente" checked></td>
                            <td><input type="radio" name="estado_${a.AlumnoID}" value="Ausente"></td>
                        </tr>
                    `;
                });
                $('#alumnosAsistencia').html(alumnosHTML);

                // Bind submit
                $('#asistenciaForm').off('submit').on('submit', function(e){
                    e.preventDefault();
                    guardarAsistencia($(this).attr('data-curso'));
                });
            } else {
                Swal.fire("Error", "No se pudo cargar la asistencia.", "error");
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            Swal.fire("Error", "Ocurrió un problema al cargar la asistencia.", "error");
        }
    });
}

function guardarAsistencia(cursoID) {
    let fecha = $('#fechaPDF').val();
    let formData = $('#asistenciaForm').serialize() +
                   '&action=saveAsistencia' +
                   '&curso_id=' + cursoID +
                   '&fecha=' + fecha;

    $.post('../Configuracion/controller.php', formData, function(response){
        if (response && response.success) {
            Swal.fire("Éxito", "Asistencia registrada correctamente.", "success");
        } else {
            Swal.fire("Error", (response && response.error) ? response.error : "No se pudo guardar la asistencia.", "error");
        }
    }, 'json').fail(function(xhr){
        console.error(xhr.responseText);
        Swal.fire("Error", "No se pudo conectar con el servidor.", "error");
    });
}

$('#btnExportPDF').on('click', function() {
    const cursoID = $('#asistenciaForm').data('curso');
    const fecha = $('#fechaPDF').val();
    if (!cursoID) {
        Swal.fire("Error", "Primero selecciona un curso.", "error");
        return;
    }
    window.open(`../Reportes/asistencia_pdf.php?curso_id=${cursoID}&fecha=${fecha}`, '_blank');
});
</script>

</body>
</html>