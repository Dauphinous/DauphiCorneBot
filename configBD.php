<?php
/**
 * Created by PhpStorm.
 * User: drest
 * Date: 02/07/18
 * Time: 16:38
 */

namespace Bot\Module\Modules;



use PDO;

class ConfigBD{

    private static $user = null;
    private static $pass = null;
    public static $bdd = null;

    public static function initializeBD()
    {
        try{
            self::$bdd = new PDO('mysql:host=127.0.0.1;dbname=test;charset=utf8', 'root', '');
        }catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }

    }



}

?>
