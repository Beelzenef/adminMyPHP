<?php

    include_once "app.php";

    App::showHTMLHeader("Lista de aulas - EDUCA-TIC-A");
    App::showMenu();
    $app = new App();
    $app->validateSession();

    // Alta reserva por horas

    App::showHTMLFooter();
    
?>