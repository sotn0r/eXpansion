<?php

namespace ManiaLivePlugins\eXpansion\Chat;

use ManiaLivePlugins\eXpansion\Core\types\config\types\Boolean;
use ManiaLivePlugins\eXpansion\Core\types\config\types\String;

/**
 * Description of MetaData
 *
 * @author De Cramer Oliver
 */
class MetaData extends \ManiaLivePlugins\eXpansion\Core\types\config\MetaData
{

    public function onBeginLoad()
    {
	parent::onBeginLoad();
	$this->setName("Chat Customization");
	$this->setDescription('Reroute chat to controller and customize the chat colors and look!');

	$config = Config::getInstance();
	
	$var = new Boolean('publicChatActive', 'Enable public chat for players', $config, false);
	$var->setDescription('Admins with required permissions can continue to chat. A personal message is sent to other players');
	$var->setDefaultValue(true);
	$var->setGroup("Chat");
	$this->registerVariable($var);

	$var = new Boolean('allowMPcolors', 'Allow ManiaPlanet chatmessages colorbug for chat', $config, false);
	$var->setDefaultValue(true);
	$var->setGroup("Chat");
	$this->registerVariable($var);

	$var = new String('publicChatColor', 'Public chat color for server', $config, false);
	$var->setDefaultValue('$ff0');
	$var->setGroup("Chat");
	$this->registerVariable($var);

	$var = new String('otherServerChatColor', 'Public chat color for relay server', $config, false);
	$var->setDefaultValue('$0d0');
	$var->setGroup("Chat");
	$this->registerVariable($var);

	$var = new String('adminChatColor', 'Chat color for server administrators', $config, false);
	$var->setDefaultValue('$ff0');
	$var->setGroup("Chat");
	$this->registerVariable($var);

	$var = new String('adminSign', 'Prefix for admin chat messages', $config, false);
	$var->setDefaultValue('');
	$var->setGroup("Chat");
	$this->registerVariable($var);

	$var = new String('chatSeparator', 'Separator for between nickname and message', $config, false);
	$var->setDefaultValue('$0af»$z$s ');
	$var->setGroup("Chat");
	$this->registerVariable($var);
    }

}

?>
