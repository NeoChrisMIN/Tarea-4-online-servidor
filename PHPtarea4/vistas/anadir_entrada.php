<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Añadir Entrada</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
        integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
        crossorigin="anonymous">
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
</head>

<body class="container mt-4">

    <h2 class="mb-4">Añadir Nueva Entrada</h2>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="idUsuario">ID Usuario:</label>
            <input type="number" class="form-control" name="idUsuario" required>
        </div>

        <div class="form-group">
            <label for="idCategoria">ID Categoría:</label>
            <input type="number" class="form-control" name="idCategoria" required>
        </div>

        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" class="form-control" name="titulo" required>
        </div>

        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="file" class="form-control-file" name="imagen">
        </div>
        
        <div class="form-group">
            <label for="descripcion2">Descripción:</label>
            <textarea class="form-control" id="descripcion2" name="descripcion2" rows="4"></textarea>
        </div>
        

        <button type="submit" class="btn btn-primary">Añadir Entrada</button>

        <div class="mt-3">
            <a href="inicio.php" class="btn btn-secondary">Volver al Menu de inicio</a>
        </div>
    </form>
    
    <script>
    ClassicEditor
        .create(document.querySelector('#descripcion2'))
        .catch(error => {
            console.error(error);
        });
    </script>
</body>

</html>