<?php
session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>PHP/NodeJs - Usuarios</title>
        <link href="./stylesheets/all.css" rel="stylesheet" type="text/css" />
        <link href="./stylesheets/formstyle.css" rel="stylesheet" type="text/css" />
        <link href="/images/favicon.png" rel="icon" type="image/png" />
    </head>
    <body class="index">
        <div class="contain-to-grid">
            <nav class="top-bar" data-topbar>
              
            <ul class="left">
              <li class="name">
                <h1><a href="/usuarios/login.php">Administracion de Usuarios</a></h1>
              </li>
            </ul>

            <?php
              // Si se ingresa por la opcion de salir, se limpian las variables de sesion_usr y sesion_token, y se redirecciona a login.php.
              if ($_GET && isset( $_GET['logout'])) {
                  unset( $_SESSION['sesion_token']);
                  unset( $_SESSION['sesion_email']);
                  unset($_SESSION['sesion_refreshToken']);
                  echo '<section class="top-bar-section">
                  <ul class="right">
                    <li><a style="cursos:pointer;">Desconectado</a></li>
                  </ul>
                </section>';
                header( 'Location: login.php' );
              } 
              // Si el usuario esta logueado muestra usuario y opcion de salir de la sesion
              else if (isset( $_SESSION['sesion_email'] )) {
                  $usuario = $_SESSION['sesion_email'];
                  echo '<section class="top-bar-section">
                        <ul class="right">
                          <li><a style="cursos:pointer;">'.$usuario.'</a></li>
                          <li><a href="/usuarios/header.php?logout">Salir</a></li>
                        </ul>
                      </section>';
              }
              ?>
            </nav>
        </div>