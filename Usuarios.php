<!--Se muestra el listado de los usuarios y en el que aquellos usuarios que tengan permiso podran añadir, modificarr o eliminar-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Usuarios</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;

        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            width: 160px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>

    <a href="formUsuario.php"> <input type="button" name="newUser" value="Crear nuevo usuario"></a>
    <?php

    $orderBy = array('id', 'nombre', 'email', 'ultimoAcceso');

    $order = 'nombre';
    if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
        $order = $_GET['orderBy'];
    }

    $query = 'SELECT * FROM user ORDER BY ' . $order;

    // retrieve and show the data :)

    ?>

    <table>
        <tr>
            <th><a href="Usuarios.php?orderBy = id">ID</a></th>
            <th><a href="Usuarios.php?orderBy = nombre">Nombre</a></th>
            <th><a href="Usuarios.php?orderBy = email">Email</a></th>
            <th><a href="Usuarios.php?orderBy = ultimoAcceso">Ultimo Acceso</a></th>
            <th>Enabled</th>
            <th>Borrar</th>
            <th>Modificar</a></th>
        </tr>
        <?php
        include "BaseDatos.php";

        session_start();

        if (isset($_POST['borrar'])) {
            borrarUser($_POST['id']);
        }

        $usuarios = getListaUser();

        foreach ($usuarios as $fila) {

        ?>
            <table>
                <tr>
                    <td><?php echo $fila["UserID"] ?></td>
                    <td><?php echo $fila["FullName"] ?></td>
                    <td><?php echo $fila["Email"] ?></td>
                    <td><?php echo $fila["LastAccess"] ?></td>
                    <td><?php echo $fila["Enabled"] ?></td>
                    <?php if ($fila["UserID"] != superAdmin()) {
                        if (1  == $_SESSION['id']) { ?>
                            <td>
                                <form action="formUsuario.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $fila["UserID"] ?>">
                                    <input type="submit" name="modificar" value="Modificar">
                                </form>
                            </td>
                        <?php } elseif (superAdmin() == $_SESSION['id']) { ?>
                            <td>
                                <form action="Usuarios.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $fila["UserID"] ?>">
                                    <input type="submit" name="borrar" value="Borrar">
                                </form>
                            </td>
                            <td>
                                <form action="formUsuario.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $fila["UserID"] ?>">
                                    <input type="submit" name="modificar" value="Modificar">
                                </form>
                            </td>
                <?php }
                    }
                } ?>
                </tr>
            </table>

</body>

</html>