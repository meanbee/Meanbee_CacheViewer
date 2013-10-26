<?php

class Meanbee_CacheViewer_Model_Observer extends Mage_Core_Model_Abstract {

    const EVENT_BEFORE = 'core_block_abstract_to_html_before';
    const EVENT_AFTER  = 'core_block_abstract_to_html_after';

    /**
     * Add cache block status
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function addBlockCacheStatuses(Varien_Event_Observer $observer) {
        $event = $observer->getEvent();
        $block = $event->getBlock();
        $transportObject = $event->getTransport();

        /** @var Meanbee_CacheViewer_Helper_Data $helper */
        $helper = Mage::helper('cacheviewer');

        if (!($block instanceof Mage_Core_Block_Template) || !$helper->isShowCacheStatusOnFrontend()) {
            return;
        }

        if (in_array(get_class($block), array("Mage_Page_Block_Html", "Mage_Adminhtml_Block_Page"))) {
            return;
        }

        // Get cache status
        $cache = Mage::app()->getCache()->test(strtoupper($block->getCacheKey()));
        $lastModified = date(DATE_ATOM, time());
        $blockName = get_class($block);
        $cacheClass = "";


        // If cached, get last modified date and add cached class for css.
        if($cache) {
            $lastModified = date(DATE_ATOM, $cache);
            $cacheClass = " cacheviewer-block-cached";
        }

        // Get transport object passed through event and wrap out hints around it.
        $html = $transportObject->getHtml();
        $html = <<<HTML
<div class="cacheviewer-container">
    <div class="cacheviewer-block{$cacheClass}">
        <div class="cacheviewer-hints">
            <span class="cacheviewer-lastmodified">{$lastModified}</span>
            <span class="cacheviewer-name">{$blockName}</span>
        </div>
    </div>
    {$html}
</div>
HTML;

        $transportObject->setHtml($html);

        return;
    }
}