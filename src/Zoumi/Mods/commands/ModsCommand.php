<?php

namespace Zoumi\Mods\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use Zoumi\Mods\api\Mods;
use Zoumi\Mods\Manager;

class ModsCommand extends Command {

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player){
            self::sendModsMenu($sender);
        }
    }


    public static function sendModsMenu(Player $player){
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $ui = $api->createSimpleForm(function (Player $player, $data){
            if ($data === null){
                return;
            }
            switch ($data){
                case 0:
                    self::sendCPS($player);
                    break;
                case 1:
                    self::sendReach($player);
                    break;
            }
        });
        $ui->setTitle("Mods");
        $ui->addButton("§e- §fCPS §e-");
        $ui->addButton("§e- §fReach §e-");
        $ui->sendToPlayer($player);
    }

    public static function sendCPS(Player $player){
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $ui = $api->createSimpleForm(function (Player $player, $data){
            if ($data === null){
                return;
            }
            switch ($data){
                case 0:
                    if (Mods::isEnable($player, "cps")){
                        $player->sendMessage(Manager::PREFIX_ALERT . "Vous avez déjà activer le mod §eCPS§c.");
                        return;
                    }
                    Mods::setEnable($player, "cps", true);
                    $player->sendMessage(Manager::PREFIX_INFOS . "Vous avez bien activer le mod §eCPS§f.");
                    break;
                case 1:
                    if (!Mods::isEnable($player, "cps")){
                        $player->sendMessage(Manager::PREFIX_ALERT . "Vous avez déjà désactiver le mode §eCPS§c.");
                        return;
                    }
                    Mods::setEnable($player, "cps", false);
                    $player->sendMessage(Manager::PREFIX_INFOS . "Vous avez bien désactiver le mod §eCPS§f.");
                    break;
            }
        });
        $ui->setTitle("Mods");
        $ui->setContent("§f- §7Permet d'afficher votre nombre de clique par seconde en format popup.");
        $ui->addButton("§a- §fActiver §a-");
        $ui->addButton("§c- §fDésactiver §c-");
        $ui->sendToPlayer($player);
    }

    public static function sendReach(Player $player){
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $ui = $api->createSimpleForm(function (Player $player, $data){
            if ($data === null){
                return;
            }
            switch ($data){
                case 0:
                    if (Mods::isEnable($player, "reach")){
                        $player->sendMessage(Manager::PREFIX_ALERT . "Vous avez déjà activer le mod §eReach§c.");
                        return;
                    }
                    Mods::setEnable($player, "reach", true);
                    $player->sendMessage(Manager::PREFIX_INFOS . "Vous avez bien activer le mod §eReach§f.");
                    break;
                case 1:
                    if (!Mods::isEnable($player, "reach")){
                        $player->sendMessage(Manager::PREFIX_ALERT . "Vous avez déjà désactiver le mode §eReach§c.");
                        return;
                    }
                    Mods::setEnable($player, "reach", false);
                    $player->sendMessage(Manager::PREFIX_INFOS . "Vous avez bien désactiver le mod §eReach§f.");
                    break;
            }
        });
        $ui->setTitle("Mods");
        $ui->setContent("§f- §7Permet d'afficher la distance entre vous et votre enemie sous format popup.");
        $ui->addButton("§a- §fActiver §a-");
        $ui->addButton("§c- §fDésactiver §c-");
        $ui->sendToPlayer($player);
    }

}