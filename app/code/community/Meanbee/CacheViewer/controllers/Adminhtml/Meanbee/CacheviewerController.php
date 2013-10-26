<?php
class Meanbee_CacheViewer_Adminhtml_Meanbee_CacheviewerController extends Mage_Adminhtml_Controller_Action
{
    public function reportAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle("Meanbee CacheViewer");
        $this->renderLayout();
    }

    public function view_singleAction()
    {
        $cache_id = $this->getRequest()->getParam('cache_id');

        $cache_data = Mage::app()->getCache()->load($cache_id);

        $this->getResponse()->setBody(($cache_data) ? Mage::helper('core')->escapeHtml($cache_data) : '(false/empty)');
    }

    public function delete_singleAction()
    {
        $cache_id = $this->getRequest()->getParam('cache_id');
        Mage::app()->getCache()->remove($cache_id);

        Mage::getSingleton('adminhtml/session')->addSuccess("Cache entry deleted");

        $this->getResponse()->setHttpResponseCode(200);
    }
}
