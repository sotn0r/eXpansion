<?php

namespace ManiaLivePlugins\eXpansion\Dedimania;

use \ManiaLive\Event\Dispatcher;
use ManiaLivePlugins\Reaby\Dedimania\Events\Event as dediEvent;
use ManiaLivePlugins\eXpansion\Dedimania\Config;

class Dedimania extends \ManiaLivePlugins\eXpansion\Core\types\ExpPlugin implements \ManiaLivePlugins\Reaby\Dedimania\Events\Listener {

    private $config;

    public function exp_onInit() {
        parent::exp_onInit();
        $this->addDependency(new \ManiaLive\PluginHandler\Dependency("Reaby\\Dedimania"));
        $this->config = Config::getInstance();
    }

    public function exp_onLoad() {
        parent::exp_onLoad();
        \ManiaLivePlugins\eXpansion\Core\ColorParser::getInstance()->registerCode("dedirecord", $this->config->color_dedirecord);
    }

    public function exp_onReady() {
        parent::exp_onReady();
        $this->callPublicMethod('Reaby\\Dedimania', 'disableMessages');
        Dispatcher::register(dediEvent::getClass(), $this);
    }

    public function onDedimaniaGetRecords($data) {
        
    }

    public function onDedimaniaNewRecord($record) {
        $this->exp_chatSendServerMessage($this->config->newRecordMsg, null, array(\ManiaLib\Utils\Formatting::stripCodes($record->nickname, "wos"), $record->place, \ManiaLive\Utilities\Time::fromTM($record->time)));
    }

    public function onDedimaniaOpenSession() {
        
    }

    public function onDedimaniaPlayerConnect($data) {
        if ($data == null)
            return;

        if ($data['Banned']) {
            return;
        }

        $player = $this->storage->getPlayerObject($data['Login']);
        $type = '$fffFree';

        if ($data['MaxRank'] > 15) {
            $type = '$ff0Premium$fff';
            $upgrade = false;
        }

        $this->exp_chatSendServerMessage($player->nickName . '$z$s$fff connected with ' . $type . ' dedimania account. $0f0Top' . $data['MaxRank'] . '$fff records enabled.', null);
        if ($upgrade)
            $this->exp_chatSendServerMessage($this->config->upgradeMsg, $data['Login']);
    }

    public function onDedimaniaPlayerDisconnect() {
        
    }

    public function onDedimaniaRecord($record, $oldRecord) {
        $diff = \ManiaLive\Utilities\Time::fromTM($record->time - $oldRecord->time, true);
        $this->exp_chatSendServerMessage($this->config->recordMsg, null, array(\ManiaLib\Utils\Formatting::stripCodes($record->nickname, "wos"), $record->place, \ManiaLive\Utilities\Time::fromTM($record->time), $diff));
    }

    public function onDedimaniaUpdateRecords($data) {
        
    }

}

?>
