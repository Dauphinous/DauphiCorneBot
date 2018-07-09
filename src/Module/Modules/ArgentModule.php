<?php
/**
 * Created by PhpStorm.
 * User: drest
 * Date: 30/05/18
 * Time: 14:47
 */

namespace Bot\Module\Modules;

use Skinny\Module\ModuleInterface;
use Skinny\Network\Wrapper;
use Bot\utils\configBD;
use Bot\utils\User;

echo 'PIKAAAAAAAAAAAAAAAAAAAAAAAA';
echo getcwd();

//require_once 'DauphiCorneBot/src/Module/Modules/configBD.php';
//require_once 'DauphiCorneBot/src/Module/Modules/User.php';

ConfigBD::initializeBD();

class ArgentModule implements ModuleInterface
{

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
        //$wrapper->Channel->sendMessage($wrapper->Message->author->username . "#" . $wrapper->Message->author->discriminator );
        switch ($message['command']) {
            case 'pika':

                $wrapper->Channel->sendMessage($message['parts'][1]);
    
                $author = $wrapper->Message->author->username . "#" . $wrapper->Message->author->discriminator ;
echo "JUSTE AVANT";                
User::createUser($author);
User::addMoney($author,25);
                break;
        }

    }
}


?>
