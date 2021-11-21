<!--Se almacena la conexion a la base de datos y todas las consultas-->

<?php

function conectarDb($database)
{
    $host = "localhost";
    $user = "root";
    $password = "";

    $conexion = mysqli_connect($host, $user, $password, $database);

    return $conexion;
}

function checkUser($usuario, $email)
{

    $DB = conectarDb("pac3_daw");

    $query =  mysqli_query($DB, "SELECT * FROM user WHERE FullName = '$usuario' AND Email = '$email'");

    $result = mysqli_fetch_assoc($query);

    if (isset($result)) {

        session_start();

        $userName = $result["FullName"];

        echo "<p>Bienvenido $userName pulsa <a href= Acceso.php>AQUI</a> para continuar</p>";

        $id = $result['UserID'];

        $ahora = date('Y-m-d');

        $query =  mysqli_query($DB, "UPDATE user SET LastAccess = '$ahora' WHERE UserID = $id");

        $idSQuery = mysqli_query($DB, "SELECT `UserID` FROM `user` WHERE FullName = '$usuario'");

        $idSesion = mysqli_fetch_assoc($idSQuery);

        $_SESSION['id'] = $idSesion['UserID'];

        $enableQuery = mysqli_query($DB, "SELECT `Enabled` FROM `user` WHERE FullName = '$usuario'");

        $enableSesion = mysqli_fetch_assoc($enableQuery);

        $_SESSION['enabled'] = $enableSesion['Enabled'];
    }
    mysqli_close($DB);
}


function superAdmin()
{
    $DB = conectarDb("pac3_daw");

    $querySA = mysqli_query($DB, "SELECT SuperAdmin FROM setup");

    $idSA = mysqli_fetch_assoc($querySA);

    return $idSA['SuperAdmin'];
}

/*function userAutorizado()
{

    $DB = conectarDb("pac3_daw");

    $id = $_SESSION['id'];

    $queryID = mysqli_query($DB, "SELECT Enabled FROM user WHERE UserID = $id");

    $autorizado = mysqli_fetch_assoc($queryID);

    return $autorizado['Enabled'];

    mysqli_close($DB);
}*/

function pintaAcceso()
{
    if (superAdmin() == $_SESSION['id']) {
        echo "<a href='Usuarios.php'><input type='button' name='usuarios' value='Usuarios'></a><br><br>";
    }
}

function getListaProductos($pagina)
{
    //conectamos con pac3_daw
    $DB = conectarDb("pac3_daw");
    //obtenemos los productos de la tabla productos
    $listaProductos = "SELECT p.ProductID, p.Name, p.Cost, p.Price, c.name FROM product p INNER JOIN category c ON p.CategoryID = c.CategoryID LIMIT " . (($pagina - 1) * 10)  . "," . 10;

    $resultado = mysqli_query($DB, $listaProductos);

    return $resultado;

    mysqli_close($DB);
}
/*
function mostrarProductosRegistrado()
{
    $productos = getListaProductos();
    
    echo "<table>\n
            <tr>\n
            <th>ID</th>\n
            <th>Categoria</th>\n
            <th>Nombre</th>\n
            <th>Coste</th>\n
            <th>Precio</th>\n
            <th>Manejo</th>\n
            </tr>\n";

    foreach ($productos as $fila) {
        echo "<tr>\n
        <td id= 'productID'>" . $fila["ProductID"] . "</td>\n
        <td id='categoria'>" . $fila["name"] . "</td>\n
        <td id='name'>" . $fila["Name"] . "</td>\n
        <td id='coste'>" . $fila["Cost"] . "</td>\n
        <td id='precio'>" . $fila["Price"] . "</td>\n";
        
        if (userAutorizado()  == $_SESSION['id']) {
            echo "<td>" . "<input type = 'submit' name='modificar' value= 'Modificar'>" . "</td>\n";
        } elseif (superAdmin() == $_SESSION['id']) {
            echo "<td>" . "<a href = formArticulos.php><input type = 'button' name='modificar' value= 'Modificar'> </a>" .
                "<input type = 'button' name='borrar' value= 'Borrar'>" .  "</td>\n";
        }

        if (userAutorizado()  == $_SESSION['id']) {
            echo "<td>" . "<a href = formArticulos.php><input type = 'button' name='modificar' value= 'Modificar'> </a>" . "</td>\n";
        } elseif (superAdmin() == $_SESSION['id']) {
            echo "<td>" . "<a href = formArticulos.php><input type = 'button' name='modificar' value= 'Modificar'> </a>" .
                "<input type = 'button' name='borrar' value= 'Borrar'>" .  "</td>\n";
        }

        echo "</tr>";
    }

    echo "</table>";
    
}
*/

function getListaUser()
{
    $DB = conectarDb("pac3_daw");

    $listaUser = "SELECT UserID, FullName, Email, LastAccess, Enabled FROM user";

    $resultado = mysqli_query($DB, $listaUser);

    return $resultado;

    mysqli_close($DB);
}

