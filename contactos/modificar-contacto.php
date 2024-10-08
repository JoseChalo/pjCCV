<?php
$email = $_GET["Email"];
// Detalles de la conexión a la base de datos
$serverName = "localhost";
$connectionInfo = array("Database" => "pjCCV", "UID" => "pjCCV", "PWD" => "pjCCV");
$conexion = sqlsrv_connect($serverName, $connectionInfo);

// Verificar si la conexión se estableció correctamente
if ($conexion === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Preparar la consulta
$sql = "SELECT * FROM contactos WHERE Email = ?";
$params = array($email);

// Ejecutar la consulta
$stmt = sqlsrv_query($conexion, $sql, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contactos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    <script src="https://kit.fontawesome.com/f97bd9ed48.js" crossorigin="anonymous"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.html">Calendario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex">
                    <li class="nav-item">
                        <a class="nav-link" href="../eventos/nuevoTipoEvento.html"> Nuevo tipo de Evento </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../eventos/agregarEvento.php"> Crear Evento </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Contactos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="agregarContactos.html">Agregar nuevo
                                    contacto</a></li>
                            <li><a class="dropdown-item" href="verContactos.php">Ver contactos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../info.html"> Como usar? </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <form class="col-4 p-3 m-auto" method="post">
        <h5 class="text-center alert alert-secondary">Editar Contacto</h5>
        <?php
        include "editar_contacto.php";
        while ($datos = sqlsrv_fetch_object($stmt)) { ?>
            <div class="mb-3">
                <label for="inputNombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="inputNombre" name="nameContac"
                    value="<?= htmlspecialchars($datos->nombre) ?>" required>
            </div>
            <div class="mb-3">
                <label for="inputFechaNac" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="inputFechaNac" name="dateContac"
                    value="<?= htmlspecialchars($datos->fechaNac->format('Y-m-d')) ?>" required>
            </div>
            <div class="mb-3">
                <label for="inputDireccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="inputDireccion" name="addresContac"
                    value="<?= htmlspecialchars($datos->direccion) ?>" required>
            </div>
            <div class="mb-3">
                <label for="inputTelefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="inputTelefono" name="phoneContac"
                    value="<?= htmlspecialchars($datos->telefono) ?>" required>
            </div>
            <div class="mb-3">
                <input type="hidden" class="form-control" id="inputEmail" name="emailContac"
                    value="<?= htmlspecialchars($datos->Email) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="btnregistro" value="ok">Modificar Contacto</button>
        <?php }
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conexion);
        ?>
    </form>
</body>

</html>