<?php

namespace TrFolwe;

use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\{Player, Server};
use TrFolwe\ChatStatus;

class ChatListener implements Listener {

public function __construct(ChatStatus $plugin){
	$this->p = $plugin;
}

	public function onChat(PlayerChatEvent $event){

		$g = $event->getPlayer();
		$message = $event->getMessage();

		if(Main::$cfg->get("Sohbet Durum") == "Açık"){
			$event->setCancelled(false);
		}else{
			if($g->hasPermission("sohbet.yaz")){
				$event->setCancelled(false);
			}else{
				$event->setCancelled(true);
				$g->sendMessage("§8[§l§e!§r§8] §7Şu anda Sohbet Kapalıdır, Açılana Kadar Yazamassın");
			}
		}
	}
}
?>