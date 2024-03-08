<?php

class modelo{

    // ------------ Contrustor ------------
    public function __construct() {
        $this->conectar();
      }

    // ------------ Conexión ------------
    private $conexion;
    // Parámetros de conexión a la base de datos 
    private $dbHost = "localhost";
    private $dbUser = "root";
    private $dbPass = "";
    private $dbName = "entorno_servidor_tarea_2";

    public function conectar() {
        try {
            $this->conexion = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo '<div class="alert ">' .
            "Se conecto correctamente!! :) <br/>" . '</div>';
            return TRUE;
        } catch (PDOException $ex) {
            echo '<div class="alert alert-danger">' .
            "No se pudo conectar a la BD de usuarios!! :( <br/>" . $ex->getMessage() . '</div>';
            return $ex->getMessage();
        }
    }

    /**
     * Función que nos permite conocer si estamos conectados o no a la base de datos.
     * Devuelve TRUE si se realizó correctamente y FALSE en caso contrario.
     * @return boolean
     */
    public function estaConectado() {
        if ($this->conexion) :
        return TRUE;
        else :
        return FALSE;
        endif;
    }

    
    // ------------ login ------------
    public function procesar_login(){
        require_once "includes/procesar_login.php";
    }
    
    public function datos_usuario(){
        $return = [
            "correcto" => FALSE,
            "id" => NULL,
            "usuario" => NULL,
            "rol" => NULL,
            "error" => NULL
        ];
        // Comprueba si se ha iniciado sesión, si no, inicia la sesión
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica si el usuario está logueado
        if (isset($_SESSION['usuario_id'])) {
            $return["correcto"] = TRUE;
            // Accede a la información del usuario
            $return["id"] = $_SESSION['usuario_id'];
            $return["usuario"] = $_SESSION['usuario_nick'];
            $return["rol"] = $_SESSION['usuario_rol'];
            
        }
        return $return;
    }
    
    // ------------ listado entradas ------------
    public function obtenerTotalRegistros() {
        try {
            $totalRegistros = $this->conexion->query("SELECT COUNT(*) FROM ENTRADAS")->fetchColumn();
            return $totalRegistros;
        } catch (PDOException $ex) {
            return FALSE;
        }
    }


    public function diferenciar_Rol(){ //diferencia el rol
        $datos_usuario = $this -> datos_usuario();
        if($datos_usuario["rol"] == "admin") return "admin";
        else return "user";
    }

