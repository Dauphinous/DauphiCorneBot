<?php
/**
 * Created by PhpStorm.
 * User: drest
 * Date: 04/07/18
 * Time: 13:24
 */

namespace Bot\utils;

require_once 'DauphiCorneBot/src/utils/configBD.php';


class User
{

    public static $allUsers = array();



    private static function isExist($idUser){
        if(User::$allUsers[$idUser] == null){
            return false;
        } else {
            $sql = ConfigBD::$bdd->prepare('SELECT * FROM personnes where user_id = :author');
            $sql->execute(array(':author'=>$idUser));

            $result = $sql->fetchAll();
            if(count($result) > 0){
                $allUsers[$idUser] = true;
                return true;
            } else {
                return false;
            }
        }
    }



    public static function createUser($idUser){
        echo "doit creer un user";
        if(!self::isExist($idUser)){
            echo "cree le user";
            $sql = ConfigBD::$bdd->prepare('INSERT INTO `personnes` (`user_id`, `argent`, `lastDaily`, `numberDaily`) VALUES (:author, "100",:date , 1);');
            $sql->execute(array(':author'=>$idUser, ':date'=>date("Y-m-d")));
            $sql = ConfigBD::$bdd->prepare('INSERT INTO `stats` (`stat_id`, `user_id`, `winPileOuFace`, `playPileOuFace`, `winRPS`, `egaliteRPS`, `playRPS`,
            `winQuestionQuizz`, `participationQuizz`) VALUES (NULL, :author, \'0\', \'0\', \'0\', \'0\', \'0\', \'0\', \'0\');');
            $sql->execute(array(':author'=>$idUser));
        }
    }

    public static function addMoney($idUser, $moneyAdd){
        $sql = ConfigBD::$bdd->prepare('SELECT argent FROM personnes where user_id = :author');
        $sql->execute(array(':author'=>$idUser));

        $result = $sql->fetchAll();
        $sql = ConfigBD::$bdd->prepare('UPDATE `personnes` SET `argent` = :argent WHERE `personnes`.`user_id` = :idUser;');
        $sql->execute(array(':argent'=>$moneyAdd+$result[0][0],":idUser"=>$idUser));
    }

    public static function getMoney($idUser){
        $sql = ConfigBD::$bdd->prepare('SELECT argent FROM personnes where user_id = :author');
        $sql->execute(array(':author'=>$idUser));
        $result = $sql->fetchAll();

        return $result[0][0];
    }
	public static function addDaily($idUser){
        $sql = ConfigBD::$bdd->prepare('SELECT numberDaily FROM personnes where user_id = :author');
        $sql->execute(array(':author'=>$idUser));

        $result = $sql->fetchAll();
        $sql = ConfigBD::$bdd->prepare('UPDATE `personnes` SET `numberDaily` = :numberDaily WHERE `personnes`.`user_id` = :idUser;');
        $sql->execute(array(':numberDaily'=>$moneyAdd+$result[0][0],":idUser"=>$idUser));
	}

}