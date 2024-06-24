<?php
// Comprobamos cual es el personaje seleccionado
$id = $_GET['id'];

$url = 'https://rickandmortyapi.com/api/character/' . $id;
$data = file_get_contents($url);
$personaje = json_decode($data, true);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalles del Personaje</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ojuju:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="div1"></div>
    <div class="div2"></div>
    <header class="header">
        <div class="logo">
            <img src="img/rym.png" alt="Rick y Morty">
        </div>
        <div class="header-img">
            <img src="img/portalrick.png" alt="">
        </div>
    </header>

    <div class="container">
        <div class="tarjetaDiv">
            <div class="imgDiv">
                <img src="<?php print $personaje['image'] ?> " alt="<?php print $personaje['name'] ?>">
            </div>
            <div class="detallesDiv">
                <h3><?php print $personaje['name'] ?></h3>
                <p>Especie: <?php print $personaje['species'] ?></p>
                <p>Estado: <?php print $personaje['status'] ?></p>
                <p>Género: <?php print $personaje['gender'] ?></p>
                <p>Origen: <?php print $personaje['origin']['name'] ?></p>
                <p>Episodios: <?php print count($personaje['episode']) ?></p>
            </div>
        </div>
        <br>
        <a class="volver" href="index.php">Volver</a>
    </div>

</body>

</html>