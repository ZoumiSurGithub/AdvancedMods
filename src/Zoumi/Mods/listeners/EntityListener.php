<?php

namespace Zoumi\Mods\listeners;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use Zoumi\Mods\api\Mods;

class EntityListener implements Listener {

    public function onEntityDamageByEntity(EntityDamageByEntityEvent $event){
        $damager = $event->getDamager();
        $entity = $event->getEntity();
        if ($damager instanceof Player && $entity instanceof Player){
            if (Mods::isEnable($damager, "cps")){
                Mods::addClicks($damager);
            }
            if (Mods::isEnable($damager, "reach")){
                Mods::setReach($damager, $entity);
            }
            if (Mods::isEnable($entity, "reach")){
                Mods::setReach($entity, $damager);
            }
        }
    }

}