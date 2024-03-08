<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalles de Entrada</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!-- Referencia a la CDN de la hoja de estilos de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
        integrity="sha384-
        PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpB
        fshb" crossorigin="anonymous">
</head>

<body class="container mt-4">

    <div>
        <h2 class="mt-3 mb-3 d-flex justify-content-center align-items-center flex-column">Detalles de Entrada</h2>
        <h3>Información de Entrada:</h3>
        <p><strong>ID:</strong> <?php echo $entrada['IDENT']; ?></p>
        <p><strong>Título:</strong> <?php echo $entrada['TITULO']; ?></p>
        <p><strong>Descripción:</strong> <?php echo $entrada['DESCRIPCION']; ?></p>
        <p><strong>Fecha:</strong> <?php echo $entrada['FECHA']; ?></p>
        <div>
            <strong>Imagen:</strong>
            <img src="imagenes/<?php echo $entrada['IMAGEN']; ?>" alt="Imagen" style="max-width: 200px; height: auto;">
        </div>

        <h3>Información del Usuario:</h3>
        <p><strong>ID Usuario:</strong> <?php echo $usuario['IDUSER']; ?></p>
        <p><strong>Nick:</strong> <?php echo $usuario['NICK']; ?></p>
        <p><strong>Nombre:</strong> <?php echo $usuario['NOMBRE']; ?></p>
        <p><strong>Apellidos:</strong> <?php echo $usuario['APELLIDOS']; ?></p>
        <p><strong>Email:</strong> <?php echo $usuario['EMAIL']; ?></p>
        <p><strong>Rol:</strong> <?php echo $usuario['ROL']; ?></p>
        <div>
            <strong>Avatar:</strong>
            <img src="imagenes/<?php echo $usuario['AVATAR']; ?>" alt="Avatar" style="max-width: 200px; height: auto;">
        </div>

        <h3>Información de la Categoría:</h3>
        <p><strong>ID Categoría:</strong> <?php echo $categoria['IDCAT']; ?></p>
        <p><strong>Nombre de Categoría:</strong> <?php echo $categoria['NOMBRECAT']; ?></p>
    </div>

</body>

</html>