<?php

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