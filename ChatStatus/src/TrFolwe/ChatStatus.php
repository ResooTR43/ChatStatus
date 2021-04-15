<?php

namespace TrFolwe;

use pocketmine\plugin\PluginBase;
use TrFolwe\{ChatCommand, ChatListener};
use pocketmine\{Player, Server};
use pocketmine\utils\Config;
use pocketmine\event\Listener;

class ChatStatus extends PluginBase implements Listener {

public static $cfg;

	public function onEnable(){
		$this->getLogger()->notice("Chat Aktif");
		$this->getServer()->getPluginManager()->registerEvents(new ChatListener($this), $this);
		$this->getServer()->getCommandMap()->register("sohbetdurum", new ChatCommand($this));
		self::$cfg = new Config($this->getDataFolder(). "DataBase.yml", Config::YAML);
	}
}