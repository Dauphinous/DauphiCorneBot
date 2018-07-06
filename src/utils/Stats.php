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
{
    public static function newPartyGame($nameGame, $author, $result){
        switch ($nameGame){
            case "rps" :
                $sql = ConfigBD::$bdd->prepare('INSERT INTO `personnes` (`user_id`, `argent`, `lastDaily`, `numberDaily`) VALUES (:author, "100",:date , 1);');
                $sql->execute(array(':author'=>$idUser, ':date'=>date("Y-m-d")));
                break;
        }
    }
}