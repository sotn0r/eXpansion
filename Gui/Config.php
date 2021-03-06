<?php

namespace ManiaLivePlugins\eXpansion\Gui;

class Config extends \ManiaLib\Utils\Singleton {

    public $logo = "http://reaby.kapsi.fi/ml/exp.png";
    public $button = "http://reaby.kapsi.fi/ml/button2.png";
    public $buttonActive = "http://reaby.kapsi.fi/ml/button2_active.png";
    public $checkbox = "http://reaby.kapsi.fi/ml/checkbox_off.png";
    public $checkboxActive = "http://reaby.kapsi.fi/ml/checkbox_on.png";
    public $checkboxDisabled = "http://reaby.kapsi.fi/ml/checkbox_disabled_off.png";
    public $checkboxDisabledActive = "http://reaby.kapsi.fi/ml/checkbox_disabled_on.png";
    public $ratiobutton = "http://reaby.kapsi.fi/ml/ratio_off.png";
    public $ratiobuttonActive = "http://reaby.kapsi.fi/ml/ratio_on.png";
    public $windowTitlebar = "http://reaby.kapsi.fi/ml/title3.png";
    public $windowClosebutton = "http://reaby.kapsi.fi/ml/close_off2.png";
    public $windowClosebuttonActive = "http://reaby.kapsi.fi/ml/close_on2.png";
    public $windowMinbutton = "http://reaby.kapsi.fi/ml/min_off.png";
    public $windowMinbuttonActive = "http://reaby.kapsi.fi/ml/min_on.png";
    
    public $style_list_bgColor = array('aaa6', 'eee6');
    public $style_list_bgStyle = array('Bgs1', 'Bgs1');
    public $style_list_bgSubStyle = array('BgCard', 'BgCard');
    public $style_list_posXOffset = -1;
    public $style_list_sizeXOffset = 0;
    public $style_list_posYOffset = 0;
    public $style_list_sizeYOffset = 0;
    
    public $style_title_bgColor = 'ddd4';
    public $style_title_bgStyle = 'Bgs1';
    public $style_title_bgSubStyle = 'BgCard';
    public $style_title_posXOffset = -1;
    public $style_title_sizeXOffset = 2;
    public $style_title_posYOffset = 0;
    public $style_title_sizeYOffset = 0;
    
    public $style_widget_bgColor = '';
    public $style_widget_bgStyle = 'BgsPlayerCard';
    public $style_widget_bgSubStyle = 'BgRacePlayerName'; // BgList
    public $style_widget_bgColorize = '000'; // BgList
    public $style_widget_bgOpacity = 1;
    public $style_widget_bgXOffset = 0;
    public $style_widget_bgYOffset = 0;

    public $style_widget_title_bgStyle = 'UiSMSpectatorScoreBig';
    public $style_widget_title_bgSubStyle = 'PlayerSlotCenter'; // BgList
    public $style_widget_title_bgColorize = '3af'; // BgList
    public $style_widget_title_bgOpacity = 1;
    public $style_widget_title_bgXOffset = 0;
    public $style_widget_title_bgYOffset = 0.75;
    public $style_widget_title_lbStyle = 'TextCardScores2';
    public $style_widget_title_lbSize = 1;
    public $style_widget_title_lbColor = 'fff';

    public $disableAnimations = false;
    public $disablePersonalHud = false;

}

?>
