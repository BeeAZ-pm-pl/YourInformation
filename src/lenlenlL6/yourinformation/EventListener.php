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
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerJumpEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use lenlenlL6\yourinformation\YourInformation;

class EventListener implements Listener{
  
  /**@var YourInformation $main */
  private $main;
  
  public function __construct(YourInformation $main){
    $this->main = $main;
  }
  
  public function onJoin(PlayerJoinEvent $event){
    $player = $event->getPlayer();
    if(!$this->main->info->exists($player->getName())){
      $this->main->info->setNested($player->getName() . ".join", 1);
      $this->main->info->setNested($player->getName() . ".kill", 0);
      $this->main->info->setNested($player->getName() . ".death", 0);
      $this->main->info->setNested($player->getName() . ".sneak", 0);
      $this->main->info->setNested($player->getName() . ".jump", 0);
      $this->main->info->save();
    }else{
      $this->main->info->setNested($player->getName() . ".join", ($this->main->info->getNested($player->getName() . ".join") + 1));
      $this->main->info->save();
    }
  }
  
  public function onDeath(PlayerDeathEvent $event){
    $player = $event->getPlayer();
    $this->main->info->setNested($player->getName() . ".death", ($this->main->info->getNested($player->getName() . ".death") + 1));
    $this->main->info->save();
  }
  
  public function onSneak(PlayerToggleSneakEvent $event){
    $player = $event->getPlayer();
    if(!$event->isCancelled()){
      $this->main->info->setNested($player->getName() . ".sneak", ($this->main->info->getNested($player->getName() . ".sneak") + 1));
      $this->main->info->save();
    }
  }
  
  public function onJump(PlayerJumpEvent $event){
    $player = $event->getPlayer();
    $this->main->info->setNested($player->getName() . ".jump", ($this->main->info->getNested($player->getName() . ".jump") + 1));
    $this->main->info->save();
  }
  
  public function onKill(EntityDamageEvent $event){
    $player = $event->getEntity();
    if(!$event->isCancelled()){
    if($player instanceof Player){
    if($event->getFinalDamage() >= $player->getHealth()){
    if($event instanceof EntityDamageByEntityEvent){
    $damager = $event->getDamager();
    if($damager instanceof Player){
    $this->main->info->setNested($damager->getName() . ".kill", ($this->main->info->getNested($damager->getName()) + 1));
    $this->main->info->save();
    }
    }
    }
    }
    }
  }
}
