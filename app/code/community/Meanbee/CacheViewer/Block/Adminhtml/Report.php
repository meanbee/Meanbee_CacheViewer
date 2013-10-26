<?php
class Meanbee_CacheViewer_Block_Adminhtml_Report extends Mage_Adminhtml_Block_Template
{
    public function _construct()
    {
        parent::_construct();

        if (!$this->hasData('template')) {
            $this->setData('template', 'meanbee/cacheviewer/report.phtml');
        }
    }

    public function getCacheItems()
    {
        $cache_items = array();

        foreach ($this->_getCache()->getIds() as $cache_id) {
            $meta_data = $this->_getCache()->getMetadatas($cache_id);

            $expires = (int) $meta_data['expire'];
            $mtime = (int) $meta_data['mtime'];

            $bytes = strlen($this->_getCache()->load($cache_id));

            $tags = $meta_data['tags'];

            $cache_item = Mage::getModel('cacheviewer/cacheItemInfo');

            $cache_item->setId($cache_id);
            $cache_item->setExpires($expires);
            $cache_item->setModified($mtime);
            $cache_item->setSize($bytes);
            $cache_item->setTags($tags);

            $cache_items[] = $cache_item;
        }

        return $cache_items;
    }

    /**
     * @return Zend_Cache_Core
     */
    protected function _getCache()
    {
        return Mage::app()->getCache();
    }

    /**
     * Turn seconds into number of hours, minutes, days, etc.
     *
     * @todo implement
     * @param int $raw_seconds
     * @return string
     */
    public function getAsTimeUnits($raw_seconds)
    {
        $minutes = floor($raw_seconds/60);
        $seconds = $raw_seconds % 60;

        return sprintf("%dm%ds", $minutes, $seconds);
    }
}
