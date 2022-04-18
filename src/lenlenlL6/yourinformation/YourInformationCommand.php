<?php
/*
This is free and unencumbered software released into the public domain.

Anyone is free to copy, modify, publish, use, compile, sell, or
distribute this software, either in source code form or as a compiled
binary, for any purpose, commercial or non-commercial, and by any
means.

In jurisdictions that recognize copyright laws, the author or authors
of this software dedicate any and all copyright interest in the
software to the public domain. We make this dedication for the benefit
of the public at large and to the detriment of our heirs and
successors. We intend this dedication to be an overt act of
relinquishment in perpetuity of all present and future rights to this
software under copyright law.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

For more information, please refer to <https://unlicense.org>
*/
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
  protected $main;
  
  public function __construct(YourInformation $main){
    $this->main = $main;
    parent::__construct("myinfo", "Display the term information in the server", null, ["myinfo", "info", "yourinfo"]);
    $this->setPermission("yourinformation.command.use");
  }
  
  public function execute(CommandSender $player, string $label, array $args): bool{
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
    $break = $this->main->info->getNested($player->getName() . ".break");
    $player->sendMessage("§a======= §eYOUR INFORMATION §a=======");
    $player->sendMessage("§7> Name: " . $player->getName() . "\n§7> Join: " . $join . "\n§7> Kill: " . $kill . "\n§7> Death: " . $death . "\n§7> Sneak: " . $sneak . "\n§7> Jump: " . $jump . "\n§7> BreakBlock: ".$break."\n§a==============");
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
    $break = $this->main->info->getNested($player->getName() . ".break");
    $form->setTitle("§a======= §eYOUR INFORMATION §a=======");
    $form->addLabel("§7> Name: " . $player->getName() . "\n§7> Join: " . $join . "\n§7> Kill: " . $kill . "\n§7> Death: " . $death . "\n§7> Sneak: " . $sneak . "\n§7> Jump: " . $jump . "\n§7> BreakBlock: ".$break."\n§a==============");
    $form->sendToPlayer($player);
    return $form;
  }

 public function getOwningPlugin() : Plugin{
return $this->main; 
     }
}
