<!--Utilizado para crear, modificar o borrar un producto-->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Index</title>
</head>

<body>



    <?php
    require "BaseDatos.php";

    if (isset($_POST['anyadir'])) {


        $nombre = $_POST["nombre"];
        $coste = $_POST["coste"];
        $precio = $_POST["precio"];
        $categoria = $_POST["categoria"];

        if (anadirArticulo($nombre, $coste, $precio, $categoria)) {
            echo "<h2>Se ha añadido el siguiente articulo:</h2>";
            echo "<p> $nombre a un precio de $precio € en la categoria  $categoria</p>";
        } else {
            echo "No ser ha podido añadir el articulo";
        }
        echo "<a href='Articulos.php'>Pulse para volver al listado de articulos</a>";
    } elseif (isset($_POST['modificar'])) {



        $arrayDatos = getArticulo($_POST['id']);

        //categoriaDeProducto($_POST['id']);

        $arrayProducto = categoriaDeProducto($_POST['id']);



    ?>
        <form action="formArticulos.php" method="POST">
            <h2>Modificar articulo:</h2>
            <label>ID:</label><input type="text" name="ID" value="<?php echo $arrayDatos['ProductID']; ?>"><br>
            <label>Categoria</label>
            <select name="categoria">
                <?php

                switch ($arrayProducto["CategoryID"]) {

                    case 1:
                        echo "<option value = 1 selected > Pantalon </option>";
                        echo "<option value = 2 >Camisa</option>";
                        echo "<option value = 3 >Jersey</option>";
                        echo "<option value = 4 >Chaqueta</option>";
                        break;

                    case 2:
                        echo "<option value = 1> Pantalon </option>";
                        echo "<option value = 2 selected>Camisa</option>";
                        echo "<option value = 3 >Jersey</option>";
                        echo "<option value = 4 >Chaqueta</option>";
                        break;
                    case 3:
                        echo "<option value = 1 > Pantalon </option>";
                        echo "<option value = 2 >Camisa</option>";
                        echo "<option value = 3 selected >Jersey</option>";
                        echo "<option value = 4 >Chaqueta</option>";
                        break;

                    case 4:
                        echo "<option value = 1  > Pantalon </option>";
                        echo "<option value = 2 >Camisa</option>";
                        echo "<option value = 3 >Jersey</option>";
                        echo "<option value = 4 selected>Chaqueta</option>";
                        break;
                } ?>

            </select><br>
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $arrayDatos['Name']; ?>"><br>
            <label>Coste:</label>
            <input type="number" name="coste" value="<?php echo $arrayDatos['Cost']; ?>"><br>
            <label>Precio:</label>
            <input type="number" name="precio" value="<?php echo $arrayDatos['Price']; ?>"><br>

            <input type="submit" name="modifica" value='Modificar'>
        </form>

    <?php } elseif (isset($_POST['modifica'])) {  ?>

        <?php
        $id  = $_POST['ID'];
        $nombre  = $_POST['nombre'];
        $categoria  = $_POST['categoria'];
        $coste  = $_POST['coste'];
        $precio  = $_POST['precio'];

        modificarArticulo($nombre, $coste, $precio, $categoria, $id);


        ?>

        <h2>Has modificado el articulo.</h2>

        <?php echo "<a href='Articulos.php'>Pulse para volver al listado de articulos</a>"; ?>


    <?php } else { ?>
        <form method="POST">
            <h2>Se va a añadir un nuevo articulo</h2>
            <label>ID:</label><input type="text" name="ID"><br>
            <label>Categoria</label>
            <select name="categoria">
                <?php mostrarCat(); ?>

            </select><br>
            <label>Nombre:</label>
            <input type="text" name="nombre"><br>
            <label>Coste:</label>
            <input type="number" name="coste"><br>
            <label>Precio:</label>
            <input type="number" name="precio"><br>

            <input type="submit" name="anyadir">
        </form>

    <?php } ?>


</body>

</html>