<?php
/**
 * Created by PhpStorm.
 * User: Drest
 * Date: 09/07/2018
 * Time: 12:09
 */

namespace Bot\Module\Modules;

use Bot\utils\Stats;
use Discord\Parts\Guild\Emoji;
use Skinny\Module\ModuleInterface;
use Skinny\Network\Wrapper;
use Bot\utils\User;
use Bot\Module\Exception\ErrorMessage;


class PileOuFace implements ModuleInterface
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
            case 'pf':
                $params = explode(' ', $message['parts'][1]);
                $params[0] = strtolower($params[0]);
                if($params[0] === "pile" || $params[0] === "face"){
                    $author = $wrapper->Message->author->username . "#" . $wrapper->Message->author->discriminator;
                    $moneyUser = User::getMoney($author);
                    if($moneyUser - $params[1] > 0){
                        $wrapper->Channel->sendMessage("",false, $this->pileOrFace($params[0], $params[1], $author));
                    } else { // Pas assez d'argent
                        ErrorMessage::createErrorGameMessage($moneyUser, $wrapper);
                    }
                } else {
                    ErrorMessage::createErrorCommandMessage("Votre côté n'existe pas, veuillez choisir pile ou face", "pf", $wrapper);
                }

                break;
        }

    }

    private function pileOrFace($weaponJoueur, $nbDauphiCoins, $author){
        $weapons = array("pile" => 0, "face" => 1);
        $weaponsEnnemi = array("pile", "face");
        $botWeapon = rand(0,1);

        if($weapons[$weaponJoueur] == $botWeapon){ // victoire

            $embed = array(
                "color"=> 4304030,
                "author"=> [
                    "name"=> "DauphiBotCorne",
                ],
                "title" => "Jeu de pierre-papier-ciseaux pour " . $nbDauphiCoins,
                "description" => "J'ai tiré " . $weaponsEnnemi[$botWeapon] . " donc tu gagnes ... rhaaaaaa" .
                    " tiens, tu gagnes donc : " . $nbDauphiCoins . " de plus :cry: "

            );
            User::addMoney($author,$nbDauphiCoins);
            Stats::newPartyGame("pf",$author,"victoire");
        } else { // defaite

            $embed = array(
                "color"=> 7478274,
                "author"=> [
                    "name"=> "DauphiBotCorne",
                ],
                "title" => "Jeu de pile ou face pour " . $nbDauphiCoins,
                "description" => "J'ai tiré " . $weaponsEnnemi[$botWeapon] . " donc tu perds MOUAHAHAHA, à moi tes DauphiCoins (meme s'ils m'appartenaient déjà) , sorry :/"
            );
            User::addMoney($author,-$nbDauphiCoins);
            Stats::newPartyGame("pf",$author,"defaite");
        }
        return $embed;
    }
}