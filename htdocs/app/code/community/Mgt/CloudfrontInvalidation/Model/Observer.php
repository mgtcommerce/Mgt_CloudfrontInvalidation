<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Mgt
 * @package     Mgt_CloudfrontInvalidation
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @generator   http://www.mgt-commerce.com/kickstarter/ Mgt Kickstarter
 */

class Mgt_CloudfrontInvalidation_Model_Observer 
{
    const XML_CONFIG_PATH_WEB_BASE_UNSECURE_SKIN_URL = 'stores/admin/web/unsecure/base_skin_url';
    const XML_CONFIG_PATH_WEB_BASE_SECURE_SKIN_URL = 'stores/admin/web/secure/base_skin_url';
    
    const XML_CONFIG_PATH_WEB_BASE_UNSECURE_JS_URL = 'stores/admin/web/unsecure/base_js_url';
    const XML_CONFIG_PATH_WEB_BASE_SECURE_JS_URL = 'stores/admin/web/secure/base_js_url';
    
    const XML_CONFIG_PATH_WEB_BASE_UNSECURE_MEDIA_URL = 'stores/admin/web/unsecure/base_media_url';
    const XML_CONFIG_PATH_WEB_BASE_SECURE_MEDIA_URL = 'stores/admin/web/secure/base_media_url';
    
    const XML_CONFIG_PATH_DEV_JS_MERGE_FILES = 'stores/admin/dev/js/merge_files';
    const XML_CONFIG_PATH_DEV_CSS_MERGE_FILES = 'stores/admin/dev/css/merge_css_files';
    const ADMIN_STORE_ID = 0;
    const DISABLE_MERGING = 0;
    
    static protected $_modified;
    
    public function modifyBaseUrl(Varien_Event_Observer $observer)
    {
        if (!self::$_modified) {
             $config = Mage::getConfig();

             $adminStore = Mage::app()->getStore(self::ADMIN_STORE_ID);
                  
             $isSecure = Mage::app()->getStore()->isAdminUrlSecure();
             if (true === $isSecure) {
                 $baseUrl = $adminStore->getConfig(Mage_Core_Model_Store::XML_PATH_SECURE_BASE_URL);
             } else {
                 $baseUrl = $adminStore->getConfig(Mage_Core_Model_Store::XML_PATH_UNSECURE_BASE_URL);
             }
   
             $skinUrl = $baseUrl.'skin/';
             $jsUrl = $baseUrl.'js/';
             $mediaUrl = $baseUrl.'media/';

             $config->setNode(self::XML_CONFIG_PATH_WEB_BASE_UNSECURE_SKIN_URL, $skinUrl);
             $config->setNode(self::XML_CONFIG_PATH_WEB_BASE_SECURE_SKIN_URL, $skinUrl);

             $config->setNode(self::XML_CONFIG_PATH_WEB_BASE_UNSECURE_JS_URL, $jsUrl);
             $config->setNode(self::XML_CONFIG_PATH_WEB_BASE_SECURE_JS_URL, $jsUrl);

             $config->setNode(self::XML_CONFIG_PATH_WEB_BASE_UNSECURE_MEDIA_URL, $mediaUrl);
             $config->setNode(self::XML_CONFIG_PATH_WEB_BASE_SECURE_MEDIA_URL, $mediaUrl);

             $config->setNode(self::XML_CONFIG_PATH_DEV_JS_MERGE_FILES, self::DISABLE_MERGING);
             $config->setNode(self::XML_CONFIG_PATH_DEV_CSS_MERGE_FILES, self::DISABLE_MERGING);

             self::$_modified = true;
        }
    }
}