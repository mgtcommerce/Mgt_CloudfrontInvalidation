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

class Mgt_CloudfrontInvalidation_Block_Page_Html_Head extends Mage_Page_Block_Html_Head
{
    protected function &_prepareStaticAndSkinElements($format, array $staticItems, array $skinItems, $mergeCallback = null)
    {
        $designPackage = Mage::getDesign();
        $baseJsUrl = Mage::getBaseUrl('js');
        $items = array();
        if ($mergeCallback && !is_callable($mergeCallback)) {
            $mergeCallback = null;
        }
    
        // get static files from the js folder, no need in lookups
        foreach ($staticItems as $params => $rows) {
            foreach ($rows as $name) {
                $items[$params][] = $mergeCallback ? Mage::getBaseDir() . DS . 'js' . DS . $name : $baseJsUrl . $name;
            }
        }
    
        // lookup each file basing on current theme configuration
        foreach ($skinItems as $params => $rows) {
            foreach ($rows as $name) {
                $items[$params][] = $mergeCallback ? $designPackage->getFilename($name, array('_type' => 'skin'))
                : $designPackage->getSkinUrl($name, array());
            }
        }
    
        $html = '';
        foreach ($items as $params => $rows) {
            // attempt to merge
            $mergedUrl = false;
            if ($mergeCallback) {
                $mergedUrl = call_user_func($mergeCallback, $rows);
            }
            // render elements
            $params = trim($params);
            $params = $params ? ' ' . $params : '';
            if ($mergedUrl) {
                $suffix = $this->_getFileModificationTimeFromUrl($mergedUrl);
                $mergedUrl .= '?q=' . urlencode($suffix);
                $html .= sprintf($format, $mergedUrl, $params);
            } else {
                foreach ($rows as $src) {
                    $suffix = $this->_getFileModificationTimeFromUrl($src);
                    $src .= '?q=' . urlencode($suffix);
                    $html .= sprintf($format, $src, $params);
                }
            }
        }
        return $html;
    }
    
    protected function _getFileModificationTimeFromUrl($url)
    {
        $file = Mage::getBaseDir() . parse_url($url, PHP_URL_PATH);
        return filemtime($file);
    }
}