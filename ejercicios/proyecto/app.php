<?php

    include_once "dao.php";
    class App {
        
        protected $dao;

        function __construct () {
            $this->dao = new DAO();
        }

        function getDAO() {
            return $this->dao;
        }
    
        // GESTION SESIONES

        function iniciarSesion ($usuario) {
            if (!isset($_SESSION['user']))
            {
                $_SESSION['user'] = $usuario;
            }
        }
        // Si no está logueado, redirigiendo al login!
        function validateSession() {
            session_start();
            if (!$this->isLogged())
            {
                $this->showLogin();
            }
            //$this->listarProductos();
        }

        // ¿Está logueado el usuario?
        function isLogged () {
            return isset($_SESSION['user']);
        }

        // Redirigiendo al login
        function showLogin() {
            echo "<script language=\"javascript\">window.location.href=\"login.php\"</script>";            
        }

        // Eliminando una sesión previamente creada
        function destroySession() {
            if (isset($_SESSION['user']))
            {
                unset($_SESSION['user']);
            }
            session_destroy();
            $this->showLogin();
        }
        
        // FUNCIONES PARA VISUALIZAR HTML
    
        static function showHTMLHeader ($titulo) {
            print "
            <!DOCTYPE html>
            <html lang=\"es\">
                <head>
                        <title>" .$titulo. "</title>
                        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
                     
                        <!-- CSS de Bootstrap -->
                        <link href=\"css/bootstrap.min.css\" rel=\"stylesheet\" media=\"screen\">
                </head>
                <body>
                <p>Con Bootstrap</p>
                <script src=\"http://code.jquery.com/jquery.js\"></script>
                <script src=\"js/bootstrap.min.js\"></script>
                ";
        }

        static function showMenu() {
            print "
            <nav class=\"navbar navbar-toggleable-md navbar-light bg-faded\">
            <a class=\"navbar-brand\">Gestión EDUCA-TIC-A</a>
          
            <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
            <ul class=\"navbar-nav mr-auto\">
                <li class=\"nav-item active\">
                    <a class=\"nav-link\" href=\"aulas.php\"/>Aulas</a>
                </li>
                <li class=\"nav-item active\">
                    <a class=\"nav-link\" href=\"reservas.php\"/>Reservas</a>
                </li>
                <li class=\"nav-item active\">
                    <a class=\"nav-link\" href=\"logout.php\"/>Cerrar sesión</a>
                </li>
              </ul>
            </div>
            </nav>
            
            </br></br>";
        }
        
        static function showHTMLFooter() {
            print "
            </body>
            </html>";
        }

        // CONSULTAS PARA AULAS

        static function nuevaAulaForm() {
            echo "
            <div class=\"modal-dialog\" role=\"document\">
            <div class=\"modal-content\">
              <div class=\"modal-header\">
                <h5 class=\"modal-title\">Añadiendo aulas</h5>
              </div>
            <form action=\"###\" method=\"post\">
            <div class=\"form-group\">
              <label for=\"nombre\">Nombre</label>
              <input type=\"text\" name=\"nombre\" required=\"required\" class=\"form-control\" id=\"nombre\" aria-describedby=\"nombre\" placeholder=\"Introduce nombre de aula\">
            </div>
            <button type=\"submit\" class=\"btn btn-primary\">Añadir aula</button>
          </form></div></div>";
          ;        
        }

        function addNuevaAula($nombreAula, $codeAula, $ubiAula, $ticAula, $pcsAula) {
            try {
                $aulas = $this->dao->addNuevaAula($nombreAula, $codeAula, $ubiAula, $ticAula, $pcsAula);
                echo "<p>¡Aula añadida!</p>";
            }
            catch (Exception $e)
            {
                echo "<p>Error en la consulta</p>";
            }
        }

        function deleteAula($id) {
            try {
                $aulas = $this->dao->deleteAula($id);
                echo "<p>¡Aula eliminada!</p>";
            }
            catch (Exception $e)
            {
                echo "<p>No ha sido posible eliminar...</p>";
            }
        }

        function getAulas() {
            try {

                $aulas = $this->dao->getAulas();

                if (count($aulas) > 0) {
                    echo "
                    <h1 class=\"text-center\"> Listado de aulas </h1>
                    <table class=\"table table-bordered table-striped\">";

                    echo "<thead class=\"thead-default\"> <tr> <th> ID </th> <th> Nombre </th> <th> Codigo </th> <th> Ubicacion </th> <th> TIC </th> <th> Reservar </th> <th> Eliminar aula </th></tr> </thead>";

                    foreach ($aulas as $item) {
                        echo "<tr> <td> " .$item['id']. "</td>";
                        echo "<td> " .$item['nombre']. "</td>";
                        echo "<td> " .$item['codigo']. "</td>";
                        echo "<td> " .$item['ubicacion']. "</td>";
                        echo "<td> " .$item['tic']. "</td>";
                        echo "<td> <a href=\"altaReserva.php?idAula=" .$item['id']. "\"> <img src=\"https://flow.microsoft.com/Content/retail/assets/button.619efbb4f46aceff2c9b7df7c0630a57.2.svg\"/> </a>";
                        echo "<td> <a href=\"delete_aula.php?idAula=" .$item['id']. "\"> <img src=\"https://static.independent.co.uk/static-assets/close-video-preroll.svg\"/> </a> </tr>";                            
                    }

                    echo "</table>";
                    echo "<a href=\"add_aula.php\" class=\"btn btn-primary btn-lg\" role=\"button\">Añadir nueva aula</a>";                    }
            }
            catch (Exception $e)
            {
                echo "<p>Error en la consulta</p>";
            }
        }

        // CONSULTAS PARA RESERVAS

        // Funciones que faltan:
        // * Alta de reserva por dias
        // * Alta de reserva por horas
        // * Formulario de reserva, con combobox para elegir horas/dias de reserva (no se permiten más de 4)
        // * Listado de reservas realizadas, con control de valores NULL
        // * Eliminar reserva

        function getReservas() {
            
        }

        // CONSULTAS PARA USUARIOS

        static function showRegisterForm() {
            echo "
                <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                      <div class=\"modal-header\">
                        <h5 class=\"modal-title\">Registro</h5>
                      </div>
                    <form action=\"add_user.php\" method=\"post\">
                    <div class=\"form-group\">
                      <label for=\"username\">Nombre de usuario</label>
                      <input type=\"text\" name=\"username\" required=\"required\" class=\"form-control\" id=\"username\" aria-describedby=\"username\" placeholder=\"Usuario\">
                      <label for=\"password\">Contraseña</label>
                      <input type=\"text\" name=\"password\" required=\"required\" class=\"form-control\" id=\"password\" aria-describedby=\"password\" placeholder=\"Contraseña\">
                      <label for=\"password\">Nombre y apellidos</label>
                      <input type=\"text\" name=\"password\" required=\"required\" class=\"form-control\" id=\"nombre\" aria-describedby=\"nombre\" placeholder=\"Nombre y apellidos\">
                      <label for=\"fechanacimiento\">Fecha de nacimiento</label>
                      <input type=\"text\" name=\"fechanacimiento\" required=\"required\" class=\"form-control\" id=\"fechanacimiento\" aria-describedby=\"fechanacimiento\" placeholder=\"Fecha de nacimiento\">
                      <label for=\"email\">Email</label>
                      <input type=\"text\" name=\"email\" required=\"required\" class=\"form-control\" id=\"email\" aria-describedby=\"email\" placeholder=\"Email\">
                    </div>
                    <button type=\"submit\" class=\"btn btn-primary\">Confirmar registro</button>
                  </form></div></div>";
                  ;        
                }
            
        // FUNCIONES GENERALES

        static function confirmationDialog($tipoItem, $id) {
            
            echo "
            <div class=\"modal-dialog\" role=\"document\">
              <div class=\"modal-content\">
                <div class=\"modal-header\">
                  <h5 class=\"modal-title\">Eliminar " .$tipoItem. "</h5>
                </div>
                <div class=\"modal-body\">
                  <p>El botón de confirmar eliminará el/la " .$tipoItem. " de la base de datos.
                  Obviamente esta acción no puede deshacerse.</p>
                </div>
                <div class=\"modal-footer\">
                  <a class=\"nav-link\" href=\"delete_confirm.php?id=" .$id. "\">
                    <button type=\"button\" class=\"btn btn-primary\">Eliminar</button>
                  </a>
                  <a class=\"nav-link\" href=\"aulas.php\"/>
                    <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancelar</button>
                  </a>
                </div>
              </div>
            </div>";
        }
    
    
    }
?>