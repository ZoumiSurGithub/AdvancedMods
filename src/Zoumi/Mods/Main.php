<?php

namespace Zoumi\Mods;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Zoumi\Mods\commands\ModsCommand;
use Zoumi\Mods\listeners\EntityListener;
use Zoumi\Mods\tasks\ModsTask;

class Main extends PluginBase {

    public static $instance;

    public $cps;
    public $reach;
    public $combos;

    public static function getInstance(): self{
        return self::$instance;
    }

    public function onEnable()
    {
        self::$instance = $this;
        $this->setupFile();

        /** Config */
        $this->cps = new Config($this->getDataFolder() . "mods/cps.json", Config::JSON);
        $this->reach = new Config($this->getDataFolder() . "mods/reach.json", Config::JSON);
        $this->combos = new Config($this->getDataFolder() . "mods/combos.json", Config::JSON);

        /** Listeners */
        $this->getServer()->getPluginManager()->registerEvents(new EntityListener(), $this);

        /** Commands */
        $this->getServer()->getCommandMap()->registerAll("AdvancedMods", [
            new ModsCommand("mods", "Permet de gérer vos mods.", "/mods", [])
        ]);

        /** Tasks */
        $this->getScheduler()->scheduleRepeatingTask(new ModsTask(), 3);
    }

    public function setupFile(): void{
        @mkdir($this->getDataFolder() . "mods");
        if (!file_exists($this->getDataFolder() . "mods/cps.json")){
            $this->saveResource($this->getDataFolder() . "mods/cps.json");
        }
        if (!file_exists($this->getDataFolder() . "mods/reach.json")){
            $this->saveResource($this->getDataFolder() . "mods/reach.json");
        }
        if (!file_exists($this->getDataFolder() . "mods/combos.json")){
            $this->saveResource($this->getDataFolder() . "mods/combos.json");
        }
    }

}