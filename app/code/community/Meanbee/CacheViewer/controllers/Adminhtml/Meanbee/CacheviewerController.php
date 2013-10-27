<?php
class Meanbee_CacheViewer_Adminhtml_Meanbee_CacheviewerController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Route: /admin/meanbee_cacheviewer/report/
     *
     * Show the cache report.
     */
    public function reportAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle("Meanbee CacheViewer");
        $this->renderLayout();
    }

    /**
     * Route: /admin/meanbee_cacheviewer/view_single/
     * Params: cache_id
     *
     * Fetch the value of a given cache key.
     */
    public function view_singleAction()
    {
        $cache_id = $this->getRequest()->getParam('cache_id');

        $cache_data = Mage::app()->getCache()->load($cache_id);

        $this->getResponse()->setBody(($cache_data) ? Mage::helper('core')->escapeHtml($cache_data) : '(false/empty)');
    }

    /**
     * Route: /admin/meanbee_cacheviewer/delete_single/
     * Params: cache_id
     *
     * Delete a single cache entry.
     */
    public function delete_singleAction()
    {
        $cache_id = $this->getRequest()->getParam('cache_id');
        Mage::app()->getCache()->remove($cache_id);

        Mage::getSingleton('adminhtml/session')->addSuccess("Cache entry deleted");

        $this->getResponse()->setHttpResponseCode(200);
    }
}
