<?php
include './header.php';
// Si no existe una sesion abierta, se redirecciona a login.
if (!isset($_SESSION['sesion_email'])) {
    header('Location: login.php');

}

if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $listar = 'listar';
}

?>
<div class="testbox">
    <?php

    // Buscar opcion por id, muestra formulario para ingresar el id.
    if ($_GET && isset($_GET['buscar'])) {
        echo '<form action="./resultBook.php?userId=' . $userId . '" method="POST">';
        echo '<div >
                    <h1 style="color: black">Borrar libro</h1> <br><br>
                  </div>';
        echo '<div class="item">
                    <p>Id:</p>
                    <div class="name-item">
                        <input type="text" name="id" placeholder="ingrese id"/>
                    </div>
                  </div>';
        echo '<input type="hidden" name="metodo" value="get"/>';
        echo '<div>
                    <button id="btnBuscar">Buscar</button>
                    <button id="btnSalir" type="button" onclick="history.back()">Salir</button>
                    </div>';
        echo '</form>';
    }
    // Crear un nuevo usuario: muestra el formulario para ingrese de nombre y apellido
    else if ($_GET && isset($_GET['nuevo'])) {
        echo '<form action="./resultBook.php?userId='. $userId .'" method="POST">';
        echo '<div>
                    <h1 style="color: black">Agregar Libro</h1><br><br>
                  </div>';
        echo '<div class="item">
                    <p>Nombre:</p>
                    <div class="name-item">
                        <input type="text" name="title" placeholder="ingrese nombre del libro"/>
                    </div>
                  </div>';
        echo '<div class="item">
                    <p>Autor:</p>
                    <div class="name-item">
                        <input type="text" name="autor" placeholder="ingrese autor" />
                    </div>
                  </div>';

        echo '<input type="hidden" name="metodo" value="post"/>';
        echo '<div>
                    <button id="btnGuardar">Guardar</button>
<button id="btnSalir" type="button" onclick="history.back()">Salir</button>
                 </div>';
        echo '</form>';
    }
    // modificar usuario: muestra el formulario para ingreso de id, y nombre a apellido a modificar.
    else if ($_GET && isset($_GET['modificar'])) {
        echo '<form action="./resultBook.php?userId=' . $userId . '" method="POST">';
        echo '<div>
                    <h1 style="color: black">Modificar datos de libro </h1><br><br>
                  </div>';
        echo '<div class="item">
                  <p>id del libro:</p>
                  <div class="name-item">
                      <input type="text" name="idlibro" placeholder="ingrese id del libro" />
                  </div>
                </div>';
        echo '<div class="item">
                  <p>Nombre:</p>
                  <div class="name-item">
                      <input type="text" name="title" placeholder="ingrese nombre del libro"/>
                  </div>
                </div>';
        echo '<div class="item">
                  <p>Autor:</p>
                  <div class="name-item">
                      <input type="text" name="autor" placeholder="ingrese autor" />
                  </div>
                </div>';

        echo '<input type="hidden" name="metodo" value="put"/>';
        echo '<div>
                    <button id="btnGuardar">Actualizar</button>
                    <button id="btnSalir" type="button" onclick="history.back()">Salir</button>
                    </div>';
        echo '</form>';
    }
    // Eliminar usuario: muestra formulario para ingreso de id de usuario a eliminar.
    else if ($_GET && isset($_GET['eliminar'])) {
        echo '<form action="./resultBook.php?userId=' . $userId . '" method="POST">';
        echo '<div >
                    <h1 style="color: black">Borrar libro</h1> <br><br>
                  </div>';
        echo '<div class="item">
                    <p>Id:</p>
                    <div class="name-item">
                        <input type="text" name="id" placeholder="ingrese id"/>
                    </div>
                  </div>';
        echo '<input type="hidden" name="metodo" value="del"/>';
        echo '<div>
                    <button id="btnEliminar">Eliminar</button>
                    <button id="btnSalir" type="button" onclick="history.back()">Salir</button>
                    </div>';
        echo '</form>';
    }
    // Muestra las operaciones disponibles para realizar con usuarios.
    else {
        echo '<form>';
        echo '<div>
                <h4>Libros</h4>
              </div>';
        echo '<ul>
                <li><a href="/usuarios/resultBook.php?userId=' . $userId . '&listar=' . $listar . '">Listar</a></li>
                <li><a href="/usuarios/bookInicio.php?userId=' . $userId . '&nuevo">Crear</a></li>
                <li><a href="/usuarios/bookInicio.php?userId=' . $userId . '&modificar">Modificar</a></li>
                <li><a href="/usuarios/bookInicio.php?userId=' . $userId . '&eliminar">Eliminar</a></li>
                <li><a href="/usuarios/bookInicio.php?userId=' . $userId . '&buscar">Buscar Por Id libro</a></li>

              </ul>';
        echo '</form>';
    }
    ?>.
</div>

</body>

<?php
include './footer.html';
?>