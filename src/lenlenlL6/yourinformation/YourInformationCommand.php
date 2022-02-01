<?php

namespace lenlenlL6\yourinformation;

use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use lenlenlL6\yourinformation\YourInformation;
use lenlenlL6\yourinformation\libs\jojoe77777\FormAPI\CustomForm;

class YourInformationCommand extends Command implements PluginOwned{
  
  /**@var YourInformation $main*/
  private $main;
  
  public function __construct(YourInformation $main){
    $this->main = $main;
    parent::__construct("myinfo", "Display the term information in the server", null, ["myinfo"]);
    $this->setPermission("yourinformation.command.use");
  }
  
  public function execute(CommandSender $player, String $label, array $args): bool{
    if($this->testPermission($player)){
    if($player instanceof Player){
    switch($this->main->getConfig()->get("ui")){
    case true:
    $this->InfoForm($player);
    break;
    
    case false:
    $kill = $this->main->info->getNested($player->getName() . ".kill");
    $join = $this->main->info->getNested($player->getName() . ".join");
    $death = $this->main->info->getNested($player->getName() . ".death");
    $sneak = $this->main->info->getNested($player->getName() . ".sneak");
    $jump = $this->main->info->getNested($player->getName() . ".jump");
    $player->sendMessage("§a======= §eYOUR INFORMATION §a=======");
    $player->sendMessage("§7> Name: " . $player->getName() . "\n§7> Join: " . $join . "\n§7> Kill: " . $kill . "\n§7> Death: " . $death . "\n§7> Sneak: " . $sneak . "\n§7> Jump: " . $jump . "\n§a==============");
    break;
    }
    }else{
    $player->sendMessage("Please use this command in game");
    }
    }
    return true;
  }
  
  public function InfoForm(Player $player){
    $form = new CustomForm(function(Player $player, array $data = null){
      
      if($data === null){
        return true;
      }
    });
    $kill = $this->main->info->getNested($player->getName() . ".kill");
    $join = $this->main->info->getNested($player->getName() . ".join");
    $death = $this->main->info->getNested($player->getName() . ".death");
    $sneak = $this->main->info->getNested($player->getName() . ".sneak");
    $jump = $this->main->info->getNested($player->getName() . ".jump");
    $form->setTitle("§a======= §eYOUR INFORMATION §a=======");
    $form->addLabel("§7> Name: " . $player->getName() . "\n§7> Join: " . $join . "\n§7> Kill: " . $kill . "\n§7> Death: " . $death . "\n§7> Sneak: " . $sneak . "\n§7> Jump: " . $jump . "\n§a==============");
    $form->sendToPlayer($player);
    return $form;
  }

 public function getOwningPlugin() : Plugin{
return $this->main; 
     }
}