    public function obtener_Todas_Entradas($inicio, $resultadosPorPagina) {
        $return = [
            "correcto" => FALSE,
            "datos" => NULL,
            "error" => NULL
        ];

        try {
            $query = $this->conexion->prepare("SELECT * FROM ENTRADAS ORDER BY IDENT DESC LIMIT :inicio, :resultadosPorPagina");
            $query->bindParam(':inicio', $inicio, PDO::PARAM_INT);
            $query->bindParam(':resultadosPorPagina', $resultadosPorPagina, PDO::PARAM_INT);
            $query->execute();

            if ($query->rowCount() > 0) {
                $return["correcto"] = TRUE;
                $return["datos"] = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $ex) {
            $return["error"] = $ex->getMessage();
        }

        return $return;
    }

    public function listadoPorUsuario() {
        $return = [
            "correcto" => FALSE,
            "datos" => NULL,
            "error" => NULL
        ];
        
        $datosUsuario = $this -> datos_usuario();
        $idUsuario = $datosUsuario["id"];
        try {
            $sql = "SELECT * FROM ENTRADAS WHERE IDUSUARIO = :idUsuario ORDER BY IDENT DESC";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $query->execute();
    
            if ($query) {
                $return["correcto"] = TRUE;
                $return["datos"] = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $ex) {
            $return["error"] = $ex->getMessage();
        }
    
        return $return;
    }
    // ------------ agregar entrada ------------

    public function agregar_entrada($datos){
        try {
            // Consulta para insertar la nueva entrada
            $conexion = $this->conexion;
            $query = $conexion->prepare("INSERT INTO ENTRADAS (IDUSUARIO, IDCATEGORIA, TITULO, IMAGEN, DESCRIPCION) VALUES (:idUsuario, :idCategoria, :titulo, :imagen, :descripcion)");
            $query->bindParam(':idUsuario', $datos["idUsuario"], PDO::PARAM_INT);
            $query->bindParam(':idCategoria', $datos["idCategoria"], PDO::PARAM_INT);
            $query->bindParam(':titulo', $datos["titulo"], PDO::PARAM_STR);
            $query->bindParam(':imagen', $datos["imagen"], PDO::PARAM_STR);
            $query->bindParam(':descripcion', $datos["descripcion"], PDO::PARAM_STR);
            $query->execute();

            // Redirige al usuario después de agregar la entrada
            header('Location: vistas/inicio.php');
            exit;
        } catch (PDOException $ex) {
            echo '<p class="alert alert-danger">Error al procesar la solicitud: ' . $ex->getMessage() . '</p>';
        }
    }

    // ------------ eliminar entrada ------------

    public function eliminar_entrada($idEntrada){
        try {

            // Consulta para obtener la información de la entrada antes de la eliminación
            $queryEntrada = $this->conexion->prepare("SELECT * FROM ENTRADAS WHERE IDENT = :id");
            $queryEntrada->bindParam(':id', $idEntrada, PDO::PARAM_INT);
            $queryEntrada->execute();
            $entrada = $queryEntrada->fetch(PDO::FETCH_ASSOC);
    
            // Elimina la entrada con el ID proporcionado
            $queryEliminar = $this->conexion->prepare("DELETE FROM ENTRADAS WHERE IDENT = :id");
            $queryEliminar->bindParam(':id', $idEntrada, PDO::PARAM_INT);
            $queryEliminar->execute();
    
            // Elimina la imagen asociada si existe
            if (!empty($entrada['IMAGEN'])) {
                $rutaImagen = 'imagenes/' . $entrada['IMAGEN'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }
    
            // Redirige al usuario después de la eliminación
            header('Location: ../index.php?accion=listado');
        } catch (PDOException $ex) {
            echo '<p class="alert alert-danger">Error al procesar la solicitud: ' . $ex->getMessage() . '</p>';
        }
    }

    public function detalle_entrada($idEntrada){
        try {
            // Consulta para obtener los detalles de la entrada con el ID proporcionado
            $queryEntrada = $this->conexion->prepare("SELECT * FROM ENTRADAS WHERE IDENT = :id");
            $queryEntrada->bindParam(':id', $idEntrada, PDO::PARAM_INT);
            $queryEntrada->execute();

            // Verifica si se encontraron resultados
            if ($queryEntrada->rowCount() > 0) {
                $entrada = $queryEntrada->fetch(PDO::FETCH_ASSOC);

                // Consulta para obtener los detalles del usuario asociado a la entrada
                $queryUsuario = $this->conexion->prepare("SELECT * FROM USUARIOS WHERE IDUSER = :idUsuario");
                $queryUsuario->bindParam(':idUsuario', $entrada['IDUSUARIO'], PDO::PARAM_INT);
                $queryUsuario->execute();
                $usuario = $queryUsuario->fetch(PDO::FETCH_ASSOC);

                // Consulta para obtener los detalles de la categoría asociada a la entrada
                $queryCategoria = $this->conexion->prepare("SELECT * FROM CATEGORIA WHERE IDCAT = :idCategoria");
                $queryCategoria->bindParam(':idCategoria', $entrada['IDCATEGORIA'], PDO::PARAM_INT);
                $queryCategoria->execute();
                $categoria = $queryCategoria->fetch(PDO::FETCH_ASSOC);

                require_once 'vistas/detalle_entrada.php';
            } else {
                echo '<p class="alert alert-info">No se encontró la entrada solicitada.</p>';
            }
        } catch (PDOException $ex) {
            echo '<p class="alert alert-danger">Error al procesar la solicitud: ' . $ex->getMessage() . '</p>';
        }
    }

    public function editar_entrada_carga_datos($idEntrada){
        try {
            // Verifica si se ha proporcionado un ID válido en la URL
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                // Filtra y sanitiza el ID de la entrada
                $idEntrada = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

                // Consulta para obtener los datos de la entrada con el ID proporcionado
                $query = $this->conexion->prepare("SELECT * FROM ENTRADAS WHERE IDENT = :idEntrada");
                $query->bindParam(':idEntrada', $idEntrada, PDO::PARAM_INT);
                $query->execute();
                $entrada = $query->fetch(PDO::FETCH_ASSOC);

                // Verifica si se encontraron resultados
                if ($query->rowCount() > 0) {
                    // Continúa con el código del formulario
                    require_once 'vistas/editar_entrada.php';
                } else {
                    // Si no se encontraron resultados, redirige a la página de inicio
                    echo '<p class="alert alert-info">No se encontró la entrada.</p>';
                    header("Location: vistas/inicio.php");
                    //exit;
                }
            } else {
                // Si no se proporcionó un ID válido, redirige a la página de listado de entradas
                echo '<p class="alert alert-warning">ID de entrada no válido.</p>';
                header('Location: ../listar_entradas.php');
                //exit;
            }
        } catch (PDOException $ex) {
            echo '<p class="alert alert-danger">Error al procesar la solicitud: ' . $ex->getMessage() . '</p>';
        }
    }


    public function editar_entrada_actualizar_datos($datos){
        try {
            // Prepara la consulta para actualizar la entrada
            $query = $this->conexion->prepare("UPDATE ENTRADAS SET IDUSUARIO = :idUsuario, IDCATEGORIA = :idCategoria, TITULO = :titulo, IMAGEN = :imagen, DESCRIPCION = :descripcion, FECHA = :fecha WHERE IDENT = :idEntrada");

            // Asigna los valores a los parámetros de la consulta
            $query->bindParam(':idUsuario', $datos['idUsuario'], PDO::PARAM_INT);
            $query->bindParam(':idCategoria', $datos['idCategoria'], PDO::PARAM_INT);
            $query->bindParam(':titulo', $datos['titulo'], PDO::PARAM_STR);
            $query->bindParam(':imagen', $datos['imagen'], PDO::PARAM_STR);
            $query->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
            $query->bindParam(':fecha', $datos['fecha'], PDO::PARAM_STR);
            $query->bindParam(':idEntrada', $datos['idEntrada'], PDO::PARAM_INT);

            // Mueve el archivo a la carpeta
            move_uploaded_file($datos['imagen_tmp'], 'imagenes/' . $datos['imagen']);

            // Ejecuta la consulta
            $query->execute();

            // Redirige después de la actualización
            header('Location: index.php?accion=listado');
            //exit;
        } catch (PDOException $ex) {
            echo '<p class="alert alert-danger">Error al procesar la solicitud: ' . $ex->getMessage() . '</p>';
        }
    }

}