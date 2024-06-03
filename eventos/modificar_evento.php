<?php
require_once '../conexion.php';

if (isset($_GET['idEvento'])) {
    $idEvento = $_GET['idEvento'];

    // Conexión a la base de datos
    $conexion = Cconexion::ConexionBD();
    if ($conexion === false) {
        die('Error de conexión: ' . print_r(sqlsrv_errors(), true));
    }

    // Consulta para obtener los datos del evento
    $sql = "SELECT * FROM eventos WHERE idEvento = ?";
    $params = array($idEvento);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $datos = sqlsrv_fetch_object($stmt);
    if ($datos === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Asignar los valores de los campos del evento a variables
    $tituloActual = $datos->titulo;
    $fechaActual = $datos->fecha->format('Y-m-d'); // Asegúrate de que el formato de fecha sea 'Y-m-d'
    $horaActual = $datos->hora->format('H:i'); // Asegúrate de que el formato de hora sea 'H:i'
    $descripcionActual = $datos->descripcion;
    $idTipoActual = $datos->idEvento;

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conexion);
} else {
    echo "<p>No se proporcionaron ID de evento.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/f97bd9ed48.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container-fluid p-3 text-center">
    <div class="w-50 mx-auto p-3 bg-light rounded shadow-lg p-3 mb-5 bg-body rounded">
        <h1 class="mb-4">Modificar Evento</h1>
        <form class="row g-3" method="post" action="editar_evento.php">
            <div class="col-md-6">
                <label class="form-label">Titulo</label>
                <input type="text" maxlength="90" class="form-control" placeholder="Titulo (Maximo de caracteres 90)" name="title" autocomplete="off" required value="<?php echo htmlspecialchars($tituloActual); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha de evento</label>
                <input type="date" class="form-control" name="date" required value="<?php echo htmlspecialchars($fechaActual); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Hora del evento</label>
                <input type="time" class="form-control" placeholder="hour" name="hour" required value="<?php echo htmlspecialchars($horaActual); ?>">
            </div>
            <div class="col-md-6">
                <label for="validationCustom04" class="form-label">Tipo de evento</label>
                <select class="form-select" id="validationCustom04" name="typeEvent" required>
                    <option selected disabled value="">Elige...</option>
                    <?php
                    $conexion = Cconexion::ConexionBD();
                    if ($conexion === false) {
                        die('Error de conexión: ' . print_r(sqlsrv_errors(), true));
                    }
                    $query = "SELECT idTipo, nombre FROM tiposEventos";
                    $dataEventos = sqlsrv_query($conexion, $query);
                    if ($dataEventos === false) {
                        die('Error en la consulta SELECT: ' . print_r(sqlsrv_errors(), true));
                    }
                    while ($fila = sqlsrv_fetch_array($dataEventos, SQLSRV_FETCH_ASSOC)) {
                        $nombreEvento = $fila['nombre'];
                        $idTipo = $fila['idTipo'];
                        $selected = ($idTipo == $idTipoActual) ? 'selected' : '';
                        echo "<option value='$idTipo' $selected> $nombreEvento </option>";
                    }
                    sqlsrv_free_stmt($dataEventos);
                    sqlsrv_close($conexion);
                    ?>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" placeholder="Texto requerido" name="descrip" autocomplete="off" required><?php echo htmlspecialchars($descripcionActual); ?></textarea>
            </div>
            <div class="col-12">
                <input type="hidden" name="idEvento" value="<?php echo htmlspecialchars($idEvento); ?>">
                <button type="submit" class="btn btn-primary" name="btnregistroevento" value="ok">Modificar Evento</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
