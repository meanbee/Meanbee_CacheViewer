<?php

class Meanbee_CacheViewer_Block_Toolbar extends Mage_Core_Block_Template {

    public function _toHtml() {

        if(!Mage::getStoreConfig(Meanbee_CacheViewer_Helper_Data::XML_PATH_CACHEVIEWER_BLOCKS_VIEW_FRONTEND))
            return;

        return parent::_toHtml();
    }

    /**
     * Return the configured default cookie path.
     *
     * @return mixed
     */
    protected function getCookiePath() {
        return Mage::getSingleton('core/cookie')->getPath();
    }

    /**
     * Return the configured default cookie domain.
     *
     * @return string
     */
    protected function getCookieDomain() {
        $domain = Mage::getSingleton('core/cookie')->getDomain();
        if (!empty($domain[0]) && ($domain[0] !== '.')) {
            $domain = '.'.$domain;
        }
        return $domain;
    }
}
