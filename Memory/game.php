<?php

require_once("card.php");

if (isset($_GET["pairs"]) && ($_GET["pairs"] < 3 || $_GET["pairs"] > 12)) {
    header ("Location: index.php");
}

session_start();

if (isset($_GET["pairs"]) && !isset($_SESSION["totalPairs"])) {
    $_SESSION["totalPairs"] = $_GET["pairs"];
}

if (!isset($_SESSION["remainPairs"])) {
    $_SESSION["remainPairs"] = $_SESSION["totalPairs"];
}

if (!isset($_SESSION["score"])) {
    $_SESSION["score"] = 0;
}

if (!isset($_SESSION["points"])) {
    $_SESSION["points"] = 100;
}

if (!isset($_SESSION["posFlip"])) {
    $_SESSION["posFlip"] = [];
}

if (!isset($_SESSION["randCards"])) {
    $_SESSION["randCards"] = [];
    for ($i = 1; $i <= $_SESSION["totalPairs"]; $i++) {
        $_SESSION["randCards"][] = new Card($i);
        $_SESSION["randCards"][] = new Card($i);
    }
    shuffle($_SESSION["randCards"]);
}

function flipCard($card) {
    echo "cartes flip avant = " . count($_SESSION["posFlip"]);
    if ($card->getIsTurn())
        return;
    $card->setIsTurn(TRUE);
    $_SESSION["posFlip"][] = $card;
    echo "cartes flip après = " . count($_SESSION["posFlip"]);
    return;
}

function verifPair() {
    if ($_SESSION["posFlip"][0]->getIdCard() == $_SESSION["posFlip"][1]->getIdCard()) {
        $_SESSION["posFlip"][0]->setIsFind(TRUE);
        $_SESSION["posFlip"][1]->setIsFind(TRUE);
        $_SESSION["remainPairs"]--;
        $_SESSION["score"] += $_SESSION["points"];
        echo "Paire good<br/>";
    } else {
        $_SESSION["posFlip"][0]->setIsTurn(FALSE);
        $_SESSION["posFlip"][1]->setIsTurn(FALSE);
        if ($_SESSION["points"] > 10)
            $_SESSION["points"] -= 5;
        echo "Paire pas good<br/>";
    }
    $_SESSION["posFlip"] = [];
}

if (count($_SESSION["posFlip"]) == 2)
    verifPair();
else if (isset($_GET["pos"]) && count($_SESSION["posFlip"]) < 2)
    flipCard($_SESSION["randCards"][$_GET["pos"]]);

if (!$_SESSION["remainPairs"]) {
    $link = "Location: register.php?score=" . $_SESSION["score"];
    session_destroy();
    header($link);
}

?>

<html>

<head>
    <link href="game.css" media="all" rel="stylesheet" type="text/css" />
    <meta-charset="UTF-8" />
    <title>Memory</title>
</head>

<body>
    <strong>
        <h1 class="gameTitle">POKEFINDER
        <?php echo "<br/><br/>Il y a " . $_SESSION["totalPairs"] . " paires au total<br/>";
        echo($_SESSION["remainPairs"] . " paires sont encore à trouver<br/>");
        echo("<br/>Votre score actuel est de " . $_SESSION["score"] . "<br/><br/>"); ?></h1>
        <?php for ($i = 0; $i < $_SESSION["totalPairs"]; $i++) {?>
            <a href="game.php?pos=0" id="cardButon"><?php $_SESSION["randCards"][$i]->facePrint($i);?></a>
        <?php } ?></br>
        <?php for ($i = $_SESSION["totalPairs"]; $i < 2 * $_SESSION["totalPairs"]; $i++) {?>
            <a href="game.php?pos=0" id="cardButon"><?php $_SESSION["randCards"][$i]->facePrint($i);?></a>
        <?php } ?>
        <h1 class="gameTitle"><a href="leaderboard.php" id="leaderboardButon">LEADERBOARD</a></h1>
        <h1 class="gameTitle"><a href="index.php" id="indexButon">MENU</a></h1>
    </strong>
</body>

</html>