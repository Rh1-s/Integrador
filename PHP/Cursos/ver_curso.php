<?php
session_start();
$rol = $_SESSION["IDUSUARIO"][1] ?? 'Invitado'; // "Administrador", "Docente", etc.
?>
<?php
include '../Negocio/negocio.php';
$obj = new Negocio();
$cursos = $obj->lisCursos(); // Devuelve los cursos con docente y aula
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Visualización de Cursos</title>

    <!-- jQuery + SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap, Iconos, Estilos -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/Reportes/reportes.css">
    <link rel="icon" href="../../src/images/logo.ico">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .custom-sidebar {
            background-color: #0d1b2a;
            min-height: 100vh;
            color: white;
            padding-top: 20px;
        }

        .custom-sidebar .nav-link {
            color: #fff;
            margin: 10px 0;
        }

        .custom-sidebar .nav-link.active {
            background-color: #1b263b;
            border-radius: 8px;
        }

        .course-card {
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            background: #fff;
        }

        .course-card:hover {
            transform: translateY(-5px);
        }

        .course-progress {
            font-size: 14px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(220, 53, 69, 0.9);
            color: #fff;
            padding: 4px 8px;
            border-radius: 5px;
        }

        .course-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .course-body {
            padding: 15px;
        }
    </style>
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

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-2 custom-sidebar">
                <div class="nav flex-column">
                    <?php if ($rol != 'Docente'): ?>
                        <a href="../Registro/Registro_estudiantes.php?user=1" class="nav-link"><i class="bi bi-box-seam"></i> Estudiantes</a>
                        <a href="../Matricula/registro.php" class="nav-link"><i class="bi bi-truck"></i> Matrícula</a>
                        <a href="../Aula.php" class="nav-link"><i class="bi bi-globe"></i> Aulas</a>
                        <a href="../Cupo.php" class="nav-link"><i class="bi bi-clipboard-data"></i> Reportes</a>
                        <a href="../Registro/Docentes.php" class="nav-link"><i class="bi bi-person"></i> Docentes</a>
                        <a href="../Cursos/registro_curso.php" class="nav-link"><i class="bi bi-journal-bookmark-fill"></i> Cursos</a>
                        <a href="../Login/config.php" class="nav-link"><i class="bi bi-gear"></i> Administrar usuarios </a>
                    <?php endif; ?>

                    <!-- Este se muestra siempre -->
                    <a href="../Cursos/ver_curso.php" class="nav-link active"><i class="bi bi-journal-bookmark-fill"></i> Ver Cursos </a>
                </div>

            </div>

            <!-- Contenido de cursos -->
            <div class="col-10 mt-4">
                <h4 class="mb-4">Cursos Registrados</h4>
                <div class="row g-4">
                    <?php foreach ($cursos as $curso): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card course-card">
                                <a href="detalle_curso.php?curso_id=<?= $curso['CursoID'] ?>" class="stretched-link"></a>
                                <span class="course-progress"><?= rand(20, 90) ?>%</span>
                                <img src="../../src/images/logo.png" alt="Imagen Curso" class="course-image">
                                <div class="course-body">
                                    <h5 class="fw-bold"><?= $curso['Nombre_Curso'] ?></h5>
                                    <p class="mb-1"><small>ID: <?= $curso['CursoID'] ?> - <?= $curso['Estado'] ?></small></p>
                                    <p class="mb-1"><i class="bi bi-person-fill"></i> <?= $curso['Docente'] ?></p>
                                    <p class="mb-1"><i class="bi bi-building"></i> Aula: <?= $curso['Nombre_Seccion'] ?? 'N/A' ?></p>
                                    <div class="d-flex justify-content-between mt-3">
                                        <a href="../Configuracion/controller.php?action=editCurso&CursoID=<?= $curso['CursoID'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                        <a href="../Configuracion/controller.php?action=deleteCurso&CursoID=<?= $curso['CursoID'] ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>