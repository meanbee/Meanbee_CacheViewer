<?php
class Meanbee_CacheViewer_Block_Adminhtml_Report extends Mage_Adminhtml_Block_Template
{
    /**
     * @var null
     */
    public $_total_cache_size_bytes = null;

    /**
     * @var array
     */
    public $_cache_items = array();

    /**
     * Regular expressions used to organise tags into groups.
     *
     * @var array
     */
    public $_cache_types = array(
        "Block HTML" => array(
            "/BLOCK_HTML$/"
        ),
        "Locale Data" => array(
            "/Zend_Locale$/"
        ),
        "Layout" => array(
            "/LAYOUT_GENERAL_/"
        ),
        "Configuration" => array(
            "/CONFIG$/"
        )
    );

    /**
     *
     */
    public function _construct()
    {
        parent::_construct();

        if (!$this->hasData('template')) {
            $this->setData('template', 'meanbee/cacheviewer/report.phtml');
        }
    }

    /**
     * @return Meanbee_CacheViewer_Model_CacheItemInfo[]
     */
    public function getCacheItems()
    {
        if (count($this->_cache_items) == 0) {
            $this->_total_cache_size_bytes = 0;

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

                $this->_total_cache_size_bytes += $bytes;

                $cache_items[] = $cache_item;
            }

            $this->_cache_items = $cache_items;
        }

        return $this->_cache_items;
    }

    /**
     * @return Zend_Cache_Core
     */
    protected function _getCache()
    {
        return Mage::app()->getCache();
    }

    /**
     * Turns seconds into 2m4d1h45m3s, for example.  If the year component is greater than zero, then we just
     * return "forever".
     *
     * @param int $raw_seconds
     * @return string
     */
    public function getAsTimeUnits($raw_seconds)
    {
        $date_interval_parts = array('y' => 'y', 'm' => 'm', 'd' => 'd', 'h' => 'h', 'i' => 'm', 's' =>'s');
        $date_interval = Meanbee_CacheViewer_Model_DateInterval::createFromSeconds($raw_seconds);
        $date_interval->recalculate();

        $return_string = '';

        if ($date_interval->y == 0) {
            foreach ($date_interval_parts as $member => $output) {
                if ($date_interval->$member > 0) {
                    $return_string .= sprintf("%s%s", $date_interval->$member, $output);
                }
            }
        } else {
            $return_string = "forever";
        }

        return $return_string;
    }

    /**
     * @return double
     */
    public function getUsedCacheSizeInMb()
    {
        if ($this->_total_cache_size_bytes === null) {
            $this->getCacheItems();
        }

        return ($this->_total_cache_size_bytes / 1024 / 1024);
    }

    /**
     * @return double
     */
    public function getTotalCacheSizeInMb()
    {
        return ($this->getUsedCacheSizeInMb() / $this->getCacheFullPercentage()) * 100;
    }

    /**
     * @return int
     */
    public function getCacheFullPercentage()
    {
        return $this->_getCache()->getFillingPercentage();
    }

    /**
     * @return string
     */
    public function getCacheBackend()
    {
        return get_class($this->_getCache()->getBackend());
    }

    /**
     * @return array
     */
    public function getCacheStatistics()
    {
        $cache_tag_sizes = array();

        foreach ($this->getCacheItems() as $cache_item) {
            $matched = false;

            /** @var Meanbee_CacheViewer_Model_CacheItemInfo $cache_item */
            foreach ($this->_cache_types as $cache_tag_category => $cache_tag_regexes) {

                if (!isset($cache_tag_sizes[$cache_tag_category])) {
                    $cache_tag_sizes[$cache_tag_category] = 0;
                }

                foreach ($cache_tag_regexes as $cache_tag_regex) {
                    foreach ($cache_item->getTags() as $cache_item_tag) {
                        if (preg_match($cache_tag_regex, $cache_item_tag)) {
                            $cache_tag_sizes[$cache_tag_category] +=  $cache_item->getSize();
                            $matched = true;

                            break(2);
                        }
                    }
                }
            }

            if (!$matched) {
                $cache_tag_sizes["Other"] = $cache_item->getSize();
            }
        }

        return $cache_tag_sizes;
    }

    /**
     * @return array
     */
    public function getCacheStatisticsGoogleChartsFormat()
    {
        $data_structure = array();

        $data_structure[] = array('Cache Type', 'Usage');

        foreach ($this->getCacheStatistics() as $name => $value) {
            $data_structure[] = array($name, $value);
        }

        return $data_structure;
    }
}
