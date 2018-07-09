<?php
namespace Skinny\Network;

use Discord\Discord;
use Skinny\Core\Configure;
use Skinny\Message\Message;
use Skinny\Module\ModuleManager;
use Skinny\Network\Wrapper;
use Skinny\Utility\Command;
use Skinny\Utility\User;

class Server
{
    public $nbMessageErrorCommand = 23;
    public $allErrorCommandMessage = array(
        "Non mais t'es serieux ? Aller, tiens la bonne commande : ",
        "Tu m'a pris pour un Dauphin-garou ? Genre vraiment ? C'est pas simpas de te tromper de commande :'(",
        "MDRRRRRRRR et ça se dit membre du discord DauphiCorne ? Allez bleusaille, voici la bonne commande :",
        "Ca ce voit que la vampicorne est mieux que toi, elle se trompe jamais elle, voici sse qu'elle aurait écrit : ",
        "Miaou, ET BAH NON, voici la bonne commande miaou : ",
        "ET 1, ET 2, ET 3 fois que tu trompes, stop stp c'est relou :'(, la commande est simple pourtant : ",
        "Je suis trop gentil, je te donne la SEULE et unique bonne commande :p : ",
        "Aille aille aille, ouille, arrête t'essayer de m'envoyer de mauvaise commandes :'(",
        "Je suis mignon non ? Pour la peine, tiens la bonne commande :p : ",
        "Avoue, tu aimes te tromper de commandes pour avoir un petit message, je suis un genie :p",
        "Stop abuser, je suis gentil, je te fournit le help y tout mais tu te trompes, bruuuuuh :(",
        "Mystiiic est heureuse d'avoir developpé ce bot et vous ruinez ses efforts en vous trompant :( :",
        "Je dois le prendre comment ? Je me tue au travail et toi, tu fqis pqs l'effort de fqire cette commqnde correctement : ",
        "Est-ce qu'un bot a droit d'être amoureux hummm ? Oupsi, c'est pas le sujet XD, voici ta commande : ",
        "Bonjour, tu t'es trompe de numero ... enfin de commande, voici la bonne : ",
        "Un jour j'essaierai de te comprendre, en attendant, essaye de faire la bonne commande :p :",
        "Maiiiiis, je sais que j'écris comme un champignon mais theoriquement mon help est lisible, voici la bonne commande : :(",
        "Bande d'humain, heuresement que je suis la pour vous donner la bonne commande ... : ",
        "C'est là qu'on voit la difference entre vous et un Dauphin, on se trompe jamais, tiens, voici la commande : ",
        "MOUAHAHAHA, les commandes de Dieu sont impenetrables. Cependant, dans ma misericorde je vais t'en donner une : ",
        "OUUUUUIN, je pensais tout faire bien mais vous faites erreur, je ne sais pas coment m'améliorer ormi en te redonnant la commande : ",
        "*Attaque éclair*,  pikachuuuuuuuu : ",
        "Le monde n'est visiblement pas prêt pour moi, es-tu sûr de vouloir faire cette commande ?"
        );

    /**
     * The Discord instance.
     *
     * @var \Discord\Discord
     */
    public $Discord;

    /**
     * The Module Manager instance.
     *
     * @var \Skinny\Module\ModuleManager
     */
    public $ModuleManager;

    /**
     * Initialize the Bot and and the ModuleManager.
     */
    public function __construct()
    {
        Configure::checkTokenKey();
        $this->Discord = new Discord(Configure::read('Discord'));

        //Initialize the ModuleManager.
        $modulesPriorities = [];
        if (Configure::check('Modules.priority')) {
            $modulesPriorities = Configure::read('Modules.priority');
        }

        $this->ModuleManager = new ModuleManager($modulesPriorities);
    }

    /**
     * Handle the events.
     *
     * @return void
     */
    public function listen()
    {
        $this->Discord->on('ready', function ($discord) {
            $discord->on('message', function ($message) {
                if ($this->Discord->id === $message->author->id) {
                    return;
                }

                $content = Message::parse($message->content);
                $wrapper = Wrapper::getInstance()->setInstances($message, $this->ModuleManager);

                //Handle the type of the message.
                //Note : The order is very important !
                if ($wrapper->Channel->is_private === true) {
                    $this->ModuleManager->onPrivateMessage($wrapper, $content);
                } elseif ($content['commandCode'] === Configure::read('Command.prefix') &&
                            isset(Configure::read('Commands')[$content['command']])) {
                    $command = Configure::read('Commands')[$content['command']];

                    if ((isset($command['admin']) && $command['admin'] === true) &&
                            !User::hasPermission($wrapper->Message->author->id, Configure::read('Bot.admins'))) {
                        $wrapper->Message->reply('You are not administrator of the bot.');

                        return;
                    }

                    if (count($content['arguments']) < $command['params']) {
                        $embed = array(
                            "color"=> 3447003,
                            "author"=> [
                                "name"=> "DauphiBotCorne",
                            ],
                            "title" => $this->allErrorCommandMessage[rand(0,$this->nbMessageErrorCommand)],
                            "description" => Command::syntax($content),

                        );

                        $wrapper->Channel->sendMessage("", false,$embed);
                        return;
                    }

                    $this->ModuleManager->onCommandMessage($wrapper, $content);
                } else {
                    $this->ModuleManager->onChannelMessage($wrapper, $content);
                }
            });
        });
    }

    /**
     * Run the bot.
     *
     * @return void
     */
    public function startup()
    {
        $this->listen();

        $this->Discord->run();
    }
}
