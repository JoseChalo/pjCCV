<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ver contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/f97bd9ed48.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid p-3">
        <h1 class="text-center">Listado de Contactos</h1>
        <div class="d-flex justify-content-center">
            <div class="col-8 p-4">
                <table class="table text-center" style="white-space: nowrap;">
                    <thead class="bg-info">
                        <tr style="height: 45px !important;">
                            <th scope="col">Nombre</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">Fecha de Nacimiento</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">E-mail</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $serverName = "localhost";
                        $connectionInfo = array("Database" => "pjCCV", "UID" => "pjCCV", "PWD" => "pjCCV");
                        //$connectionInfo = array("Database"=>"pjCCV", "UID"=>"acalel", "PWD"=>"acalel");
                        $conexion = sqlsrv_connect($serverName, $connectionInfo);

                        if ($conexion) {
                            $sql = "SELECT * FROM contactos";
                            $stmt = sqlsrv_query($conexion, $sql);

                            if ($stmt === false) {
                                die(print_r(sqlsrv_errors(), true));
                            }

                            while ($datos = sqlsrv_fetch_object($stmt)) { ?>
                                <tr style="height: 33px !important;">
                                    <td><?= htmlspecialchars($datos->nombre) ?></td>
                                    <td><?= htmlspecialchars($datos->direccion) ?></td>
                                    <td><?= htmlspecialchars($datos->fechaNac->format('Y-m-d')) ?></td>
                                    <td><?= htmlspecialchars($datos->telefono) ?></td>
                                    <td><?= htmlspecialchars($datos->Email) ?></td>
                                    <td>
                                        <a href="eliminar_contacto.php?Email=<?= htmlspecialchars($datos->Email) ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                                        <a href="modificar-contacto.php?Email=<?= htmlspecialchars($datos->Email) ?>" class="btn btn-small bg-warning"><i class="fa-solid fa-pen"></i></a>                                    
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
    </div>
</body>
<style>
        /* Estilos personalizados para la tabla */
        .table thead {
            background-color: #17a2b8; /* Color de fondo del encabezado */
            color: white; /* Color del texto del encabezado */
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Color de fondo para las filas pares */
        }
        .table tbody tr:hover {
            background-color: #d1ecf1; /* Color de fondo al pasar el cursor */
        }
        .btn-small {
            font-size: 1.2rem; /* Tamaño de fuente más pequeño para los botones */
        }
        
    </style>
</html>
