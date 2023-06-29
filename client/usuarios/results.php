
<?php 
   require_once( 'api.php');
   include './header.php';
   // Si no existe una sesion abierta, se redirecciona a login.
   if (!isset( $_SESSION['sesion_email'] )) {
      header( 'Location: login.php' );
  }  
?>
<!DOCTYPE html>
<html>
<head>

</head>
<div class="testbox">
    <?PHP
         $listar = false;
         $userCreado = false;
         $userEditado = false;
         $userBorrado= false;
       
         $header = 'Authorization: Bearer ' .  $_SESSION['sesion_token'];

         echo '<form>';
         if ($_GET && isset( $_GET['listar'])) { // Listar todos los usuarios
            echo '<div>
                     <h1 style="color: black">GET usuarios</h1><br><br>
                  </div>';
            $get_data = callAPI( 'GET','http://localhost:3000/users', false, $header );
             $listar = true;

         }
         else if ($_GET && isset( $_GET['id'])) { // Buscar un usuario por id
            echo '<div>
                    <h1 style="color: black">GET usuario</h1><br><br>
                   </div>';
            $id = intval( $_GET['id'] );
            $get_data = callAPI( 'GET','http://localhost:3000/users'.$id, false, $header );
         }
         else if($_POST && isset( $_POST['metodo'])) {
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
                  
               $get_data = callAPI( 'POST','http://localhost:3000/users', json_encode( $data_array ), $header);
               $userCreado = true;

            }
            else if ($metodo == 'put') { // Modificar datos de un usuario por id
               $id = $_POST['id'];
               $data_array =  array(
                  "id" => $_POST['id'],
                  "firstName" => $_POST['firstName'],
                  "lastName" => $_POST['lastName'],
                  "email" => $_POST['email'],
                  "password" => $_POST['password']
               );
               echo '<div>
                        <h1 style="color: black">PUT usuario</h1><br><br>
                     </div>';
               $get_data = callAPI( 'PUT','http://localhost:3000/users/'.$id , json_encode( $data_array ), $header);
               $userEditado = true;

            }
            else if ($metodo == 'del') { // Eliminar un usuario por id
               $id = $_POST['id'];
               echo '<div>
                        <h1 style="color: black">DELETE usuario</h1><br><br>
                     </div>';
               $get_data = callAPI( 'DEL','http://localhost:3000/users/'.$id, false, $header );
               $userBorrado= true;

            }
         }
         // Procesar el resultado.
         $data = json_decode( $get_data, true);
       //  print_r($data);

    
         echo '<div class="item">';
         echo '<p style="font-size: 20px">Respuesta servidor:</p><br>';
         echo '<div class="name-item" style="font-size: 18px">';

          // Si no fue error muesta la respuesta.
         
            $respuesta = $data;
            if (is_array($respuesta) || $respuesta instanceof Countable) {
               $cant = count($respuesta);
           } else {
               $cant = 0;
           }
            if ($userCreado === true) { // si es creado 
               echo '<td style="width: 10%; text-align: left; padding: 0.5em;">creado correctamente</td>';}
               else if ($userEditado === true) { // si es editado 
               echo '<td style="width: 10%; text-align: left; padding: 0.5em;">editado correctamente</td>';}
               else if ($userBorrado === true) { // si es borrado 
                  echo '<td style="width: 10%; text-align: left; padding: 0.5em;">borrado correctamente</td>';}
          
               else if ($listar === true) { // si es listado de usuario, los muestra en una tabla
            
                  //$cant = count( $respuesta );
                  echo '<span>Usuarios (' . $cant . ')</span>';
                  echo '<table style="width: 100%; border: 2px solid #2a5d84;">';
                  echo    '<tr style="text-align: left;">';
                  echo        '<th style="width: 10%;">Id</th>';
                  echo        '<th style="width: 50%;">Nombre</th>';
                  echo        '<th style="width: 40%;">Apellido</th>';
                  echo        '<th style="width: 40%;">Email</th>';
   
                  echo    '</tr>';
               
                  for ($i = 0; $i < $cant; $i++) {
                     echo "<tr>";
                     echo    '<td style="width: 10%; text-align: left; padding: 0.5em;">' . $respuesta[$i]['id'] . '</td>';
                     echo    '<td style="width: 50%; text-align: left; padding: 0.5em;">' . $respuesta[$i]['firstName'] . '</td>';
                     echo    '<td style="width: 40%; text-align: left; padding: 0.5em;">' . $respuesta[$i]['lastName'] . '</td>';
                     echo    '<td style="width: 40%; text-align: left; padding: 0.5em;">' . $respuesta[$i]['email'] . '</td>';
                     echo '<td><a href="bookInicio.php?userId=' . $respuesta[$i]['id'] . '">Agregar Libro</a></td>';

                     echo "</tr>";
                  }
                  echo '</table>';
               }
            
              
            echo '</div></div>';
            echo '<div>
                     <button id="btnSalir" type="button" onclick="location.href=\'./inicio.php?menu\'">Salir</button>
                  </div>';
            echo '</form>';


           
      ?>
          
</div>
</body>

<?php include './footer.html'; ?>

</html>

 