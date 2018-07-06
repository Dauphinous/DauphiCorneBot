<?php
/**
 * Created by PhpStorm.
 * User: Drest
 * Date: 06/07/2018
 * Time: 15:24
 */

namespace Bot\Module\Exception;

use Skinny\Network\Wrapper;

class ErrorMessage
{

    public static function createErrorCommandMessage($errorMessage, $command, $wrapper)
    {
        $embed = array(
            "color"=> 16661248,
            "author"=> [
                "name"=> "DauphiBotCorne",
            ],
            "title" => "Erreur dans le commande : " . $command,
            "description" => $errorMessage

        );
        $wrapper->Channel->sendMessage("", false, $embed);
    }
}