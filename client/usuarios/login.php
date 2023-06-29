<?php
require_once('api.php');
include './header.php';

// Inicializar la variable $mensaje_error
$mensaje_error = "";
$miVariable = false;

// Si ya está abierta la sesión, redireccionar a inicio.php
if (isset($_SESSION['sesion_email'])) {
    header('Location: inicio.php');
    exit; // Asegúrate de usar exit después de la redirección
}
if (isset($_POST['cambiarValor'])) {
    // Cambiar el valor de $miVariable
    $miVariable = !$miVariable;
   if($miVariable){
        header('Location: register.php');
}
}
// Si se ingresa email y contraseña, conecta al servidor para validar y obtener token.
if (isset($_POST['login'])) {

    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        // Validar email y contraseña
        $data_array = array(
            "email" => $_POST['email'],
            "password" => $_POST['password']
        );
        $get_data = callAPI('POST', 'http://localhost:3000/auth', json_encode($data_array));
        // Si es válida, guardar usuario y token
        $data = json_decode($get_data, true);
        if ($data['errors']) { // Si hubo error, muestra el mensaje de error
            $mensaje_error = $data['errors'][0];
        } else { // Si fue exitosa, setea las variables locales sesion_usr y sesion_token y redirecciona a inicio.php
            $_SESSION['sesion_email'] = $_POST['email'];
            $_SESSION['sesion_token'] = $data['accessToken'];
            $_SESSION['sesion_refreshToken'] = $data['refreshToken'];

            header('Location: inicio.php');
            exit; // Asegúrate de usar exit después de la redirección
        }
    } 
    
    else {
        $mensaje_error = "Campos usuario y contraseña son requeridos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <div class="testbox">
        <form action="./login.php" method="POST">
            <div>
                <h1 style="color: black">Login</h1> <br><br>
            </div>
            <?php
            if (!empty($mensaje_error)) {
                echo '<p style="color: red">' . $mensaje_error . '</p>';
            }
            ?>
            <div class="item">
                <p>Email:</p>
                <div class="name-item">
                    <input type="text" name="email" placeholder="Ingrese email" />
                </div>
            </div>
            <div class="item">
                <p>Contraseña:</p>
                <div class="name-item">
                    <input type="password" name="password" placeholder="Ingrese su contraseña" />
                </div>
            </div>
            <input type="hidden" name="login" value="login" />
            <div>
                <button id="btnIngresar">Ingresar</button>
                <button id="btnReg"  name="cambiarValor">Registrar</button>

            </div>
        </form>
    </div>
</body>
</html>
