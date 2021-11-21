<!--Dependiendo del tipo de usuario, se muestra los accesos a los listados de articulos y de usuarios-->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Index</title>
</head>

<body>

    <a href="Articulos.php"><input type="button" name="articulos" value="Articulos"></a><br><br> <!--  Todos los usuarios  -->


    <?php
    include 'BaseDatos.php';
    session_start();

    pintaAcceso($_SESSION['id']);
    ?>
    <form action="">
        <a href="Index.php"><input type="button" name="volver" value="Volver"></a><br><br>
    </form>


</body>

</html>