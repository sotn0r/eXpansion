<?php

namespace ManiaLivePlugins\eXpansion\Gui\Windows;

use ManiaLivePlugins\eXpansion\Gui\Controls\Item;
use ManiaLivePlugins\eXpansion\Gui\Gui;

/**
 * Description of PagerWindow
 *
 * @author De Cramer Oliver
 */
abstract class PagerWindow extends \ManiaLivePlugins\eXpansion\Gui\Windows\Window {

    private $frame;
    private $labels;
    private $pager;
    private $items = array();

    protected function onConstruct() {
        parent::onConstruct();

        $this->pager = new \ManiaLive\Gui\Controls\Pager();
        $this->pager->setPosX(0);
        $this->pager->setPosY(-4);
        $this->mainFrame->addComponent($this->pager);

        $this->frame = new \ManiaLive\Gui\Controls\Frame();
        $this->frame->setSize($this->getSizeX(), 4);
        $this->frame->setPosY(0);
        $this->frame->setLayout(new \ManiaLib\Gui\Layouts\Line());
        $this->mainFrame->addComponent($this->frame);

        $scaledSizes = Gui::getScaledSize($this->getWidths(), ($this->getSizeX() / 0.8) - 5);

        $i = 0;
        foreach ($scaledSizes as $sizeX) {
            $label = new \ManiaLib\Gui\Elements\Label($sizeX, 4);
            $label->setAlign('left', 'center');
            $label->setScale(0.8);
            $this->frame->addComponent($label);
            $this->labels[$i] = $label;
            $i++;
        }
    }

    public function onResize($oldX, $oldY) {
        parent::onResize($oldX, $oldY);
        $scaledSizes = Gui::getScaledSize($this->getWidths(), ($this->getSizeX() / 0.8) - 5);
        $i = 0;
        foreach ($scaledSizes as $sizeX) {
            $this->labels[$i]->setSizeX($sizeX);
            $i++;
        }

        $this->pager->setSize($this->getSizeX() - 4, $this->getSizeY() - 7);
        foreach ($this->items as $item)
            $item->setSizeX($this->getSizeX());
    }

    public function onShow() {
        $i = 0;
        foreach ($this->labels as $label) {
            $label->setText(__($this->getLabel($i), $this->getRecipient()));
            $i++;
        }
    }

    public function destroy() {
        foreach ($this->items as $item) {
            $item->erase();
        }
        $this->items = null;
        $this->pager->destroy();
        $this->labels = null;
        $this->clearComponents();
        parent::destroy();
    }

    abstract protected function getWidths();

    abstract protected function getLabel($i);
    
    abstract protected function getKeys();
    
    public function populateList($data) {
        $x = 0;
        $login = $this->getRecipient();

        while ($x < sizeof($data)) {
            $this->items[$x] = new Item($x, $login, $data[$x], $this->getWidths(), $this->getKeys());
            $this->pager->addItem($this->items[$x]);
            $x++;
        }
    }
}

?>
