<?php
/**
 * Created by PhpStorm.
 * User: drest
 * Date: 02/07/18
 * Time: 16:38
 */
namespace Bot\Module\Modules;



class ConfigBD{

    private static $user = null;
    private static $pass = null;
    public static $dbh = null;

    public static function initializeBD()
    {
        $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
    }



}

?>
