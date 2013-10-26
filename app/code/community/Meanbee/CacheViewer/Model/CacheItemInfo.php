<?php
/**
 * Class Meanbee_CacheViewer_Model_CacheItemInfo
 *
 * @method setId
 * @method getId
 * @method setExpires
 * @method setModified
 * @method getTags
 * @method setTags
 * @method getSize
 * @method setSize
 */
class Meanbee_CacheViewer_Model_CacheItemInfo extends Varien_Object
{
    /**
     * @param null $now
     * @return mixed
     */
    public function getLifetime($now = null)
    {
        if ($now === null) $now = time();

        return $this->getExpires()
            ->sub(new Zend_Date())
            ->toValue(Zend_Date::TIMESTAMP);
    }

    /**
     * @return float
     */
    public function getSizeAsKb()
    {
        return $this->getSize() / 1024;
    }

    /**
     * @return float
     */
    public function getSizeAsMb()
    {
        return $this->getSizeAsKb() / 1024;
    }

    /**
     * @return Zend_Date
     */
    public function getModified()
    {
        return new Zend_Date(parent::getModified());
    }

    public function getExpires()
    {
        return new Zend_Date(parent::getExpires());
    }
}
