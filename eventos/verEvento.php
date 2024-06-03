<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ver evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/f97bd9ed48.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid p-3 table-center text-center">
        <h1>Detalles del Evento</h1>
        <?php
      
       // Verificar si 'idEvento' y 'idTipo' están definidos en la URL
       if(isset($_GET['idEvento']) && isset($_GET['idTipo'])) {
           $idEvento = $_GET['idEvento'];
           $idTipo = $_GET['idTipo'];
        

           // Continuar con el procesamiento de los detalles del evento
           // Aquí puedes colocar tu código actual que muestra los detalles del evento
       } else {
           echo "<p>No se proporcionaron ID de evento y tipo.</p>";
       }
       ?>

        <div class="col-8 p-4">
            <table class="table" style="text-align: center;word-wrap: break-word;margin-left: 225px;">
                <thead class="bg-info">
                    <tr style="height: 45px !important;">
                        <th scope="col">Titulo</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $serverName = "localhost";
                    $connectionInfo = array("Database" => "pjCCV", "UID" => "pjCCV", "PWD" => "pjCCV");
                    $conexion = sqlsrv_connect($serverName, $connectionInfo);

                    if ($conexion) {
                        $sql = "SELECT * FROM eventos WHERE idEvento = ?";
                        $params = array($idEvento);
                        $stmt = sqlsrv_query($conexion, $sql, $params);

                        if ($stmt === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        while ($datos = sqlsrv_fetch_object($stmt)) { ?>
                            <tr style="height: 33px !important;">
                                <td><?= htmlspecialchars($datos->titulo) ?></td>
                                <td><?= htmlspecialchars($datos->descripcion) ?></td>
                                <td><?= htmlspecialchars($datos->fecha->format('Y-m-d')) ?></td>
                                <td><?= htmlspecialchars($datos->hora->format('H:i:s')) ?></td>
                                <td>
                                    <a href="eliminar-evento.php?idEvento=<?= $datos->idEvento ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    <a href="modificar_evento.php?idEvento=<?= $datos->idEvento ?>" class="btn btn-small bg-warning"><i class="fa-solid fa-pen"></i></a>

                                </td>
                            </tr>
                        <?php }
                        sqlsrv_free_stmt($stmt);
                    } else {
                        echo "Error al conectar a la base de datos.";
                    }

                    sqlsrv_close($conexion);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>