<?php

namespace lenlenlL6\yourinformation;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use lenlenlL6\yourinformation\YourInformationCommand;

class YourInformation extends PluginBase{
  
  /** @var Config $info */
  public $info;
  
  public function onEnable() : void{
     $this->saveDefaultConfig();
     $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
     $this->getServer()->getCommandMap()->register("YourInformation", new YourInformationCommand($this));
     $this->info = new Config($this->getDataFolder() . "info.yml", Config::YAML);
  }
  
  public function onDisable() : void{
    $this->info->save();
  }
}