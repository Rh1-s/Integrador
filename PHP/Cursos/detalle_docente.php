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
    <style>
        body {
            background: #f8f9fa;
        }

        .docente-card {
            max-width: 900px;
            margin: 30px auto;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
        }

        .docente-header {
            background: #0d6efd;
            color: white;
            padding: 20px;
            border-radius: 12px 12px 0 0;
        }
    </style>
</head>

<body>

    <div class="container mt-4">
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
                <?php if (count($cursos) === 0): ?>
                    <p class="text-muted">Este docente no tiene cursos asignados.</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($cursos as $curso): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <?= htmlspecialchars($curso['Nombre_Curso']) ?>
                                    <small>(Sección: <?= htmlspecialchars($curso['Nombre_Seccion']) ?>)</small>
                                </span>
                                <a href="../Cursos/detalle_curso.php?curso_id=<?= $curso['CursoID'] ?>" class="btn btn-sm btn-outline-primary">Ver Curso</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <hr>
                <h5 class="fw-bold mt-4"><i class="bi bi-emoji-smile"></i> Registro de conducta por Docente</h5>
                <?php foreach ($cursos as $curso): ?>
                    <div class="mt-3">
                        <h6 class="text-primary"><?= htmlspecialchars($curso['Nombre_Curso']) ?> - <small>Sección: <?= htmlspecialchars($curso['Nombre_Seccion']) ?></small></h6>
                        <?php
                        $conductas = $obj->getConductaByCurso($curso['CursoID']);
                        ?>
                        <?php if (count($conductas) === 0): ?>
                            <p class="text-muted">No hay registros de conducta.</p>
                        <?php else: ?>
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
                                        <?php foreach ($conductas as $c): ?>
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

            </div>
        </div>

        <div class="text-center mt-3">
            <a href="../Registro/Docentes.php" class="btn btn-secondary">Volver a Docentes</a>
        </div>
    </div>

</body>

</html>