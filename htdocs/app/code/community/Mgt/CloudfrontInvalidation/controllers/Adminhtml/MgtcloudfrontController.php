<?php

/**
 * MGT-Commerce GmbH
 * http://www.mgt-commerce.com
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@mgt-commerce.com so we can send you a copy immediately.
 *
 * @category    Mgt
 * @package     Mgt_CloudfrontInvalidation
 * @author      Stefan Wieczorek <stefan.wieczorek@mgt-commerce.com>
 * @copyright   Copyright (c) 2012 (http://www.mgt-commerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mgt_CloudfrontInvalidation_Adminhtml_MgtcloudfrontController extends Mage_Adminhtml_Controller_Action
{
    public function invalidateAction()
    {
        $params = new Varien_Object($this->getRequest()->getParams());
        if ($invalidationPath = $params->getInvalidationPath()) {
            $invalidationPath = explode(',', trim($invalidationPath));
            
            $cloudFront = Mage::getModel('mgt_cloudfront_invalidation/cloudfront');
            $isDebugMode = $cloudFront->isDebugMode();

            $result = $cloudFront->invalidate($invalidationPath);
            $response = $cloudFront->getResponse();
            $reponseData = array(
              'message' => $response->getMessage(),
              'body'    => $response->getBody()
            );
            
            $session = Mage::getSingleton('adminhtml/session');
            if (true === $result) {
                $successMessage = Mage::helper('mgt_cloudfront_invalidation')->__('The purge is in progress and takes about to 10-15 minutes ').'<br />';
                if ($isDebugMode) {
                    $successMessage .= print_r($reponseData, true);
                }
                $session->addSuccess($successMessage);
            } else {
                $errorMessage = Mage::helper('mgt_cloudfront_invalidation')->__('An error has occured while purging the files').'<br />';
                if ($isDebugMode) {
                    $errorMessage .= print_r($reponseData, true);
                }
                $session->addError($errorMessage);
            }
        }
        $this->_redirect('*/cache/index');
    }
}
