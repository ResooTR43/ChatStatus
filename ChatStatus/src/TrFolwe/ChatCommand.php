<?php

namespace TrFolwe;

use pocketmine\command\{
	Command,
	CommandSender
};

use TrFolwe\ChatStatus;

use pocketmine\utils\Config;

use pocketmine\{Player, Server};
use jojoe77777\formapi\FormAPI;

class ChatCommand extends Command {

	public function __construct(ChatStatus $plugin){
		$this->p = $plugin;
		parent::__construct("sohbetdurum","Sohbet İle İlgili Ayarlar Yapabilirsin [§cYetkililere Özel Bir Komuttur§f]");
		$this->setAliases(["chatstatus"]);
	}

	public function execute(CommandSender $g, string $label, array $args) :bool{
		if($g instanceof Player){
			if($g->hasPermission("sohbet.panel")){
				if(Main::$cfg->get("Sohbet Durum") != "Açık" and Main::$cfg->get("Sohbet Durum") != "Kapalı"){
					Main::$cfg->set("Sohbet Durum", "Açık");
					Main::$cfg->save();
				}else{
				$this->ChatForm($g);
			}
			}else{
				$g->sendMessage("§8[§l§cX§r§8] §7Bu Komut'u Kullanma Yetkin Yok");
			}
		}
		return true;
	}
	public function ChatForm($g){
		$form = $this->p->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function(Player $g, $data = null){
			if(is_null($data)){
				return true;
			}
			switch($data){
				case 0:
				if(Main::$cfg->get("Sohbet Durum") == "Açık"){
					Main::$cfg->set("Sohbet Durum", "Kapalı");
					Main::$cfg->save();
					Server::getInstance()->broadcastMessage("§8[§a?§8] §7Sohbet §a".$g->getName()." §7Adlı Yetkili Tarafından Kapatıldı, Açılana Kadar Kullanamassınız");
				}elseif(Main::$cfg->get("Sohbet Durum") == "Kapalı"){
					Main::$cfg->set("Sohbet Durum", "Açık");
					Main::$cfg->save();
					Server::getInstance()->broadcastMessage("§8[§a?§8] §7Sohbet §a".$g->getName()." §7Adlı Yetkili Tarafından Açıldı, İyi Oyunlar");
				}
				break;
				case 1:
				break;
			}
		});
		$form->setTitle("§lSohbet Ayarları");
		$form->setContent("\nSohbet Ayarların\n\nSohbet Durumu: §a".Main::$cfg->get("Sohbet Durum"));
		if(Main::$cfg->get("Sohbet Durum") == "Kapalı"){
			$form->addButton("Sohbeti Aç\nDurum: §l§aKAPALI");
		}elseif(Main::$cfg->get("Sohbet Durum") == "Açık"){
			$form->addButton("Sohbeti Kapat\nDurum: §l§aAÇIK");
		}
		$form->addButton("Çıkış Yap");
		$form->sendToPlayer($g);
	}
}
?>
