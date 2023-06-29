
<?php
require_once( 'api.php');
include './header.php';
?>
<?php
if($_POST && isset( $_POST['metodo'])) {
            $metodo = $_POST['metodo'];
            if ($metodo == 'post') {   // Crear un nuevo usuario
               $data_array =  array(
                  "firstName" => $_POST['firstName'],
                  "lastName" => $_POST['lastName'],
                  "email" => $_POST['email'],
                  "password" => $_POST['password']
               );
               echo '<div>
                        <h1 style="color: black">POST usuario</h1><br><br>
                     </div>';
                  
               $get_data = callAPI( 'POST','http://localhost:3000/users', json_encode( $data_array ),false);
              
               header( 'Location: login.php' );
 
            }}
            ?>

<div class="testbox">
    
    <form action="./register.php" method="POST">
        <h1 style="color: black">Crear usuario</h1>
        <br><br>
        <div class="item">
            <p>Nombre:</p>
            <div class="name-item">
                <input type="text" name="firstName" placeholder="Ingrese nombre" />
            </div>
        </div>
        <div class="item">
            <p>Apellido:</p>
            <div class="name-item">
                <input type="text" name="lastName" placeholder="Ingrese apellido" />
            </div>
        </div>
        <div class="item">
            <p>Email:</p>
            <div class="name-item">
                <input type="text" name="email" placeholder="Ingrese email" />
            </div>
        </div>
        <div class="item">
            <p>Password:</p>
            <div class="name-item">
                <input type="password" name="password" placeholder="Ingrese contraseña" />
            </div>
        </div>
        <input type="hidden" name="metodo" value="post" />
        <div>
            <button id="btnGuardar" type="submit" onclick="location.href='./inicio.php'">Guardar</button>
            <button id="btnSalir" type="button" onclick="location.href='./inicio.php'">Salir</button>
        </div>
    </form>
</div>

<?php include './footer.html'; ?>