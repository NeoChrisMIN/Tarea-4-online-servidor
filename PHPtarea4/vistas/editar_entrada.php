<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Entrada</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!-- Referencia a la CDN de la hoja de estilos de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
        integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h2 class="mt-3 mb-3 d-flex justify-content-center align-items-center flex-column">Editar Entrada</h2>

        <!-- Formulario para editar la entrada -->
        <form action="index.php?accion=editar_entrada_actualizar_datos" method="post" enctype="multipart/form-data">

            <!-- Campo oculto para el ID de la entrada -->
            <input type="hidden" name="idEntrada" value="<?php echo $entrada['IDENT']; ?>">

            <!-- Campos del formulario -->
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $entrada['TITULO']; ?>">
            </div>

            <div class="form-group">
                <label for="idUsuario">ID Usuario:</label>
                <input type="text" class="form-control" id="idUsuario" name="idUsuario" value="<?php echo $entrada['IDUSUARIO']; ?>">
            </div>

            <div class="form-group">
                <label for="idCategoria">ID Categoría:</label>
                <input type="text" class="form-control" id="idCategoria" name="idCategoria" value="<?php echo $entrada['IDCATEGORIA']; ?>">
            </div>

            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen" >
                <p class="mt-2">Imagen actual: <?php echo $entrada['IMAGEN']; ?></p>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" style="width: 100%; min-height: 100px; max-height: 300px;"><?= $entrada['DESCRIPCION']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="datetime-local" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d\TH:i', strtotime($entrada['FECHA'])); ?>">
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>

    <script>
    ClassicEditor
        .create(document.querySelector('#descripcion'))
        .catch(error => {
            console.error(error);
        });
    </script>
</body>

</html>