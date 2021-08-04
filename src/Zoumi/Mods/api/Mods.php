<?php

namespace Zoumi\Mods\api;

use pocketmine\Player;
use Zoumi\Mods\Main;

class Mods {

    public static $cps = [];
    public static $reach = [];

    public static function createAccount(Player $player){
        $cps = Main::getInstance()->cps;
        $cps->set($player->getName(), false);
        $cps->save();
        $reach = Main::getInstance()->reach;
        $reach->set($player->getName(), false);
        $reach->save();
    }

    public static function existPlayer(Player $player): bool{
        if (Main::getInstance()->cps->exists($player->getName())){
            return true;
        }elseif (Main::getInstance()->reach->exists($player->getName())) {
            return true;
        }
        return false;
    }

    public static function getClicks(Player $player) {
        if (!isset(self::$cps[$player->getLowerCaseName()])) {
            return 0;
        }
        $time = self::$cps[$player->getLowerCaseName()][0];
        $clicks = self::$cps[$player->getLowerCaseName()][1];
        if ($time !== time()) {
            unset(self::$cps[$player->getLowerCaseName()]);
            return 0;
        }
        return $clicks;
    }

    public static function addClicks(Player $player) {
        if (!isset(self::$cps[$player->getLowerCaseName()])) {
            self::$cps[$player->getLowerCaseName()] = [time(), 0];
        }
        $time = self::$cps[$player->getLowerCaseName()][0];
        $clicks = self::$cps[$player->getLowerCaseName()][1];
        if ($time !== time()) {
            $time = time();
            $clicks = 0;
        }
        $clicks++;
        self::$cps[$player->getLowerCaseName()] = [$time, $clicks];
    }

    public static function getReach(Player $player) {
        if (!isset(self::$reach[$player->getLowerCaseName()])) {
            return 0;
        }
        $time = self::$reach[$player->getLowerCaseName()][0];
        $clicks = self::$reach[$player->getLowerCaseName()][1];
        if ($time !== time()) {
            unset(self::$reach[$player->getLowerCaseName()]);
            return 0;
        }
        return $clicks;
    }

    public static function setReach(Player $player, Player $target) {
        if (!isset(self::$reach[$player->getLowerCaseName()])) {
            self::$reach[$player->getLowerCaseName()] = [time(), 0];
        }
        $time = self::$reach[$player->getLowerCaseName()][0];
        if ($time !== time()) {
            $time = time();
            $reach = 0;
        }
        $reach = $player->distance($target->getPosition());
        self::$reach[$player->getLowerCaseName()] = [$time, $reach];
    }

    public static function isEnable(Player $player, string $variable): bool{
        if (Main::getInstance()->{$variable}->get($player->getName()) === true){
            return true;
        }
        return false;
    }

    /*
    public static function isBlocked(Player $player, Player $target): bool{
        if (isset(Main::getInstance()->msg->get($player->getName())["blocked"][$target->getName()])){
            return true;
        }
        return false;
    }

    public static function setBlocked(Player $player, Player $target){
        $msg = Main::getInstance()->msg;
        $blocked = $msg->get($player->getName())["blocked"];
        $new = $blocked[$target->getName()] = $target->getName();
        $msg->set($player->getName(), ["blocked" => $blocked, "enable" => $msg->get($player->getName())["enable"]]);
        $msg->save();
    }
    */

    public static function setEnable(Player $player, string $var, bool $value)
    {
        $config = Main::getInstance()->{$var};
        $config->set($player->getName(), $value);
        $config->save();
    }

}