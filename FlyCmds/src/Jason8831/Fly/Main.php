<?php

namespace Jason8831\Fly;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{

    public Config $config;

    /**
     * @var Main
     */
    private static $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getLogger()->info("§f[§l§4FlyCommands§r§f]: activée");
        $this->saveResource("config.yml");

        $this->getServer()->getCommandMap()->registerAll("AllCommands", [
            new Commands\Fly(name: "fly", description: "permet de donner le fly a une personne", usageMessage: "fly")
        ]);
    }

    public static function getInstance(): self{
        return self::$instance;
    }
}