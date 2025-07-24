<?php
$conn = new mysqli("localhost", "root", "", "Institucion");

// Agregar sección
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $cupo = $_POST['cupo'];
    $conn->query("INSERT INTO Secciones (Nombre_Seccion, Cupo_Maximo) VALUES ('$nombre', '$cupo')");
}

// Actualizar sección
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    $nombre_original = $_POST['nombre_original'];
    $nombre_nuevo = $_POST['nombre'];
    $cupo = $_POST['cupo'];
    $conn->query("UPDATE Secciones SET Nombre_Seccion = '$nombre_nuevo', Cupo_Maximo = '$cupo' WHERE Nombre_Seccion = '$nombre_original'");
}

// Eliminar sección
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM Secciones WHERE Nombre_Seccion = '$id'");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Aulas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
</head>

<body class="bg-light">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Gestión de Aulas</h4>
        </a>
    </div>

    <!-- Formulario Agregar -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Añadir Nueva Sección</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre de la Sección</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="cupo" class="form-label">Cupo Máximo</label>
                        <input type="number" id="cupo" name="cupo" class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" name="agregar" class="btn btn-success w-100">Agregar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Listado de Secciones</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>Nombre de Sección</th>
                        <th>Cupo Máximo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT Nombre_Seccion, Cupo_Maximo FROM Secciones");
                    while ($row = $result->fetch_assoc()) {
                        $nombre = $row['Nombre_Seccion'];
                        $cupo = $row['Cupo_Maximo'];
                        echo "<tr>
                            <td>$nombre</td>
                            <td>$cupo</td>
                            <td>
                                <button 
                                    class='btn btn-outline-primary btn-sm me-1 btn-editar' 
                                    data-nombre='$nombre' 
                                    data-cupo='$cupo' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#modalEditar'>
                                    <i class='bi bi-pencil'></i>
                                </button>
                                <a href='?eliminar=$nombre' class='btn btn-outline-danger btn-sm' onclick=\"return confirm('¿Eliminar esta sección?');\">
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

  <div class="mt-4 text-center">
        <a href="/Integrador-main/PHP/Registro/Registro_estudiantes.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver al Menú principal
        </a>
    </div>
</div> <!-- cierre del contenedor principal -->
    
</div>
<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Sección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="nombre_original" name="nombre_original">
                <div class="mb-3">
                    <label for="editNombre" class="form-label">Nombre de Sección</label>
                    <input type="text" id="editNombre" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="editCupo" class="form-label">Cupo Máximo</label>
                    <input type="number" id="editCupo" name="cupo" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="editar" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function () {
    $('.btn-editar').on('click', function () {
        const nombre = $(this).data('nombre');
        const cupo = $(this).data('cupo');
        $('#editNombre').val(nombre);
        $('#editCupo').val(cupo);
        $('#nombre_original').val(nombre);
    });
});
</script>
</body>
</html>