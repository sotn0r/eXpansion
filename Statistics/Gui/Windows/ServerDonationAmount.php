<?php

namespace ManiaLivePlugins\eXpansion\Statistics\Gui\Windows;



class ServerDonationAmount extends \ManiaLivePlugins\eXpansion\Gui\Windows\PagerWindow {

    public static $labelTitles = array('NickName', 'Amount of Planets');
    
    protected function getKeys() {
        return array('nickname', 'totalPlanets');
    }

    protected function getLabel($i) {
        return isset(self::$labelTitles[$i]) ? self::$labelTitles[$i] : "";
    }

    protected function getWidths() {
        return array(3, 2);
    }

}

?>
