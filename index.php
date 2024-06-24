<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Index</title>
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
        <h1>Elige tu bando</h1>
        <form class="form" action="index.php" method="get">
            <div class="radioDiv">
                <div>
                    <input type="radio" name="raza" value="human">Humano
                </div>
                <div>
                    <input type="radio" name="raza" value="alien">Alienígena
                </div>
                <div>
                    <input type="radio" name="raza" value="all">Todos
                </div>
            </div>

            <input id="enviar" type="submit" name="btn" value="Wubalubadubdub">
        </form>

        <?php
        // Comprobamos si se ha seleccionado página, si no, es la primera
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Cogemos la URL en funcion del valor raza o se ha seleccionado todo
        if (isset($_GET['raza']) && $_GET['raza'] != 'all') {
            $url = 'https://rickandmortyapi.com/api/character/?species=' . $_GET['raza'] . '&page=' . $page;
        } else {
            $url = 'https://rickandmortyapi.com/api/character/?page=' . $page;
        }

        $data = file_get_contents($url);

        // Comprobamos si tenemos respuesta de la API
        if ($data === false) {
            echo "Error al obtener datos de la API.";
        }

        $personajes = json_decode($data, true);

        ?>

        <!-- Si se ha seleccionado raza y pulsado el botón, mostramos resultados -->
        <?php if (isset($_GET['btn']) && !empty($_GET['raza'])) : ?>
            <div id="personajes">
                <?php if (isset($personajes['results']) && is_array($personajes['results'])) : ?>
                    <!-- hacemos un bucle mostrando cada persona con su imagen y nombre -->
                    <?php foreach ($personajes['results'] as $personaje) : ?>
                        <div class="personaje">
                            <!-- al pulsar en el personaje nos lleva a su ficha individual -->
                            <a href="personaje.php?id=<?php print $personaje['id'] ?>">
                                <img src="<?php print $personaje['image'] ?>" alt="<?php print $personaje['name'] ?>">
                                <div class="titulo-personaje">
                                    <p class="titulos"><?php print $personaje['name'] ?></p>
                                    <p class="specie"><?php print $personaje['species'] ?> - <?php print $personaje['status'] ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No se encontraron personajes.</p>
                <?php endif; ?>
            <?php endif; ?>
            </div>
            <br><br>
            <!-- un div para la paginación, mostrando de 5 en 5 -->
            <div class="paginacion">
                <?php
                if (isset($_GET['btn']) && !empty($_GET['raza'])) {
                    // Calcular el rango de páginas a mostrar
                    $startPage = max(1, $page - 2);
                    $endPage = min($startPage + 4, $personajes['info']['pages']);

                    // Para ir a la primera página 
                    if ($page > 1) {
                        echo "<a href='" . $_SERVER['PHP_SELF'] . '?' . http_build_query(array_merge($_GET, ['page' => 1])) . "'>Primera </a>";
                    }
                    // Mostrar páginas de 5 en 5
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        if ($i == $page) {
                            echo "<span class='current-page'>$i</span>";
                        } else {
                            echo "<a href='" . $_SERVER['PHP_SELF'] . '?' . http_build_query(array_merge($_GET, ['page' => $i])) . "'>$i</a>";
                        }

                        // Agregar guión si no es la última página del rango
                        if ($i < $endPage) {
                            echo " - ";
                        }
                    }
                    // para ir a la última página
                    if ($page < $personajes['info']['pages']) {
                        echo "<a href='" . $_SERVER['PHP_SELF'] . '?' . http_build_query(array_merge($_GET, ['page' => $personajes['info']['pages']])) . "'> Última</a>";
                    }
                }
                ?>
            </div>
</body>

</html>