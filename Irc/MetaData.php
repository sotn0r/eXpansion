<?php

namespace ManiaLivePlugins\eXpansion\Gui;

use ManiaLivePlugins\eXpansion\Core\types\config\types\String;
use ManiaLivePlugins\eXpansion\Core\types\config\types\BasicList;
use ManiaLivePlugins\eXpansion\Core\types\config\types\Boolean;
use ManiaLivePlugins\eXpansion\Core\types\config\types\Int;
use ManiaLivePlugins\eXpansion\Core\types\config\types\Float;
use ManiaLivePlugins\eXpansion\Core\types\config\types\BoundedFloat;

/**
 * Description of MetaData
 *
 * @author Petri
 */
class MetaData extends \ManiaLivePlugins\eXpansion\Core\types\config\MetaData {

    public function onBeginLoad() {
	parent::onBeginLoad();
	$this->setName("Internet Relay Chat");
	$this->setDescription("Provides IRC link for chatting and remote administration");

	$config = Config::getInstance();
	
	$var = new String("hostname", "hostname", $config, false);
	$var->setDefaultValue("");
	$this->registerVariable($var);
	
	$var = new String("server", "irc server to connect", $config, false);
	$var->setDefaultValue("");
	$this->registerVariable($var);
	
	$var = new Int("port", "connection port for the server", $config, false);
	$var->setDefaultValue(6667);
	$this->registerVariable($var);
	
	$var = new String("serverPass", "password for server", $config, false);
	$var->setDefaultValue("");
	$this->registerVariable($var);
	
	$var = new String("realname", "Ircbot realname", $config, false);
	$var->setDefaultValue("ManiaPlanet bot");
	$this->registerVariable($var);
	
	$var = new String("nickname", "Ircbot nickname", $config, false);
	$var->setDefaultValue("maniaplanet_bot");
	$this->registerVariable($var);
	
	
	$var = new String("ident", "ident for bot", $config, false);
	$var->setDefaultValue("maniaplanet_bot");
	$this->registerVariable($var);
	
	$var = new String("channel", "irc channel to join", $config, false);
	$var->setDefaultValue("#bots");
	$this->registerVariable($var);
	
	$var = new String("channelKey", "irc channel key", $config, false);
	$var->setDefaultValue("");
	$this->registerVariable($var);
	
	
    }

}