<!--Utilizado para crear, modificar o borrar un usuario-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>FormUser</title>
</head>

<body>
    <?php
    require "BaseDatos.php";
    if (isset($_POST['anyadir'])) {

        $nombre = $_POST['FullName'];
        $password = $_POST['Password'];
        $email = $_POST['Email'];
        $ultimoAcceso = $_POST['LastAccess'];
        $autorizado = $_POST['permiso'];


        if (anadirUser($nombre, $password, $email, $ultimoAcceso, $autorizado)) {
            echo "Se ha añadido un nuevo usuario";
        } else {
            echo "No se ha podido añadir el articulo";
        }
        echo "<a href='Usuarios.php'>Pulse para volver al listado de usuarios</a>";
    } elseif (isset($_POST['modificar'])) {

        $arrayDatos = getUser($_POST['id']);

    ?>

        <form action="formUsuario.php" method="post">
            <h2>Datos del usuario a modificar:</h2>
            <label>ID:</label>
            <input type="text" name="ID" value=<?php echo $arrayDatos['UserID']; ?>><br>
            <label>Nombre:</label>
            <input type="text" name="FullName" value="<?php echo $arrayDatos['FullName']; ?>"><br>
            <label>Contraseña:</label>
            <input type="password" name="Password" value="<?php echo $arrayDatos['Password']; ?>"><br>
            <label>Correo Electronico:</label>
            <input type="text" name="Email" value="<?php echo $arrayDatos['Email']; ?>"> <br>
            <label>Ultimo acceso</label>
            <input type="date" name="LastAccess" value="<?php echo $arrayDatos['LastAccess']; ?>"><br>
            <?php
            switch ($arrayDatos['Enabled']) {
                case 1:
                    echo "<label>Autorizado</label>";
                    echo "<input type='radio' id='Autorizado' name='permiso' value='1' checked><br>";
                    echo "<label>No Autorizado</label>";
                    echo "<input type='radio' id='NoAutorizado' name='permiso' value='0'><br>";
                    break;
                case 0:
                    echo "<label>Autorizado</label>";
                    echo "<input type='radio' id='Autorizado' name='permiso' value='1' ><br>";
                    echo "<label>No Autorizado</label>";
                    echo "<input type='radio' id='NoAutorizado' name='permiso' value='0' checked><br>";
            } ?>
            <input type="submit" name="modifica">
        </form>

    <?php } elseif (isset($_POST['modifica'])) {

        $userid = $_POST['ID'];
        $fullName = $_POST['FullName'];
        $password = $_POST['Password'];
        $email = $_POST['Email'];
        $lastAccess = $_POST['LastAccess'];
        $enabled = $_POST['permiso'];

        modificaUsuario($fullName, $password, $email, $lastAccess, $enabled, $userid);

        echo "Has modificado el usuario";
        echo "<a href='Usuarios.php'>Pulse para volver al listado de usuarios</a>";
    } else { ?>
        <h1>Se va a añadir un usuario nuevo</h1>
        <form action="formUsuario.php" method="post">

            <label>ID:</label>
            <input type="text" name="ID"><br>
            <label>Nombre:</label>
            <input type="text" name="FullName"><br>
            <label>Contraseña:</label>
            <input type="password" name="Password"><br>
            <label>Correo Electronico:</label>
            <input type="text" name="Email"><br>
            <label>Ultimo acceso</label>
            <input type="date" name="LastAccess"><br>
            <label>Autorizado</label>
            <input type="radio" id="Autorizado" name="permiso" value="1"><br>
            <label>No Autorizado</label>
            <input type="radio" id="NoAutorizado" name="permiso" value="0"><br>

            <input type="submit" name="anyadir">
        </form>

    <?php } ?>

</body>

</html>