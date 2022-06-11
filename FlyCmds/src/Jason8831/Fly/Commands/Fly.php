<?php

namespace Jason8831\Fly\Commands;

use Jason8831\Fly\Main;
use Jason8831\Fly\Tasks\FlyTasks;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class Fly extends Command
{

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $config = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);

        if ($sender instanceof Player) {
            if ($sender->hasPermission("fly.use")) {
                if (!isset($args[0])) {
                    $sender->setAllowFlight(true);
                    $sender->sendMessage($config->get("flyMe"));
                } else {
                    $target = Server::getInstance()->getPlayerByPrefix($args[0]);
                    if (!$target === null) {
                        $sender->sendMessage($config->get("noPlayerMention"));
                    } else {
                        if ($target instanceof Player) {
                            $target->setAllowFlight(true);
                            $messagetarget = str_replace("{player}", $target->getName(), $config->get("msgFlyTarget"));
                            $target->sendMessage($messagetarget);
                            $messageplayer = str_replace("{target}", $sender->getName(), $config->get("msgFlyPlayer"));
                            $sender->sendMessage($messageplayer);
                        }
                    }
                }
            } else {
                $sender->sendMessage($config->get("noPlayerPerm"));
            }
        }
    }
}