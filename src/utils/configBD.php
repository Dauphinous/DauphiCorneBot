<?php
/**
 * Created by PhpStorm.
 * User: drest
 * Date: 02/07/18
 * Time: 16:38
 */

namespace Bot\utils;

use Skinny\Module\ModuleInterface;
//use SkinnyModule\Module\ConfigBD;
use Skinny\Network\Wrapper;
use Bot\utils\ConfigBD;
use PDO;

class ConfigBD implements ModuleInterface {

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
/**
     * {@inheritDoc}
     *
     * @param \Skinny\Network\Wrapper $wrapper The Wrapper instance.
     * @param array $message The message array.
     *
     * @return void
     */
    public function onChannelMessage(Wrapper $wrapper, $message)
    {
    }

    /**
     * {@inheritDoc}
     *
     * @param \Skinny\Network\Wrapper $wrapper The Wrapper instance.
     * @param array $message The message array.
     *
     * @return void
     */
    public function onPrivateMessage(Wrapper $wrapper, $message)
    {
    }

    /**
     * {@inheritDoc}
     *
     * @param \Skinny\Network\Wrapper $wrapper The Wrapper instance.
     * @param array $message The message array.
     *
     * @return void
     */
    public function onCommandMessage(Wrapper $wrapper, $message)
    {

    }


}

?>
