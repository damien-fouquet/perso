<?php

session_start();
session_destroy();

?>

<html>

<head>
    <link href="index.css" media="all" rel="stylesheet" type="text/css" />
    <meta-charset="UTF-8" />
    <title>Memory</title>
</head>

<body>
    <strong>
        <h1 id="indexTitle">POKEFINDER</h1>
        <h2><form method="get" action="game.php">
            <label for="pairs">Entrez le nombre de paires (entre 3 et 6 paires) :</label>
            <input type="text" id="pairs" name="pairs" required>
            <button type="submit">Start Game</button>
        </form></h2>
    </strong>
</body>

</html>