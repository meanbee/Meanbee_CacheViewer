<?php
class Meanbee_CacheViewer_Adminhtml_Meanbee_CacheviewerController extends Mage_Adminhtml_Controller_Action
{
    public function reportAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle("Meanbee CacheViewer");
        $this->renderLayout();
    }
}
