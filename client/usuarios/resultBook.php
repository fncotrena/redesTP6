<?php
require_once('api.php');
include './header.php';

// Si no existe una sesión abierta, se redirecciona a login.
if (!isset($_SESSION['sesion_email'])) {
    header('Location: login.php');
    exit; // Asegúrate de agregar la instrucción 'exit' después de la redirección para detener la ejecución del resto del código.
}

$listarPath = false;
$userId = isset($_GET['userId']) ? $_GET['userId'] : null;

if (isset($_GET['listar'])) {
    $listarPath = $_GET['listar'];
}

$listar = false;
$userCreado = false;
$userEditado = false;
$userBorrado = false;

$header = 'Authorization: Bearer ' . $_SESSION['sesion_token'];

echo '<form>';
if ($listarPath) { // Listar todos los LIBROS
    echo '<div>
             <h1 style="color: black">GET libros</h1><br><br>
          </div>';
    $get_data = callAPI('GET', 'http://localhost:3000/users/' . $userId . '/books', false, $header);

    $listar = true;

} else if ($_POST && isset($_POST['metodo'])) {
    $metodo = $_POST['metodo'];
    if ($metodo == 'post') { // Crear un nuevo libro
        $data_array = array(
            "autor" => $_POST['autor'],
            "title" => $_POST['title'],
        );
        echo '<div>
                    <h1 style="color: black">POST libro</h1><br><br>
                 </div>';

        $get_data = callAPI('POST', 'http://localhost:3000/users/' . $userId . '/books', json_encode($data_array), $header);
        $userCreado = true;

    } else if ($metodo == 'put') { // Modificar datos de un usuario por id
        $idLibro = $_POST['idlibro'];
        $data_array = array(
            "autor" => $_POST['autor'],
            "title" => $_POST['title'],
        );
        echo '<div>
                    <h1 style="color: black">PUT libro</h1><br><br>
                 </div>';
        if (!isset($_POST['idlibro']) || empty($_POST['idlibro'])) {
            echo "Error: ID vacío. Por favor, ingrese un ID válido.";
            exit; // Termina la ejecución del script
        }

        $get_data = callAPI('PUT', 'http://localhost:3000/users/' . $userId . '/books/' . $idLibro, json_encode($data_array), $header);

        $userEditado = true;

    } else if ($metodo == 'del') { // Eliminar un usuario por id
        $id = $_POST['id'];
        echo '<div>
                    <h1 style="color: black">DELETE libro</h1><br><br>
                 </div>';
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            echo "Error: ID vacío. Por favor, ingrese un ID válido.";
            exit; // Termina la ejecución del script
        }
        $get_data = callAPI('DEL', 'http://localhost:3000/users/' . $userId . '/books/' . $id, false, $header);
        $userBorrado = true;
    } else if ($metodo == 'get') {
        echo '<div>
                <h1 style="color: black">GET LIBRO</h1><br><br>
               </div>';

        if (!isset($_POST['id']) || empty($_POST['id'])) {
            echo "Error: ID vacío. Por favor, ingrese un ID válido.";
            exit; // Termina la ejecución del script
        }

        $id = $_POST['id'];
        $get_data = callAPI('GET', 'http://localhost:3000/users/' . $userId . '/books/' . $id, false, $header);
        $listar = 'unico';
    }
}

// Procesar el resultado.
$data = json_decode($get_data, true);

echo '<div class="item">';
echo '<p style="font-size: 20px">Respuesta servidor:</p><br>';
echo '<div class="name-item" style="font-size: 18px">';

// Si no fue error muestra la respuesta.

$respuesta = $data;
if (is_array($respuesta) || $respuesta instanceof Countable) {
    $cant = count($respuesta);
} else {
    $cant = 0;
}
$error = false;
if (isset($respuesta['error'])) {
    $error = true;

    echo "Error: " . $respuesta['error'];
}
if ($userCreado === true && $error === false) { // si es creado 
    echo '<td style="width: 10%; text-align: left; padding: 0.5em;">creado correctamente</td>';
} else if ($userEditado === true && $error === false) { // si es editado 
    echo '<td style="width: 10%; text-align: left; padding: 0.5em;">editado correctamente</td>';
} else if ($userBorrado === true && $error === false) { // si es borrado 
    echo '<td style="width: 10%; text-align: left; padding: 0.5em;">borrado correctamente</td>';
} else if ($listar === true && $error === false) { // si es listado de usuario, los muestra en una tabla

    //$cant = count( $respuesta );
    echo '<span>LIBROS (' . $cant . ')</span>';
    echo '<table style="width: 100%; border: 2px solid #2a5d84;">';
    echo '<tr style="text-align: left;">';
    echo '<th style="width: 10%;">Id</th>';
    echo '<th style="width: 50%;">Nombre</th>';
    echo '<th style="width: 40%;">Autor</th>';

    echo '</tr>';

    for ($i = 0; $i < $cant; $i++) {
        echo "<tr>";
        echo '<td style="width: 10%; text-align: left; padding: 0.5em;">' . $respuesta[$i]['id'] . '</td>';
        echo '<td style="width: 50%; text-align: left; padding: 0.5em;">' . $respuesta[$i]['title'] . '</td>';
        echo '<td style="width: 40%; text-align: left; padding: 0.5em;">' . $respuesta[$i]['autor'] . '</td>';
        echo "</tr>";
    }
    echo '</table>';
} else if ($listar === 'unico' && $error === false) { // si es listado de usuario, los muestra en una tabla

    //$cant = count( $respuesta );
    echo '<span>LIBROS (' . 1 . ')</span>';
    echo '<table style="width: 100%; border: 2px solid #2a5d84;">';
    echo '<tr style="text-align: left;">';
    echo '<th style="width: 10%;">Id</th>';
    echo '<th style="width: 50%;">Nombre</th>';
    echo '<th style="width: 40%;">Autor</th>';

    echo '</tr>';

    echo "<tr>";
    echo '<td style="width: 10%; text-align: left; padding: 0.5em;">' . $respuesta['id'] . '</td>';
    echo '<td style="width: 50%; text-align: left; padding: 0.5em;">' . $respuesta['title'] . '</td>';
    echo '<td style="width: 40%; text-align: left; padding: 0.5em;">' . $respuesta['autor'] . '</td>';
    echo "</tr>";

    echo '</table>';
}

echo '</div></div>';
echo '<div>
<button id="btnSalir" type="button" onclick="history.back()">Salir</button>
      </div>';
echo '</form>';
?>

</div>
</body>

<?php include './footer.html'; ?>

</html>