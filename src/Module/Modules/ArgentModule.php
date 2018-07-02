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
        $wrapper->Channel->sendMessage($message['command']);
        switch ($message['command']) {
            case 'pika':
                $wrapper->Channel->sendMessage($message['parts'][1]);

                break;
        }

    }
}


?>