<?php

namespace Zoumi\Mods\tasks;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use Zoumi\Mods\api\Mods;

class ModsTask extends Task {

    public function onRun(int $currentTick)
    {
        if (count(Server::getInstance()->getOnlinePlayers()) < 1) return;

        foreach (Server::getInstance()->getOnlinePlayers() as $player){
            $value = "§e- ";
            if (Mods::isEnable($player, "cps")){
                $value = $value . " §7CPS: §f" . Mods::getClicks($player);
            }
            if (Mods::isEnable($player, "reach")){
                $value = $value . " §7Reach: §f" . Mods::getReach($player);
            }
            if ($value !== "§e- "){
                $player->sendPopup($value . " §e-");
            }
        }
    }

}