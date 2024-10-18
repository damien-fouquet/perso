<?php

if (!isset($mysqlClient)) {
    global $mysqlClient;
    $mysqlClient = new PDO(
        'mysql:host=localhost;dbname=memory;charset=utf8',
        'root',
        ''
    );
}

class Card {
    private $idCard;
    private $recto;
    private $verso;
    private $isTurn = FALSE;
    private $isFind = FALSE;

    public function __construct($id) {
        $user = $GLOBALS["mysqlClient"]->prepare("SELECT * FROM cards WHERE id = :id LIMIT 1");
        $user->bindValue(":id", $id, PDO::PARAM_STR);
        $user->execute();
        $values = $user->fetchAll();
        $this->idCard = $values[0]["id"];
        $this->recto = $values[0]["recto"];
        $this->verso = $values[0]["verso"];
    }

    public function setIsTurn($newTurn) {
        $this->isTurn = $newTurn;
    }
    public function setIsFind($newFind) {
        $this->isFind = $newFind;
    }

    public function getIdCard() {
        return $this->idCard;
    }
    public function getIsTurn() {
        return $this->isTurn;
    }
    public function facePrint($pos) {
        $img = $this->isFind ? "'transparent.jpg' class='find'" : "'" . ($this->isTurn ? $this->recto : $this->verso) . "' class='imginverse'";
        echo "<form style='display:inline;'>
                <input type='hidden' name='pos' value='{$pos}'>
                <button type='submit' style='background:none;border:none;padding:0;cursor:pointer;'>
                    <img src=$img />
                </button>
              </form>";
        // return ($this->isFind ? "" : ($this->isTurn ? $this->recto : $this->verso));
    }
}

?>