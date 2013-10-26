<?php

class Meanbee_CacheViewer_Model_Observer extends Mage_Core_Model_Abstract {

    const EVENT_BEFORE = 'core_block_abstract_to_html_before';
    const EVENT_AFTER  = 'core_block_abstract_to_html_after';

    /** @var Meanbee_CacheViewer_Helper_Data */
    protected $_helper;

    protected $_dispatch_start_time;

    public function _construct() {
        parent::_construct();

        $this->_helper = Mage::helper('cacheviewer');
    }

    /**
     * Add cache block status
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function addBlockCacheStatuses(Varien_Event_Observer $observer) {
        $event = $observer->getEvent();
        $block = $event->getBlock();
        $transportObject = $event->getTransport();

        if (!$this->_helper->isShowCacheStatusOnFrontend()) {
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
<div class="cacheviewer-container clearer">
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

    /**
     * Start the timer for tracking dispatch time.
     * Observe: controller_action_predispatch
     *
     * @param Varien_Event_Observer $observer
     */
    public function startTimer(Varien_Event_Observer $observer) {
        $this->_dispatch_start_time = microtime(true);
    }

    /**
     * Stop the timer tracking dispatch time and set the elapsed time in a cookie.
     *
     * @param Varien_Event_Observer $observer
     */
    public function stopTimer(Varien_Event_Observer $observer) {
        $dispatch_finish_time = microtime(true);

        $elapsed_time = $dispatch_finish_time - $this->_dispatch_start_time;

        if ($this->_helper->isShowCacheStatusOnFrontend()) {
            Mage::getSingleton('core/cookie')->set("cacheviewer_dispatch_time", sprintf("%.3fs", $elapsed_time), 0, null, null, null, false);
        }
    }
}
