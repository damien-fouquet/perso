<?php

require_once("card.php");

// Fonction pour initialiser le leaderboard
function initLeaderboard()
{
    $GLOBALS["mysqlClient"]->query("DELETE from leaderboard");
    $GLOBALS["mysqlClient"]->query("INSERT INTO leaderboard VALUES (1, 'local', 800)");
    $GLOBALS["mysqlClient"]->query("INSERT INTO leaderboard VALUES (2, 'local', 700)");
    $GLOBALS["mysqlClient"]->query("INSERT INTO leaderboard VALUES (3, 'local', 600)");
    $GLOBALS["mysqlClient"]->query("INSERT INTO leaderboard VALUES (4, 'local', 500)");
    $GLOBALS["mysqlClient"]->query("INSERT INTO leaderboard VALUES (5, 'local', 400)");
    $GLOBALS["mysqlClient"]->query("INSERT INTO leaderboard VALUES (6, 'local', 300)");
    $GLOBALS["mysqlClient"]->query("INSERT INTO leaderboard VALUES (7, 'local', 250)");
    $GLOBALS["mysqlClient"]->query("INSERT INTO leaderboard VALUES (8, 'local', 200)");
    $GLOBALS["mysqlClient"]->query("INSERT INTO leaderboard VALUES (9, 'local', 150)");
    $GLOBALS["mysqlClient"]->query("INSERT INTO leaderboard VALUES (10, 'local', 120)");
}

// if (!$GLOBALS["mysqlClient"])
//     echo "L'accès PDO a fail<br/>";
// else
//     initLeaderboard();

?>

<html>

<head>
    <link href="leaderboard.css" media="all" rel="stylesheet" type="text/css" />
    <meta-charset="UTF-8" />
    <title>Memory</title>
</head>

<body>
    <strong>
        <h1 id="leaderTitle">LEADERBOARD</h1>
        <div class="leaderboard">
            <h1>
                <?php
                $user = $GLOBALS["mysqlClient"]->query("SELECT * FROM leaderboard");
                $values = $user->fetchall();
                echo "1. ", $values[0]["pseudo"], " ", $values[0]["score"], "<br/>";
                echo "2. ", $values[1]["pseudo"], " ", $values[1]["score"], "<br/>";
                echo "3. ", $values[2]["pseudo"], " ", $values[2]["score"], "<br/>";
                echo "4. ", $values[3]["pseudo"], " ", $values[3]["score"], "<br/>";
                echo "5. ", $values[4]["pseudo"], " ", $values[4]["score"], "<br/>";
                echo "6. ", $values[5]["pseudo"], " ", $values[5]["score"], "<br/>";
                echo "7. ", $values[6]["pseudo"], " ", $values[6]["score"], "<br/>";
                echo "8. ", $values[7]["pseudo"], " ", $values[7]["score"], "<br/>";
                echo "9. ", $values[8]["pseudo"], " ", $values[8]["score"], "<br/>";
                echo "10. ", $values[9]["pseudo"], " ", $values[9]["score"], "<br/>";
                ?>
            </h1>
        </div>
        <h1 class="leaderboard"><a href="index.php" id="indexButon">MENU</a></h1>
    </strong>
</body>

</html>