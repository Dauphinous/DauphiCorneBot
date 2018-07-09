<?php
/**
 * Created by PhpStorm.
 * User: Drest
 * Date: 06/07/2018
 * Time: 16:01
 */

namespace Bot\utils;

namespace Bot\utils;

require_once 'DauphiCorneBot/src/utils/configBD.php';

class Stats
{    public static function createStatUser($author){
        $sql = ConfigBD::$bdd->prepare("Select user_id from stats where user_id = :author");
        $sql->execute(array(':author'=>$author));
        $result = $sql->fetchAll();
        if(count($result) == 0){
            $sql = ConfigBD::$bdd->prepare("INSERT INTO `stats` (`user_id`, `winPileOuFace`, `playPileOuFace`, `winRPS`, `egaliteRPS`, `playRPS`, `winQuestionQuizz`, `participationQuizz`) VALUES (:author, '0', '0', '0', '0', '0', '0', '0');");
            $sql->execute(array(':author'=>$author));
            echo $sql->errorInfo()[2];
        }
    }

    public static function newPartyGame($nameGame, $author, $result){
        Stats::createStatUser($author);
        switch ($nameGame){
            case "rps" :
                Stats::rpsStat($author,$result);
                break;
            case "pf" :
                Stats::pfStat($author,$result);
                break;
        }
    }

    public static function rpsStat($author, $result){
        if($result == "victoire"){

            $sql = ConfigBD::$bdd->prepare('UPDATE stats SET winRPS=winRPS+1, playRPS=playRPS+1 where user_id = :author');
            $sql->execute(array(':author'=>$author));
        } else if ($result == "egalite"){
            $sql = ConfigBD::$bdd->prepare('UPDATE stats SET egaliteRPS=egaliteRPS+1, playRPS=playRPS+1 where user_id = :author');
            $sql->execute(array(':author'=>$author));
        } else {
            $sql = ConfigBD::$bdd->prepare('UPDATE stats SET playRPS=playRPS+1 where user_id = :author');
            $sql->execute(array(':author'=>$author));
        }
    }

    private static function pfStat($author, $result)
    {
        if($result == "victoire"){
            $sql = ConfigBD::$bdd->prepare('UPDATE stats SET winPileOuFace=winPileOuFace+1, playPileOuFace=playPileOuFace+1 where user_id = :author');
            $sql->execute(array(':author'=>$author));
        } else {
            $sql = ConfigBD::$bdd->prepare('UPDATE stats SET playPileOuFace=playPileOuFace+1 where user_id = :author');
            $sql->execute(array(':author'=>$author));
        }
    }
}