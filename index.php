<?php
    session_start();

    if(isset($_SESSION['usuario_id'])) {
        $usuarioId = $_SESSION['usuario_id'];
        $nombreUsuario = $_SESSION['nombre_usuario'];
        $rolUsuario = $_SESSION['rol'];
        $documentoUsuario = $_SESSION['usuario']; // Documento del usuario
    } else {
        header('Location: login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>firplak</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
</head>
<body class="d-flex flex-column min-vh-100">

    <header>
    </header>

    <main class="flex-shrink-0">
        <section>
            <?php
                require_once 'funciones.php';

                require("conexionMysql/conexion.php");
                $conex = ConectarDB();

                $sql = $conex->query("
                SELECT e.*, p.fechaCarga
                FROM entregas e
                INNER JOIN pruebadeentrega p ON e.idEntrega = p.idEntrega
                GROUP BY e.idEntrega
                ORDER BY p.fechaCarga DESC
                ");
            
                $resultados = [];
                $busquedaRealizada = false;
                
                if (isset($_POST['numeroGuia']) && $_POST['numeroGuia'] != '') {
                    $busquedaRealizada = true;
                    $numeroGuia = $conex->real_escape_string($_POST['numeroGuia']);
                    
                    $sqlSearch = $conex->query("SELECT * FROM entregas WHERE numeroGuia = '$numeroGuia'");
                    
                    if ($sqlSearch) {
                        while ($fila = $sqlSearch->fetch_assoc()) {
                            $resultados[] = $fila;
                        }
                    } else {
                        echo "Error en la consulta: " . $conex->error;
                    }
                }

            ?>

            <div class="mb-5">
                <h2 class="row justify-content-center my-3">
                    Buscar guía:
                </h2>
                <div class="d-flex justify-content-center">
                <form class="col-10 col-md-4 form-inline justify-content-center d-flex flex-row" method="post">
                    <input class="form-control mr-sm-2 me-3" type="search" placeholder="Escribe el número de guía" aria-label="Search" name="numeroGuia">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Buscar</button>
                </form>
                </div>
            </div>
            <?php
            if ($busquedaRealizada) {
                if (!empty($resultados)) {            
            ?>
                <div class="d-flex flex-column align-items-center mx-2 my-5">
                    <h2 class="mb-3">Detalle guía <?php echo htmlspecialchars($numeroGuia); ?>:</h2>
                    <div class="col-12 col-md-10 ">
                        <table class="table table-success table-hover ">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th scope="col" class="d-none d-md-table-cell">Guía</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Fecha despacho</th>
                                    <th scope="col" class="d-none d-md-table-cell">Fecha entrega</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($resultados as $fila): 
                            ?>
                                <tr class="text-center align-middle">
                                    <th scope="row" class="d-none d-md-table-cell"><?php echo htmlspecialchars($fila['numeroGuia']); ?></th>
                                    <td><span class="estado-circle <?php echo htmlspecialchars($fila['estadoEntrega']); ?>"></span><?php echo htmlspecialchars($fila['estadoEntrega']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['nombreCliente']); ?></td>
                                    <td><?php echo htmlspecialchars(formatearFechaEspañol($fila['fechaDespacho'])); ?></td>

                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars(formatearFechaEspañol($fila['fechaEntrega'])); ?></td>
                                    <td>
                                        <form action="detalle" method="post">
                                            <input type="hidden" name="idEntrega" value="<?php echo htmlspecialchars($fila['idEntrega']); ?>">
                                            <button type="submit" class="btn btn-primary">Ver</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div> 
            <?php
                } else {
                    echo '<div class="text-danger d-flex flex-column align-items-center mx-2 my-5"><h2 class="mb-3">No se encontró la guía ' . htmlspecialchars($numeroGuia) . '.</h2></div>';
                }
            }
            ?>
            <?php 
            if (isset($_SESSION['mensaje_estado'])) {
                echo '<div class="alert alert-success text-success text-center container">Estado actualizado</div>';
                unset($_SESSION['mensaje_estado']); // Limpiar el mensaje de la sesión después de mostrarlo
            }
            ?>

            <div class="d-flex flex-column align-items-center mx-2 my-5">
                <h2 class="my-3">Últimas pruebas agregadas:</h2>
                <div class="col-12 col-md-10 ">
                    <table class="table table-bordered table-hover ">
                        <thead>
                            <tr class="text-center align-middle">
                            <th scope="col" class="d-none d-md-table-cell">Guía</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha última prueba</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Fecha despacho</th>
                            <th scope="col" class="d-none d-md-table-cell">Fecha entrega</th>
                            <th scope="col"></th>                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($sql) {
                                    while ($datos = $sql->fetch_object()) {
                            ?>
                                <tr class="text-center align-middle">
                                    <th scope="row" class="d-none d-md-table-cell"><?php echo htmlspecialchars($datos->numeroGuia); ?></th>
                                    <td><span class="estado-circle <?php echo htmlspecialchars($datos->estadoEntrega); ?>"></span><?php echo htmlspecialchars($datos->estadoEntrega); ?></td>
                                    <td><?php echo htmlspecialchars(formatearFechaEspañol($datos->fechaCarga)); ?> <strong>Hora:</strong> <?php echo htmlspecialchars(date('H:i', strtotime($datos->fechaCarga))); ?></td>
                                    <td><?php echo htmlspecialchars($datos->nombreCliente); ?></td>
                                    <td><?php echo htmlspecialchars(formatearFechaEspañol($datos->fechaDespacho)); ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars(formatearFechaEspañol($datos->fechaEntrega, 'Aún no se entrega')); ?></td>
                                    <td>
                                        <form action="detalle" method="post">
                                            <input type="hidden" name="idEntrega" value="<?php echo htmlspecialchars($datos->idEntrega); ?>">
                                            <button type="submit" class="btn btn-primary">Ver</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php                                    
                            }
                                } else {
                                    echo "Error en la consulta: " . $conex->error;
                                }

                                // Cerrar la conexión, si es que ya no se necesita más adelante
                                $conex->close();
                            ?>                            
                        </tbody>
                        </table>
                    </table>
                </div>
            </div>
        </section>


    
    </main>

    <footer>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.swiper', {
                // Optional parameters
                direction: 'horizontal',
                loop: false,
                slidesPerView: 1,
                spaceBetween: 2,

                // If we need pagination
                pagination: {
                    el: '.swiper-pagination',
                },

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },

                // And if we need scrollbar
                scrollbar: {
                    el: '.swiper-scrollbar',
                },
                breakpoints: {
                    '768': {
                        slidesPerView: 3,
                    },
                    pagination: {
                        el: null,
                    },

                },
            });
        });
    </script>
    <script>
        var nombreUsuario = <?php echo json_encode($nombreUsuario); ?>;
    </script>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


</body>
</html>