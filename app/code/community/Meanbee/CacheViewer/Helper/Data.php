<?php

class Meanbee_CacheViewer_Helper_Data extends Mage_Core_Helper_Abstract {

    const XML_PATH_CACHEVIEWER_BLOCKS_VIEW_FRONTEND = "cacheviewer/blocks/view_frontend";

    public function isShowCacheStatusOnFrontend() {
        return Mage::getStoreConfigFlag(self::XML_PATH_CACHEVIEWER_BLOCKS_VIEW_FRONTEND);
    }

}