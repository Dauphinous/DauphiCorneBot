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

    public static $allErrorGameMessages = array(
        "Non mais tu as pas assez d'argent pour jouer à ce jeu",
        "MDRRRRRRRR, tu m'as pris pour une oeuvre charitative ? Va mendier ailleurs",
        "Le monde n'est pas prêt à se que tu joues sorry",
        "Peut être que si tu le demandes gentiment le choupire ou la vampicorne te donneront de l'argent, sinon RIP toi :D",
        "On sait que tout est contre toi, mais t'es-tu un jour dit que si tu avais de l'argent, le monde serait avec toi ?",
        "Non mais tu m'as pris pour une banque ? Je ne fais clairement pas de prêt, oust toi",
        "T'es conscient que meme une larve a plus de DauphiCoins que toi ? Je n'accepte pas les larves dans mes jeux",
        "Vive le vent, vive le vent, vive l'argent d'hiver, mais tu en auras pas, et na et na et na, OUAI :)",
        "Arrête de ne pas avoir d'argents pour voir toutes mes jolies phrases, deviens riche un peu :p",
        "Je ne suis qu'un bot, j'obeis aux ordres donc désolé mais tu peux pas jouer :'(",
        "MOUAHAHAHAHA, selon l'accord avec le choupire et la vampicorne, je dois donner de l'argent aux dailys, mais ça me fait un bien fou de savoir que vous n'avez pas assez d'argents pour jouer (sors ses cornes)",
        "Désolé, mais je suis trop occupé par l'étupe de la relativité restreinte pour te faire jouer",
        "Et si seulement tu avais un cerveau, nous pourrions faire de grandes choses, ah non, en faite j'ai juste besoin de ton argent et tu en as pas, aurevoir :p",
        "Tu as vraiment pu pouvoir arnaquer un être aussi cupide et avare que moi ? Tu es nais 1000 jours trop tad pour m'avoir",
        "Tu penses pouvoir m'arnaquer ? Je connais ton compte en banque par coeur, oust",
        "Sécurité ? Venez arrêter immediatement cet individu pour tentative de vol !!!!",
        "... honteux ...",
        "L'évidence n'est évidente que si elle est évidente, ce qui n l'est clairement pas pour toi !",
        "Si tu savais comment je t'envie de pas avoir d'argent, ici toutle monde vient me parler uniquement pour mon compte en banque",
        "Incompréhensible for ever, un jour je t'apprendrais que nous ne sommes pas une banque",
        "Mystiiic est un est ange sauf quand il s'agit de sa banque, elle ne vous fait pas jouer gratuitement",
        "Hihihi, je suis flatté que tu viennes jouer, mais ramènes une valise d'argent la prochaine fois :p"
    );

    public static function createErrorCommandMessage($errorMessage, $command, $wrapper)
    {
        ErrorMessage::createErrorMessage($wrapper,"Erreur dans la commande : " . $command, $errorMessage);
    }

    public static function createErrorMessage($wrapper, $title, $description){
        $embed = array(
            "color"=> 16661248,
            "author"=> [
                "name"=> "DauphiBotCorne",
            ],
            "title" => $title,
            "description" => $description

        );
        $wrapper->Channel->sendMessage("", false, $embed);
    }

    public static function createErrorGameMessage($DauphiCoins, $wrapper){
        $decription = "Tu n'as que " . $DauphiCoins . " DauphiCoins";
        ErrorMessage::createErrorMessage($wrapper,ErrorMessage::$allErrorGameMessages[rand(0,count(ErrorMessage::$allErrorGameMessages))], $decription);
    }
}