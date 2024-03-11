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
        <div class="mb-5">
            <h2 class="row justify-content-center my-3">
                Buscar guía:
            </h2>
            <div class="d-flex justify-content-center">
                <form class="col-10 col-md-4 form-inline justify-content-center d-flex flex-row">
                    <input class="form-control mr-sm-2 me-3" type="search" placeholder="Escribe el número de guía" aria-label="Search">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center my-5 container">
            <h2 class="my-3">Detalle guía 123456:</h2>

            <div class="col-12 col-md-10 ">
                <table class="table table-success table-hover ">
                    <thead>
                        <tr class="text-center align-middle">
                            <th scope="col" class="d-none d-md-table-cell">Guía</th>
                            <th scope="col">Estado Pruebas</th>
                            <th scope="col">Estado guía</th>
                            <th scope="col">Fecha modifcada</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Entrega estimada</th>
                            <th scope="col" class="d-none d-md-table-cell">Fecha entrega</th>
                            <th scope="col"></th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center align-middle">
                            <th scope="row" class="d-none d-md-table-cell">1</th>
                            <td><span class="estado-circle entregado"></span>Revisadas</td>
                            <td><span class="estado-circle entregado"></span>Entregada</td>
                            <td>09 de marzo 11:00 </td>
                            <td>Otto</td>
                            <td>16 de marzo</td>
                            <td class="d-none d-md-table-cell">Aún no se entrega</td>
                            <td><button type="button" class="btn btn-primary">Ver</button></td>
                        </tr> 
                        
                        <tr class="text-center align-middle">
                            <th scope="row" class="d-none d-md-table-cell">3</th>
                            <td><span class="estado-circle entrega-pendiente"></span>Revisión pendiente</td>
                            <td><span class="estado-circle entrega-pendiente"></span>Entrega pendiente</td>
                            <td>09 de marzo 11:00</td>
                            <td>Otto</td>
                            <td>03 de marzo</td>
                            <td class="d-none d-md-table-cell">03 de marzo</td>
                            <td><button type="button" class="btn btn-primary">Ver</button></td>     
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



        <!-- Sección últimas modificadas -->
        <section class="container my-5">
            <div class="d-flex flex-column align-items-center my-5">
                <h2 class="my-3">Últimas modificadas:</h2>
                <div class="col-12 col-md-10 ">
                    <table class="table table-bordered table-hover ">
                        <thead>
                            <tr class="text-center align-middle">
                            <th scope="col" class="d-none d-md-table-cell">Guía</th>
                            <th scope="col">Estado Pruebas</th>
                            <th scope="col">Estado guía</th>

                            <th scope="col">Fecha modifcada</th>

                            <th scope="col">Cliente</th>
                            <th scope="col">Entrega estimada</th>
                            <th scope="col" class="d-none d-md-table-cell">Fecha entrega</th>
                            <th scope="col"></th>                            
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center align-middle">
                            <th scope="row" class="d-none d-md-table-cell">1</th>
                            <td><span class="estado-circle entregado"></span>Revisadas</td>
                            <td><span class="estado-circle entregado"></span>Entregada</td>
                            <td>09 de marzo 11:00 </td>
                            <td>Otto</td>
                            <td>16 de marzo</td>
                            <td class="d-none d-md-table-cell">Aún no se entrega</td>
                            <td><button type="button" class="btn btn-primary">Ver</button></td>

                            <tr class="text-center align-middle">
                            <th scope="row" class="d-none d-md-table-cell">3</th>
                            <td><span class="estado-circle entrega-pendiente"></span>Revisión pendiente</td>
                            <td><span class="estado-circle entrega-pendiente"></span>Entrega pendiente</td>

                            <td>09 de marzo 11:00</td>
                            <td>Otto</td>
                            <td>03 de marzo</td>
                            <td class="d-none d-md-table-cell">03 de marzo</td>
                            <td><button type="button" class="btn btn-primary">Ver</button></td>

                            <tr class="text-center align-middle">
                            <th scope="row" class="d-none d-md-table-cell">2</th>
                            <td><span class="estado-circle pendiente-revisar"></span>Sin pruebas</td>
                            <td><span class="estado-circle pendiente-revisar"></span>Pendiente revisar</td>

                            <td>Sin modificación </td>
                            <td>Otto</td>
                            <td>16 de marzo</td>
                            <td class="d-none d-md-table-cell">Aún no se entrega</td>

                            <td><button type="button" class="btn btn-primary">Ver</button></td>                            
                            
                        </tbody>
                        </table>
                    </table>
                </div>
            </div>
        </section>


    </main>

    <footer>
    </footer>

    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>
</html>

<?php 

CREATE TABLE Entregas (
    idEntrega INT AUTO_INCREMENT PRIMARY KEY,
    idPedido INT NOT NULL,
    idDocumentoEntrega INT NOT NULL UNIQUE,
    idGuiaTransporte INT NOT NULL UNIQUE,
    numeroGuia INT NOT NULL,
    idCliente INT NOT NULL,
    nombreCliente VARCHAR(255) NOT NULL,
    fechaDespacho DATE NOT NULL,
    fechaEntrega DATE, 
    estadoEntrega ENUM ('Creado', 'Despachado', 'Entregado', 'Revisado', 'Facturado') NOT NULL,
    observaciones TEXT,
    // FOREIGN KEY (idCliente) REFERENCES Clientes(idCliente),
    // FOREIGN KEY (idPedido) REFERENCES Pedidos(idPedido),
    // FOREIGN KEY (idDocumentoEntrega) REFERENCES DocumentosEntrega(idDocumentoEntrega),
    // FOREIGN KEY (idGuiaTransporte) REFERENCES GuiasTransporte(idGuiaTransporte)
) ENGINE=InnoDB;


CREATE TABLE PruebaDeEntrega (
    idPruebaEntrega INT AUTO_INCREMENT PRIMARY KEY,
    idEntrega INT NOT NULL,
    ubicacionPrueba TEXT NOT NULL, -- URL o path del archivo
    fechaCarga TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha en que se cargó la prueba
    FOREIGN KEY (idEntrega) REFERENCES Entregas(idEntrega)
) ENGINE=InnoDB;

?>