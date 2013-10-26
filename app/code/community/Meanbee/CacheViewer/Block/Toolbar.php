<?php

class Meanbee_CacheViewer_Block_Toolbar extends Mage_Core_Block_Template {

    public function _toHtml() {

        if(!Mage::getStoreConfig(Meanbee_CacheViewer_Helper_Data::XML_PATH_CACHEVIEWER_BLOCKS_VIEW_FRONTEND))
            return;

        return parent::_toHtml();
    }
}