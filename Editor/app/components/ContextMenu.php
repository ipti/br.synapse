<?php

Yii::import('zii.widgets.CMenu');

class ContextMenu extends CMenu {

    //need to include this for our function to run
    public function run() {
        $this->renderMenu($this->items);
    }

    protected function renderMenuItem($item) {
        if (isset($item['url'])) {
            $label = $this->linkLabelWrapper === null ? $item['label'] : '<' . $this->linkLabelWrapper . '>' . $item['label'] . '</' . $this->linkLabelWrapper . '>';
            $label .='<blockquote><span>'.$item['description'].'</span></blockquote>';
            return CHtml::link($label, $item['url'], isset($item['linkOptions']) ? $item['linkOptions'] : array());
        }
        else
            return CHtml::tag('span', isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
    }

}

?>
