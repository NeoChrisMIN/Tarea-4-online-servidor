<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Base de Datos con PHP y PDO</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
        integrity="sha384-
        PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpB
        fshb" crossorigin="anonymous">
    <!-- html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2pdf.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>

  <h2 class="d-flex justify-content-center align-items-center flex-column"> Datos de tabla de Entradas</h2>
  <!-- boton para imprimir en pdf -->
  <button class="btn btn-success mb-3" onclick="generarPDF()">Imprimir en PDF</button>

  <?php if ($parametros["correcto"]) : ?>
  <!-- Mostrar los datos -->
  <div class="table-responsive">
    <table id="tabla-listado" class="table table-bordered table-striped">
      <!-- Encabezados de la tabla -->
      <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>ID Usuario</th>
            <th>ID Categoría</th>
            <th>Título</th>
            <th>Imagen</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Operaciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Filas de la tabla con datos -->
        <?php foreach ($parametros["datos"] as $entrada) : ?>
          <tr>
            <td><?= $entrada['IDENT'] ?></td>
            <td><?= $entrada['IDUSUARIO'] ?></td>
            <td><?= $entrada['IDCATEGORIA'] ?></td>
            <td><?= $entrada['TITULO'] ?></td>
            <td><img src="imagenes/<?= $entrada['IMAGEN'] ?>" alt="Imagen de la entrada" width="50"></td>
            <td><?= $entrada['DESCRIPCION'] ?></td>
            <td><?= $entrada['FECHA'] ?></td>
            <td>
              <a href="../index.php?accion=editar_entrada_carga_datos&id=<?= $entrada['IDENT'] ?>">Editar</a> |
              <a href="../index.php?accion=eliminar_entrada&id=<?= $entrada['IDENT'] ?>">Eliminar</a> |
              <a href="../index.php?accion=detalle_entrada&id=<?= $entrada['IDENT'] ?>">Detalles</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Muestra la paginación -->
  <div class="d-flex justify-content-center">
    <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
      <a class="btn btn-primary mx-1" href="index.php?accion=listado&pagina=<?= $i ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>

  <?php else : ?>
    <!-- Mostrar mensaje de error -->
    <p class="alert alert-danger">Error al procesar la solicitud: <?= $parametros["error"] ?></p>
  <?php endif; ?>

  <script>
    function generarPDF() {
      var contenido = document.querySelector('#tabla-listado');

      html2pdf(contenido);
    }
  </script>

</body>

</html>