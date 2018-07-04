<?php
/**
 * Created by PhpStorm.
 * User: drest
 * Date: 30/05/18
 * Time: 14:47
 */

namespace Bot\Module\Modules;

use Skinny\Module\ModuleInterface;
use Skinny\Module\Modules\ConfigBD;
use Skinny\Network\Wrapper;

echo 'PIKAAAAAAAAAAAAAAAAAAAAAAAA';


require_once 'src/Module/Modules/configBD.php';
require_once 'src/Module/User.php';

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
        $wrapper->Channel->sendMessage($wrapper->Message->author->username . "#" . $wrapper->Message->author->discriminator );
        switch ($message['command']) {
            case 'pika':

                $wrapper->Channel->sendMessage($message['parts'][1]);

                $author = $wrapper->Message->author->username . "#" . $wrapper->Message->author->discriminator ;
                User::createUser($author);
                break;
        }

    }
}


?>
