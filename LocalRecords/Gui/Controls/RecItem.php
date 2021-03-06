<?php

namespace ManiaLivePlugins\eXpansion\LocalRecords\Gui\Controls;

use ManiaLivePlugins\eXpansion\LocalRecords\Structures\Record;
use ManiaLivePlugins\eXpansion\Gui\Elements\ListBackGround;

use ManiaLivePlugins\eXpansion\Gui\Gui;

/**
 * Description of RecItem
 *
 * @author oliverde8
 */
class RecItem extends \ManiaLive\Gui\Control implements \ManiaLivePlugins\eXpansion\Gui\Structures\OptimizedPagerElement{
    
    private $label_rank, $label_nick, $label_score, $label_avgScore, $label_nbFinish;
    private $bg;
    public static $widths;
     
    function __construct($indexNumber, $login, $action) { 
        $this->sizeY = 6;
        $this->bg = new ListBackGround($indexNumber, 100, 6);
        $this->addComponent($this->bg);
        
        $this->frame = new \ManiaLive\Gui\Controls\Frame();
        $this->frame->setSize(100, 4);
        $this->frame->setPosY(0);
        $this->frame->setLayout(new \ManiaLib\Gui\Layouts\Line());
        $this->addComponent($this->frame);
        
        $this->label_rank = new \ManiaLib\Gui\Elements\Label(10, 4);
        $this->label_rank->setAlign('left', 'center');
        $this->label_rank->setId('column_' . $indexNumber . '_0');
        $this->frame->addComponent($this->label_rank);

        $this->label_nick = new \ManiaLib\Gui\Elements\Label(10., 4);
        $this->label_nick->setAlign('left', 'center');
        $this->label_nick->setId('column_' . $indexNumber . '_1');
        $this->frame->addComponent($this->label_nick);
        
        $this->label_score = new \ManiaLib\Gui\Elements\Label(10, 4);
        $this->label_score->setAlign('left', 'center');
        $this->label_score->setId('column_' . $indexNumber . '_2');
        $this->frame->addComponent($this->label_score);
        
        $this->label_avgScore = new \ManiaLib\Gui\Elements\Label(10, 4);
        $this->label_avgScore->setAlign('left', 'center');
        $this->label_avgScore->setId('column_' . $indexNumber . '_3');
        $this->frame->addComponent($this->label_avgScore);
        
        $this->label_nbFinish = new \ManiaLib\Gui\Elements\Label(10, 4);
        $this->label_nbFinish->setAlign('left', 'center');
        $this->label_nbFinish->setId('column_' . $indexNumber . '_4');
        $this->frame->addComponent($this->label_nbFinish);
	
	$this->setScale(0.8);
	$this->setSizeX(145);
    }
    
    
    public function onResize($oldX, $oldY) {
        $scaledSizes = Gui::getScaledSize(self::$widths, ($this->getSizeX()) - 5);
        $this->bg->setSizeX($this->getSizeX()-5);
        $this->label_rank->setSizeX($scaledSizes[0]);
        $this->label_nick->setSizeX($scaledSizes[1]);
        $this->label_score->setSizeX($scaledSizes[2]);
        $this->label_avgScore->setSizeX($scaledSizes[3]);
        $this->label_nbFinish->setSizeX($scaledSizes[4]);
    }
    // manialive 3.1 override to do nothing.
    function destroy() {
        
    }

    /*
     * custom function to remove contents.
     */
    function erase() {
        parent::destroy();
    }

    public function getNbTextColumns() {
	return 5;
    }

}

?>
