<!--El visitante introduce sus credenciales-->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Index</title>
</head>

<body>

    <form action="Index.php" method="post">
        <label>Usuario:</label><input type="text" id="user" name="user"><br><br>
        <label>Email:</label><input type="email" id="email" name="email"><br><br>
        <input type="submit" name="acceder">
    </form>

    <?php
    include "BaseDatos.php";

    if (isset($_POST['acceder'])) {

        checkUser($_POST['user'], $_POST['email']);
    }
    ?>


</body>

</html>