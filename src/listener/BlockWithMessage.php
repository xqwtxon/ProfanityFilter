<?php

namespace xqwtxon\HiveProfanityFilter\listener;

use xqwtxon\HiveProfanityFilter\Loader;
use xqwtxon\HiveProfanityFilter\utils\LanguageManager;
use xqwtxon\HiveProfanityFilter\utils\ConfigManager;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\Event;
use pocketmine\event\Listener;

class BlockWithMessage implements Listener {
	private LanguageManager $lang;
	private ConfigManager $config;
	public function __construct(Loader $plugin){
		$this->lang = new LanguageManager();
		$this->config = new ConfigManager();
	}
	public function onChat(PlayerChatEvent $ev) :void {
		$msg = $ev->getMessage();
		$player = $ev->getPlayer();
		$words = array_map("strtolower", $this->config->profanityGet("banned-words"), []);
		if ($this->plugin->containsProfanity($msg)){
			$ev->cancel();
			$message = $this->lang->translateMessage("block-message");
			$player->sendMessage($message);
		}
	}
}