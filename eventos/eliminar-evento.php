<?php
if (!empty($_GET["idEvento"])) {
    $idEvento = $_GET["idEvento"];

    $serverName = "localhost";
    $connectionInfo = array("Database" => "pjCCV", "UID" => "pjCCV", "PWD" => "pjCCV");
    $conexion = sqlsrv_connect($serverName, $connectionInfo);

    if ($conexion === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Eliminar las entradas relacionadas en la tabla cumple
    $sqlCumple = "DELETE FROM cumple WHERE idEvento = ?";
    $paramsCumple = array($idEvento);
    $stmtCumple = sqlsrv_query($conexion, $sqlCumple, $paramsCumple);

    if ($stmtCumple === false) {
        die("Error al eliminar las entradas relacionadas en la tabla cumple: " . print_r(sqlsrv_errors(), true));
    }

    // Eliminar el evento de la tabla eventos
    $sqlEvento = "DELETE FROM eventos WHERE idEvento = ?";
    $paramsEvento = array($idEvento);
    $stmtEvento = sqlsrv_query($conexion, $sqlEvento, $paramsEvento);

    if ($stmtEvento === false) {
        die("Error al eliminar el evento: " . print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmtCumple);
    sqlsrv_free_stmt($stmtEvento);
    sqlsrv_close($conexion);

    header("Location: http://localhost/pjCCV");
    diedie("eliminado correctamene:  ");
    exit();
} else {
    echo "ID  del evento no proporcionado.";
}
?>
