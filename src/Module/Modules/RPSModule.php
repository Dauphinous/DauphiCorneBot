<?php
/**
 * Created by PhpStorm.
 * User: Drest
 * Date: 06/07/2018
 * Time: 13:45
 */

namespace Bot\Module\Modules;

use Bot\utils\Stats;
use Skinny\Module\ModuleInterface;
use Skinny\Network\Wrapper;
use Bot\utils\User;
use Bot\Module\Exception\ErrorMessage;

class RPSModule implements ModuleInterface
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
        switch ($message['command']) {
            case 'rps':
                $params = explode(' ', $message['parts'][1]);
                $params[0] = strtolower($params[0]);
                if($params[0] === "pierre" || $params[0] === "papier" || $params[0] === "ciseaux"){
                    $author = $wrapper->Message->author->username . "#" . $wrapper->Message->author->discriminator;
                    $moneyUser = User::getMoney($author);
                    if($moneyUser - $params[1] > 0){
                        $wrapper->Channel->sendMessage("",false, $this->rps($params[0], $params[1], $author));
                    } else { // Pas assez d'argent
                        ErrorMessage::createErrorGameMessage($moneyUser, $wrapper);
                    }
                } else {
                    ErrorMessage::createErrorCommandMessage("Votre arme n'existe pas, veuillez choisir Pierre , Papier ou Ciseaux", "rps", $wrapper);
                }

            break;
        }

    }

    private function rps($weaponJoueur, $nbDauphiCoins, $author){
        $weapons = array("papier" => 0, "pierre" => 1, "ciseaux" => 2);
        $weaponsEnnemi = array("papier", "pierre", "ciseaux");
        $botWeapon = rand(0,2);
        $embed = null;
        if($weapons[$weaponJoueur] == $botWeapon){ // egalite
            $embed = array(
                "color"=> 14264613,
                "author"=> [
                    "name"=> "DauphiBotCorne",
                ],
                "title" => "Jeu de pierre-papier-ciseaux pour " . $nbDauphiCoins,
                "description" => "Je joue aussi " . $weaponJoueur . " donc je te rends tes DauphiCoins et tu gagnes rien, sorry :/"

            );
            Stats::newPartyGame("rps", $author, "egalite");
        } else if($weapons[$weaponJoueur] == ($botWeapon+1)%3){ // defaite
            $embed = array(
                "color"=> 7478274,
                "author"=> [
                    "name"=> "DauphiBotCorne",
                ],
                "title" => "Jeu de pierre-papier-ciseaux pour " . $nbDauphiCoins,
                "description" => "Je joue " . $weaponsEnnemi[$botWeapon] . " donc je gagne MOUAHAHAHA, à moi tes DauphiCoins (meme s'ils m'appartenaient déjà) , sorry :/"

            );
            User::addMoney($author,-$nbDauphiCoins);
            Stats::newPartyGame("rps", $author, "defaite");
        } else { // victoire
            $embed = array(
                "color"=> 4304030,
                "author"=> [
                    "name"=> "DauphiBotCorne",
                ],
                "title" => "Jeu de pierre-papier-ciseaux pour " . $nbDauphiCoins,
                "description" => "Je joue " . $weaponsEnnemi[$botWeapon] . " donc tu gagnes ... rhaaaaaa" .
                    " tiens, tu gagnes donc : " . $nbDauphiCoins . " de plus :'("

            );
            User::addMoney($author,$nbDauphiCoins);
            Stats::newPartyGame("rps", $author, "victoire");
        }
        return $embed;
    }
}