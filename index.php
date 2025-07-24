<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/index/index.css">
    <link rel="icon" href="src/images/logo.ico">

    <style>
        .logo-container {
            text-align: center;
            margin-top: 30px;
        }

        .logo {
            width: 120px;
        }

        .login-container {
            display: none;
        }

        .formulario {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Logo -->
    <div class="logo-container">
        <img src="src/images/logo.jpg" alt="SnowBox Logo" class="logo">
    </div>

    <!-- Contenedor de Login -->
    <div id="loginContainer" class="login-container d-flex justify-content-center align-items-center vh-100">
        <div class="login-box p-5 rounded shadow w-100" style="max-width: 400px;">
            <h2 class="text-center mb-4" id="loginTitle">Iniciar Sesión</h2>

            <!-- Formulario Administrador -->
            <form id="formAdmin" class="formulario" action="PHP/Login/controller.php?action=login" method="post">
                <input type="hidden" name="rol" value="administrador">
                <div class="mb-3">
                    <label class="form-label">Usuario Administrador</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar como Administrador</button>
            </form>

            <!-- Formulario Docente -->
            <form id="formDocente" class="formulario" action="PHP/Login/controller_docente.php?action=login" method="post">
                <input type="hidden" name="rol" value="docente">
                <div class="mb-3">
                    <label class="form-label">Código Docente</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Clave de Acceso</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Ingresar como Docente</button>
            </form>
        </div>
    </div>

    <!-- Modal de Selección de Rol -->
    <div class="modal fade" id="rolModal" tabindex="-1" aria-labelledby="rolModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title w-100">Seleccione su rol</h5>
                </div>
                <div class="modal-body">
                    <button class="btn btn-primary w-75 mb-3" onclick="seleccionarRol('administrador')">Administrador</button>
                    <button class="btn btn-success w-75" onclick="seleccionarRol('docente')">Docente</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const rolModal = new bootstrap.Modal(document.getElementById('rolModal'));
            rolModal.show();
        });

        function seleccionarRol(rol) {
            // Ocultar modal y mostrar contenedor de login
            const modal = bootstrap.Modal.getInstance(document.getElementById('rolModal'));
            modal.hide();
            document.getElementById('loginContainer').style.display = 'flex';

            const loginTitle = document.getElementById('loginTitle');
            const formAdmin = document.getElementById('formAdmin');
            const formDocente = document.getElementById('formDocente');

            // Mostrar el formulario correspondiente
            if (rol === 'administrador') {
                loginTitle.innerText = 'Iniciar Sesión - Administrador';
                formAdmin.style.display = 'block';
                formDocente.style.display = 'none';
            } else if (rol === 'docente') {
                loginTitle.innerText = 'Iniciar Sesión - Docente';
                formAdmin.style.display = 'none';
                formDocente.style.display = 'block';
            }
        }
    </script>
</body>

</html>
