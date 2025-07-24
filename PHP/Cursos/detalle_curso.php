<?php
include '../Negocio/negocio.php';

if (!isset($_GET['curso_id'])) {
    die("Curso no encontrado.");
}
$curso_id = (int)$_GET['curso_id'];

$obj     = new Negocio();
$curso   = $obj->getCursoById($curso_id);
$docentes = $obj->getDocentesByCurso($curso_id);

if (!$curso) {
    die("Curso no encontrado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .card-course {
            max-width: 900px;
            margin: 30px auto;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,.1);
        }
        .course-image {
            border-radius: 12px 12px 0 0;
            height: 240px;
            object-fit: cover;
            width: 100%;
        }
        .docente-link { text-decoration: none; }
        .docente-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="card card-course">
        <img src="../../src/images/logo.png" alt="Imagen curso" class="course-image">
        <div class="card-body">
            <h3 class="fw-bold mb-3"><?= htmlspecialchars($curso['Nombre_Curso']) ?></h3>
            <p><strong>Descripción:</strong> <?= $curso['Descripcion'] ? htmlspecialchars($curso['Descripcion']) : 'Sin descripción'; ?></p>
            <p><strong>Categoría:</strong> <?= htmlspecialchars($curso['Nombre_Categoria'] ?? 'N/A') ?></p>
            <p><strong>Sección/Aula:</strong> <?= htmlspecialchars($curso['Nombre_Seccion']) ?></p>
            <p><strong>Cupo máximo aula:</strong> <?= (int)$curso['Cupo_Maximo'] ?></p>
            <p><strong>Estado:</strong> <?= htmlspecialchars($curso['Estado']) ?></p>

            <hr>
            <h5 class="fw-bold mb-3"><i class="bi bi-people"></i> Docentes que dictan este curso</h5>
            <?php if (count($docentes) === 0): ?>
                <p class="text-muted">No hay docentes asignados.</p>
            <?php else: ?>
                <ul class="list-group">
                <?php foreach ($docentes as $doc): ?>
                    <li class="list-group-item">
                        <a class="docente-link" href="../Cursos/detalle_docente.php?docente_id=<?= $doc['DocenteID'] ?>">
                            <?= htmlspecialchars($doc['Nombres'] . ' ' . $doc['Apellidos']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>
    </div>

    <div class="text-center mt-3">
        <a href="../Cursos/ver_curso.php" class="btn btn-secondary">Volver a cursos</a>
    </div>
</div>

</body>
</html>