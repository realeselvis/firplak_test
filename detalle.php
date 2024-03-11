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
    
    // Recupera idEntrega de la sesión si no está definido en POST
    if (isset($_POST['idEntrega'])) {
        $idEntrega = $_POST['idEntrega'];
    } elseif (isset($_SESSION['idEntrega'])) {
        $idEntrega = $_SESSION['idEntrega'];
        unset($_SESSION['idEntrega']); // Opcional: limpiar después de usar
    } else {
        // Manejar el caso de que no haya idEntrega disponible
        echo "Identificador de entrega no especificado.";
        exit; // O redirige según sea necesario
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
<style>
    /* Estilos para las flechas de navegación */
    .swiper-button-prev,
    .swiper-button-next {   
        display: none;
        /* Oculta las flechas de navegación de forma predeterminada */
    }
    @media (min-width: 768px) {
        .swiper-button-prev,
        .swiper-button-next {
        display: block;
        color: rgb(0, 174, 255);
        text-shadow: 0px 0px 3px rgba(255, 255, 255, 1), 0px 0px 6px rgba(255, 255, 255, 0.75), 0px 0px 9px rgba(255, 255, 255, 0.5), 0px 0px 12px rgba(255, 255, 255, 0.25);
        top: 50%;
        /* Centra verticalmente */
        /* transform: translateY(-50%); Ajusta p    ara alinear correctamente */
        }
    }
</style>
<body class="d-flex flex-column min-vh-100">
    <header>
    </header>
    <?php
        require_once 'funciones.php';
        require "registrar.php";
        require_once("conexionMysql/conexion.php");
        $conex = ConectarDB();

        // Verificar si $_POST['idEntrega'] está definido y no es vacío, o si $idEntrega está vacío o no definido
        if (isset($_POST['idEntrega']) && !empty($_POST['idEntrega'])) {
            $idEntrega = $_POST['idEntrega']; // Actualiza $idEntrega con el valor de POST si está presente y no es vacío
        } elseif (empty($idEntrega)) {
            echo "No se ha especificado una guía para mostrar.";
            return; // Detiene la ejecución si no hay un idEntrega válido disponible
        }

        $idEntregaLimpio = $conex->real_escape_string($idEntrega);

        $sql = $conex->query("SELECT * FROM entregas WHERE idEntrega='{$idEntregaLimpio}'");

        if ($sql && $sql->num_rows > 0) {
            $detallesEntrega = $sql->fetch_assoc();

            $sqlPruebas = $conex->query("SELECT * FROM pruebadeentrega WHERE idEntrega='{$idEntregaLimpio}'");

            $detallesPruebas = [];
            if ($sqlPruebas && $sqlPruebas->num_rows > 0) {
                while($detallesPrueba = $sqlPruebas->fetch_assoc()) {
                    $detallesPruebas[] = $detallesPrueba;
                }
            } else {
                // echo "No se encontraron pruebas para la guía especificada.";
            }

            $sqlNotas = $conex->query("SELECT * FROM notas WHERE idEntrega='{$idEntregaLimpio}' ORDER BY idNota DESC");
            
            $detallesNotas = []; // Inicializa el arreglo para notas
            if ($sqlNotas && $sqlNotas->num_rows > 0) {
                while($detalleNota = $sqlNotas->fetch_assoc()) {
                    $detallesNotas[] = $detalleNota;
                }
            } else {
                // echo "No se encontraron notas para la guía especificada.";
            }

            // Agrega aquí la consulta para obtener las imágenes.
            $sqlImagenes = $conex->query("SELECT * FROM pruebadeentrega WHERE idEntrega='{$idEntregaLimpio}'"); // Asegúrate de que la tabla y el campo sean correctos.
            $detallesImagenes = []; // Inicializa el arreglo para imagenes
            if ($sqlImagenes && $sqlImagenes->num_rows > 0) {
                while($fila = $sqlImagenes->fetch_assoc()) {
                    $detallesImagenes[] = $fila;
                }
            } else {
                // echo "No se encontraron notas para la guía especificada.";
            }

        } else {
            echo "No se encontraron detalles para la guía especificada.";
        }
    ?>



    <main class="flex-shrink-0">
        <!-- Sección tabla -->
        <?php
            if (!empty($detallesEntrega)) {            
        ?>
        <section class="container mb-5">
            <div class="bg-light border rounded px-2 shadow-sm">
                <h2 class="row justify-content-center my-3">
                    Detalle guía <?php echo htmlspecialchars($detallesEntrega['numeroGuia']); ?>:
                </h2>

                <div class="d-flex flex-column flex-md-row justify-content-center m-2">
                    <div class="sub-container-table d-flex flex-row flex-md-column bg-primary-subtle">
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><strong>Guía</strong></div>
                        <div class="p-2 d-flex w-100 w-md-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><?php echo htmlspecialchars($detallesEntrega['numeroGuia']); ?></div>
                    </div>
                    <div class="sub-container-table d-flex flex-row flex-md-column bg-primary-subtle">
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><strong>Cliente</strong></div>
                        <div class="p-2 d-flex w-100 w-md-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><?php echo htmlspecialchars($detallesEntrega['nombreCliente']); ?></div>
                    </div>  
                    <div class="sub-container-table d-flex flex-row flex-md-column bg-primary-subtle">
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><strong>Estado</strong></div>
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><span class="estado-circle <?php echo htmlspecialchars($detallesEntrega['estadoEntrega']); ?>"></span><?php echo htmlspecialchars($detallesEntrega['estadoEntrega']); ?></div>
                    </div>
                    <div class="sub-container-table d-flex flex-row flex-md-column bg-primary-subtle">
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><strong>Transportador</strong></div>
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center">Juantho Rois</div>
                    </div>
                    <div class="sub-container-table d-flex flex-row flex-md-column bg-primary-subtle">
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><strong>Fecha de despacho</strong></div>
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><?php echo htmlspecialchars(formatearFechaEspañol($detallesEntrega['fechaDespacho'])); ?></div>
                    </div>                
                    <div class="sub-container-table d-flex flex-row flex-md-column bg-primary-subtle">
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><strong>Fecha de entrega</strong></div>
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><?php echo htmlspecialchars(formatearFechaEspañol($detallesEntrega['fechaEntrega'])); ?></div>
                    </div>
                    <!-- <div class="sub-container-table d-flex flex-row flex-md-column bg-primary-subtle">
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><strong>Fecha entrega</strong></div>
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center">Aún no se entrega</div>
                    </div>  -->
                    <div class="sub-container-table d-flex flex-row flex-md-column bg-primary-subtle">
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center"><strong>Pruebas</strong></div>
                        <div class="p-2 d-flex w-100 border border-primary h-100 h-md-50 justify-content-center align-items-center">
                            <?php
                                if(isset($sqlPruebas) && $sqlPruebas->num_rows > 0) {
                                    echo $sqlPruebas->num_rows . " subidas";
                                } else {
                                    echo "Sin pruebas";
                                }
                            ?>
                        </div>
                    </div>
                              
                </div>

                

                <!-- Formulario cambiar estado de entrega -->
                <?php if ($rolUsuario === 'admin') { ?>
                    <form action="actualizar-estado.php" method="post">
                        <div class="d-flex flex-row justify-content-center aligns-items-center w-100">
                            <div class="form-floating col-md-6 me-3 my-2 mb-3 d-flex justify-content-center align-items-center">
                                <select class="form-select" name="estadoEntrega" id="floatingSelect" aria-label="Floating label select example">
                                    <option value="1">Creado</option>
                                    <option value="2">Despachado</option>
                                    <option value="3">Entregado</option>
                                    <option value="4">Revisado</option>
                                    <option value="5">Facturado</option>
                                </select>
                                <label for="floatingSelect">Cambiar estado:</label>
                            </div>

                            <input type="hidden" name="idEntregaLimpio" value="<?php echo $idEntregaLimpio; ?>">
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Cambiar</button>
                            </div>
                        </div>
                    </form>
                <?php } ?>

            </div>
        </section>
        <?php
            } else {
                echo '<div class="text-danger d-flex flex-column align-items-center mx-2 my-5"><h2 class="mb-3">No se encontró la guía ' . htmlspecialchars($numeroGuia) . '.</h2></div>';
            }        
        ?>
        <?php 
        if (isset($_SESSION['mensaje'])) {
            echo '<div class="alert alert-success text-success text-center container">NOTA AGREGADA EXITOSAMENTE</div>';
            unset($_SESSION['mensaje']); // Limpiar el mensaje de la sesión después de mostrarlo
        }
        ?>

        <!-- Sección imagenes -->
        <section class="images-section">
            <div class="container my-5">
                <div class="bg-light border rounded px-2 shadow-sm">
                    <?php  if ($sqlImagenes && $sqlImagenes->num_rows > 0) { ?>
                        <div>
                            <h2 class="row justify-content-center my-3">
                                Pruebas subidas
                            </h2>
                        </div>
                        <div class="swiper">
                        <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                <?php 
                                foreach ($detallesImagenes as $detalleImagen) {
                                ?>
                                    <div class="swiper-slide" style="padding: 20px;">
                                        <div class="swiper-image-container rounded">
                                            <img src="<?php echo htmlspecialchars($detalleImagen['ubicacionPrueba']); ?>" alt="firplak">
                                        </div>
                                    </div>
                                <?php 
                                }
                                ?>
                            </div>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination"></div>

                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                        <!-- Button trigger modal -->
                        <div class="text-center my-2">           
                            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Agregar foto
                            </button>
                        </div>
                    <?php } else { ?>                        
                        <div class='alert alert-danger text-center mt-3'><p class="mb-0">La guía <?php echo htmlspecialchars($detallesEntrega['numeroGuia']); ?> no tiene pruebas de entrega.</p>
                            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Agregar foto
                            </button>
                        </div>
                        
                    <?php } ?>
                </div>

                <!--AGREGAR IMAGENES/PRUEBAS -->
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered"> <!-- Añade aquí la clase modal-dialog-centered -->

                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar prueba</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" enctype="multipart/form-data" method="POST">
                                    <input type="hidden" name="idEntrega" value="<?php echo $idEntregaLimpio; ?>">
                                    <input type="file" class="form-control mb-3" name="imagen">
                                    <input type="submit" value="Registrar" name="btnregistrar2"  class="form-control btn btn-success">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>

        <!-- Sección notas -->
        <section class="container my-5">
            <div class="bg-light border rounded px-2 shadow-sm d-flex flex-column justify-content-center align-items-center">
                <h2 class="my-3">Notas:</h2>
                <!-- Contenedor de agrgar notas -->
                <div class="d-flex justify-content-center mt-2 w-100">
                    <form class="col-12 col-md-8 form-inline justify-content-center d-flex flex-row" action="script-notas.php" method="POST">
                        <input type="hidden" name="idEntrega" value="<?php echo htmlspecialchars($idEntrega); ?>">
                        <input class="form-control mr-sm-2 me-2" name="nota" type="search" placeholder="Escribe aquí una nota" aria-label="Search">
                        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Agregar nota</button>
                    </form>
                </div>

                <!-- Contenedor de notas anteriores -->
                <?php if (!empty($detallesNotas)) { ?>
                    <div class="container mb-4">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8 ">                
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item mt-4">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                Notas anteriores
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body bg-light p-3" style="max-height: 200px; overflow-y: auto;">
                                                <!-- Nota individual -->
                                                <?php 
                                                foreach ($detallesNotas as $detalleNota) {
                                                ?>
                                                    <div class="nota mb-2 bg-info-subtle p-2">                                                
                                                        <p class="mb-1"><strong>Fecha:</strong> <?php echo htmlspecialchars(formatearFechaEspañol($detalleNota['fechaHora'])); ?> <strong>Hora:</strong> <?php echo htmlspecialchars(date('H:i', strtotime($detalleNota['fechaHora']))); ?> <strong>Usuario:</strong> <?php echo htmlspecialchars($detalleNota['nombreUsuario']); ?></p>
                                                        <p><?php echo htmlspecialchars($detalleNota['nota']); ?></p>
                                                    </div>
                                                <?php 
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                    } else {
                        echo '<div class="text-danger alert alert-danger d-flex flex-column align-items-center mx-2 my-3"><p class="mb-0">No hay notas agregadas a la guía ' . htmlspecialchars($detallesEntrega['numeroGuia']) . '.</p></div>';

                    }                           
                ?>
            </div>
        </section>

    
    </main>

    <footer>
    </footer>
    <script>
        var nombreUsuario = <?php echo json_encode($nombreUsuario); ?>;
    </script>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>
</html>
