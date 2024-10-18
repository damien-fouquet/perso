<?php

require_once("card.php");

$score = $_GET["score"] ?? 0;

// Fonction pour insérer le nouveau score
function fillLeaderboard($pseudo, $score)
{
    $pos = 0;
    $onLeader = FALSE;
    // On cherche la position où insérer le nouveau score
    while (!$onLeader && $pos < 10) {
        $pos++;
        $user = $GLOBALS["mysqlClient"]->prepare("SELECT * FROM leaderboard WHERE pos = :pos LIMIT 1");
        $user->bindValue(":pos", $pos, PDO::PARAM_STR);
        $user->execute();
        $values = $user->fetchAll();
        if ($values[0]["score"] < $score)
            $onLeader = TRUE;
    }
    // Si le nouveau score ne rentre pas dans le leaderboard on ne fait rien
    if (!$onLeader)
        return 0;
    // Si le nouveau score rentre dans le leaderboard on décale tous ceux qui sont en-dessous
    for ($j = 10; $j > $pos; $j--) {
        $user = $GLOBALS["mysqlClient"]->prepare("SELECT * FROM leaderboard WHERE pos = :j LIMIT 1");
        $user->bindValue(":j", $j - 1, PDO::PARAM_STR);
        $user->execute();
        $values = $user->fetchAll();
        $user = $GLOBALS["mysqlClient"]->prepare("UPDATE leaderboard SET pseudo = :pseudo,  score = :score WHERE pos = $j");
        $user->bindValue(":pseudo", $values[0]["pseudo"], PDO::PARAM_STR);
        $user->bindValue(":score", $values[0]["score"], PDO::PARAM_STR);
        $user->execute();
    }
    // On insère le nouveau score dans le leaderboard
    $user = $GLOBALS["mysqlClient"]->prepare("UPDATE leaderboard SET pseudo = :pseudo,  score = :score WHERE pos = $j");
    $user->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
    $user->bindValue(":score", $score, PDO::PARAM_STR);
    $user->execute();
    return 1;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'] ?? 'Anonymous';
    fillLeaderboard($pseudo, $score);
    header("Location: leaderboard.php");
}

?>

<html>

<head>
    <link href="register.css" media="all" rel="stylesheet" type="text/css" />
    <meta-charset="UTF-8" />
    <title>Memory</title>
</head>

<body>
    <strong>
        <h1 class="registerInfo">POKEFINDER</br></br>Félicitations ! Vous avez terminé la partie.</h1>
        <h2 class="registerInfo">Score : <?php echo $score ?>
        <form method="POST">
            <label for="pseudo">Entrez votre prénom (entre 2 et 5 caractères) :</label>
            <input type="text" id="pseudo" name="pseudo" required>
            <button type="submit">Sauvegarder le score</button>
        </form></h2>
        </br>
        <h1 class="registerInfo"><a href="leaderboard.php" id="leaderboardButon">LEADERBOARD</a></h1>
        <h1 class="registerInfo"><a href="index.php" id="indexButon">MENU</a></h1>
    </strong>
</body>

</html>