<?php
/**
 *
 *
 * @category Mygento
 * @package Mygento_Minify
 * @copyright Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 * @license Apache-2.0
 */
class Mygento_Minify_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function addLog($text)
    {
        if (Mage::getStoreConfig('minify/general/debug')) {
            Mage::log($text, null, 'minify.log');
        }
    }

    /**
     * Gzip the data
     *
     * @param  string $path Path to read-write the data to.
     * @param  string $type Content-Type
     */
    public function gzipFile($path, $type)
    {
        Varien_Profiler::start('minify_gzip_file_' . $path);
        $minifier = $this->getMinifier($path, $type);
        $minifier->gzip($path . '.gz');
        Varien_Profiler::stop('minify_gzip_file_' . $path);
    }

    /**
     * Minify the data
     *
     * @param  string $path Path to read-write the data to.
     * @param  string $type Content-Type
     */
    public function minifyFile($path, $type)
    {
        Varien_Profiler::start('minify_file_' . $path);
        $minifier = $this->getMinifier($path, $type);
        $minifier->minify($path . '.min');
        Varien_Profiler::stop('minify_file_' . $path);
    }

    /**
     * Get Minifier
     *
     * @param string $path Path to read-write the data to.
     * @param string $type Content-Type
     * @return \MatthiasMullie\Minify\CSS|\MatthiasMullie\Minify\JS
     */
    private function getMinifier($path, $type)
    {
        if ('text/css' === $type) {
            return new MatthiasMullie\Minify\CSS($path);
        } else {
            return new MatthiasMullie\Minify\JS($path);
        }
    }
}
