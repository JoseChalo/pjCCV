<?php
if (!empty($_GET["Email"])) {
   $email=$_GET["Email"];
   $serverName = "localhost";
    $connectionInfo = array("Database" => "pjCCV", "UID" => "pjCCV", "PWD" => "pjCCV");
    $conexion = sqlsrv_connect($serverName, $connectionInfo);

    // Verificar si la conexión se estableció correctamente
    if ($conexion === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Preparar la consulta usando parámetros
    $sql = "DELETE FROM contactos WHERE Email = ?";
    $params = array($email);

    $stmt = sqlsrv_query($conexion, $sql, $params);

    // Verificar si la consulta se ejecutó correctamente
    if ($stmt) {
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conexion);
        header("Location: verContactos.php");
        exit();
    } else {
        echo "<div class='alert alert-warning'>Error al eliminar</div>";
    }
}
?>