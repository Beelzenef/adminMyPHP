<?php

    include_once "app.php";

    App::showHTMLHeader("Lista de reservas - EDUCA-TIC-A");
    App::showMenu();
    $app = new App();
    $app->validateSession();

    $app->getReservas();

    App::showHTMLFooter();
    
?>