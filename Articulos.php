<!--Se muestra el listado de los articulos y en el que aquellos ususarios que tengan permiso podran añadir, modificarr o eliminar-->
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>Articulos</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            width: 150px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>





    <?php

    session_start();
    $db = mysqli_connect('localhost', 'root', '', 'pac3_daw');


    // Recogemos el parametro pag, en caso de que no exista, lo seteamos a 1
    if (isset($_GET['pag'])) {
        $pagina = $_GET['pag'];
    } else {
        $pagina = 1;
    }


    ?>
    <a href="formArticulos.php"> <input type="button" name="nuevoArticulo" value="Crear nuevo articulo"></a><br><br>

    <table>
        <tr>
            <th>ID</th>
            <th>Categoria</th>
            <th>Nombre</th>
            <th>Coste</th>
            <th>Precio</th>
            <th>Borrar</th>
            <th>Modificar</th>
        </tr>
        <?php
        include "BaseDatos.php";

        if (isset($_POST['borrar'])) {
            borrar($_POST['id']);
        }


        $productos = getListaProductos($pagina);

        foreach ($productos as $fila) {

        ?>
            <table>


                <tr>
                    <td><?php echo $fila["ProductID"] ?></td>
                    <td><?php echo $fila["name"] ?></td>
                    <td><?php echo $fila["Name"] ?></td>
                    <td><?php echo $fila["Cost"] ?></td>
                    <td><?php echo $fila["Price"] ?></td>
                    <?php if (1  == $_SESSION['enabled']) { ?>
                        <td>
                            <form action="formArticulos.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $fila["ProductID"] ?>">
                                <input type="submit" name="modificar" value="Modificar">

                            </form>
                        </td>
                    <?php } elseif (superAdmin() == $_SESSION['id']) { ?>
                        <td>
                            <form action="Articulos.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $fila["ProductID"] ?>">
                                <input type="submit" name="borrar" value="Borrar">
                            </form>
                        </td>
                        <td>
                            <form action="formArticulos.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $fila["ProductID"] ?>">
                                <input type="submit" name="modificar" value="Modificar">

                            </form>
                        </td>
                    <?php } ?>
                <?php } ?>
                </tr>
            </table>
            <br>
            <div>

                <?php

                if (isset($_GET['pag'])) {

                    if ($_GET['pag'] > 1) {
                ?>
                        <a href="Articulos.php?pag=<?php echo $_GET['pag'] - 1; ?>"><button>Anterior</button></a>
                    <?php

                    } else {
                    ?>
                        <a href="#"><button disabled>Anterior</button></a>
                    <?php
                    }
                    ?>

                <?php
                } else {

                ?>
                    <a href="#"><button disabled>Anterior</button></a>
                    <?php
                }


                $maxElementos = maxElementos();

                if (isset($_GET['pag'])) {

                    if ((($pagina) * 10) < $maxElementos) {
                    ?>
                        <a href="Articulos.php?pag=<?php echo $_GET['pag'] + 1; ?>"><button>Siguiente</button></a>
                    <?php

                    } else {
                    ?>
                        <a href="#"><button disabled>Siguiente</button></a>
                    <?php
                    }

                    ?>

                <?php

                } else {
                ?>
                    <a href="Articulos.php?pag=2"><button>Siguiente</button></a>
                <?php
                }


                ?>


            </div>

</body>

</html>