function mostrarUser()
{
    $usuarios = getListaUser();

    echo "<table>\n
            <tr>\n
            <th>ID</th>\n
            <th>Nombre</th>\n
            <th>Email</th>\n
            <th>Ultimo Acceso</th>\n
            <th>Enabled</th>\n
            </tr>\n";

    foreach ($usuarios as $fila) {
        echo "<tr>\n
        <td>" . $fila["UserID"] . "</td>\n
        <td>" . $fila["FullName"] . "</td>\n
        <td>" . $fila["Email"] . "</td>\n
        <td>" . $fila["LastAccess"] . "</td>\n
        <td>" . $fila["Enabled"] . "</td>\n               
        </tr>";
    }

    echo "</table>";
}

function getCat()
{

    $DB = conectarDb("pac3_daw");

    $listaCat = "SELECT CategoryID, Name FROM category";

    $resultado = mysqli_query($DB, $listaCat);

    if (mysqli_num_rows($resultado) > 0) {
        return $resultado;
    } else {
        echo "No hay nada en categorias.";
    }
    mysqli_close($DB);
}


function mostrarCat()
{
    $datosCat = getCat();

    /*foreach ($categoria as $fila) {
        echo "<option value ='" . $fila["CategoryID"] . "'>" . $fila["Name"] . "</option>";
    }*/
    while ($fila = mysqli_fetch_assoc($datosCat)) {

        echo "<option value ='" . $fila["CategoryID"] . "'>" . $fila["Name"] . "</option>";
    }
}

function categoriaDeProducto($id)
{

    $DB = conectarDb("pac3_daw");

    $query = mysqli_query($DB, "SELECT `CategoryID` FROM `product`WHERE ProductID = $id  ");

    $fila = mysqli_fetch_assoc($query);

    if (isset($fila)) {
        return $fila;
    } else {
        echo "No funciona categoriaDeProducto";
    }
    mysqli_close($DB);
}

function anadirArticulo($nombre, $coste, $precio, $categoria)
{
    $DB = conectarDb("pac3_daw");

    $anyadir = "INSERT INTO product (Name, Cost, Price, CategoryID)
            VALUES ('" . $nombre . " ','  " . $coste . " ','  " . $precio . "  ',' " . $categoria . " ')";

    $result = mysqli_query($DB, $anyadir);

    if ($result) {
        return "$result";
    } else {
        echo "Error en la funcion de añadirArticulo\n";
    }

    mysqli_close($DB);
}

function anadirUser($nombre, $password, $email, $ultimoAcceso, $permiso)
{
    $DB = conectarDb("pac3_daw");

    $anyadir = "INSERT INTO `user`(`FullName`,`Email`, `Password`, `LastAccess`, `Enabled`) VALUES ('$nombre', '$email','$password', '$ultimoAcceso', $permiso)";

    $result = mysqli_query($DB, $anyadir);

    if ($result) {
        return "$result";
    } else {
        echo "Error en la funcion de añadirUser\n";
    }

    mysqli_close($DB);
}

function borrar($id)
{
    $DB = conectarDb("pac3_daw");

    $query = mysqli_query($DB, "DELETE FROM `product` WHERE `ProductID`= ' " . $id . "'");



    if ($query) {
        return $query;
    } else {
        echo "Error en funcion borrar";
    }
    mysqli_close($DB);
}

function borrarUser($id)
{

    $DB = conectarDb("pac3_daw");

    $query = mysqli_query($DB, "DELETE FROM `user` WHERE `UserID`= '$id'");

    if ($query) {
        return $query;
    } else {
        echo "Error en funcion borrar";
    }
    mysqli_close($DB);
}

function getArticulo($id)
{

    $DB = conectarDb("pac3_daw");

    $query = "SELECT * FROM product WHERE ProductID = $id";

    $producto = mysqli_query($DB, $query);

    $result = mysqli_fetch_assoc($producto);

    if (isset($result)) {
        return $result;
    } else {
        echo "No funciona getArticulo";
    }
    mysqli_close($DB);
}

function getUser($id)
{

    $DB = conectarDb("pac3_daw");

    $query = "SELECT * FROM user WHERE UserID = $id";

    $user = mysqli_query($DB, $query);

    $result = mysqli_fetch_assoc($user);

    if (isset($result)) {
        return $result;
    } else {
        echo "No funciona getUser";
    }
    mysqli_close($DB);
}

function modificarArticulo($name, $cost, $price, $categoryID, $id)

{
    $DB = conectarDb("pac3_daw");

    $query = mysqli_query($DB, "UPDATE `product` SET `Name`= '$name',`Cost`= $cost,`Price`= $price,`CategoryID`= $categoryID WHERE `ProductID`= $id ");

    if ($query) {
        return $query;
    } else {
        echo "No funciona modificarArticulo";
    }
}

function modificaUsuario($fullname, $password, $email, $lastaccess, $enabled, $userid)
{

    $DB = conectarDb("pac3_daw");

    $query = mysqli_query($DB, "UPDATE `user` SET `FullName`= '$fullname',`Password`= '$password',`Email`= '$email',`LastAccess`= '$lastaccess', `Enabled` = '$enabled' 
    WHERE `UserID`= '$userid' ");

    if ($query) {
        return $query;
    } else {
        echo "Error en funcion modificaUsuario";
    }
}

function maxElementos()
{
    $DB = conectarDb('pac3_daw');

    $query = mysqli_query($DB, "SELECT count(*) as `ProductID` FROM `product`");

    $maxElementos = mysqli_fetch_assoc($query)['ProductID'];

    return $maxElementos;
}

?>