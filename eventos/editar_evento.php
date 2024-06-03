<?php
require_once '../conexion.php';

if (!empty($_POST["btnregistroevento"])) {
    if (!empty($_POST["idEvento"]) && !empty($_POST["title"]) && !empty($_POST["date"]) && !empty($_POST["hour"]) && !empty($_POST["typeEvent"])) {
        $idEvento = $_POST['idEvento'];
        $titulo = $_POST['title'];
        $fecha = $_POST['date'];
        $hora = $_POST['hour'];
        $tipoEvento = $_POST['typeEvent'];
        $descripcion = $_POST['descrip'];

        // Conexión a la base de datos
        $conexion = Cconexion::ConexionBD();
        if ($conexion === false) {
            die('Error de conexión: ' . print_r(sqlsrv_errors(), true));
        }

        // Actualizar los datos del evento
        $sql = "UPDATE eventos SET titulo = ?, fecha = ?, hora = ?, idTipo = ?, descripcion = ? WHERE idEvento = ?";
        $params = array($titulo, $fecha, $hora, $tipoEvento, $descripcion, $idEvento);
        $stmt = sqlsrv_query($conexion, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "Evento actualizado correctamente.";
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conexion);

        // Redirigir de vuelta a la página de eventos (ajusta la URL según sea necesario)
        header("Location: http://localhost/pjCCV");
        exit;
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>
