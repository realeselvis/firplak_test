    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>firplak</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">
    <header>
    </header>
    <main>
        <?php
        require "registrar.php";
        require_once("conexionMysql/conexion.php");
        $conex = ConectarDB();
        $sql = $conex->query("SELECT * FROM entregas WHERE idEntrega=1");

        ?>

        <!-- Button trigger modal -->
        <div class="text-center my-2">           
            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal">
                Agregar foto
            </button>
        </div>


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
                            <input type="hidden" name="idEntrega" value=1>
                            <input type="file" class="form-control mb-3" name="imagen">
                            <input type="submit" value="Registrar" name="btnregistrar2"  class="form-control btn btn-success">

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <footer>
    </footer>
<script>
    var nombreUsuario = <?php echo json_encode($nombreUsuario); ?>;
</script>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
