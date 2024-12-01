<?php

namespace Mrchlldev\AntiFallDamage;

use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\entity\EntityDamageEvent;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if($this->getConfig()->get("worlds") === null){
            $this->getServer()->getLogger()->error("The config in worlds not found! disable plugin!");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
    }

    public function onDamage(EntityDamageEvent $event): void {
        $entity = $event->getEntity();
        if(!$entity instanceof Player) return;
        if($event->getCause() === EntityDamageEvent::CAUSE_FALL){
            foreach($this->getConfig()->get("worlds") as $world){
                if($entity->getWorld()->getFolderName() === $world){
                    $event->cancel();
                }
            }
            if($player->hasPermission("antifalldamage.bypass")){
                $entity->sendTip("§aWe remove the fall damage for you!");
                $event->cancel();
            }
        }
    }
}
