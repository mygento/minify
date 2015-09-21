<?php

/**
 *
 *
 * @category Mygento
 * @package Mygento_Minify
 * @copyright Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 * @license Apache-2.0
 */
class Mygento_Minify_Helper_Rewrite_Core_Data extends Mage_Core_Helper_Data
{

    /**
     * Merge specified files into one
     *
     * By default will not merge, if there is already merged file exists and it
     * was modified after its components
     * If target file is specified, will attempt to write merged contents into it,
     * otherwise will return merged content
     * May apply callback to each file contents. Callback gets parameters:
     * (<existing system filename>, <file contents>)
     * May filter files by specified extension(s)
     * Returns false on error
     *
     * @param array $srcFiles
     * @param string|false $targetFile - file path to be written
     * @param bool $mustMerge
     * @param callback $beforeMergeCallback
     * @param array|string $extensionsFilter
     * @return bool|string
     */
    public function mergeFiles(array $srcFiles, $targetFile = false, $mustMerge = false, $beforeMergeCallback = null, $extensionsFilter = array())
    {
        $content_type = pathinfo($targetFile, PATHINFO_EXTENSION);
        if (!Mage::getStoreConfig('minify/general/enabled') || ($content_type != 'css' && $content_type != 'js')) {
            return parent::mergeFiles($srcFiles, $targetFile, $mustMerge, $beforeMergeCallback, $extensionsFilter);
        }
        if (!Mage::getStoreConfig('minify/general/' . $content_type)) {
            return parent::mergeFiles($srcFiles, $targetFile, $mustMerge, $beforeMergeCallback, $extensionsFilter);
        }
        try {
            $shouldMinify = $this->shouldMinify($mustMerge, $targetFile, $srcFiles);
            if ($shouldMinify) {
                $result = parent::mergeFiles($srcFiles, false, $mustMerge, $beforeMergeCallback, $extensionsFilter);
                Varien_Profiler::start('minify_file_' . $targetFile);
                switch ($content_type) {
                    case 'css':
                        $minifier = new MatthiasMullie\Minify\CSS($result);
                    case 'js':
                        $minifier = new MatthiasMullie\Minify\JS($result);
                }
                $minifier->minify($targetFile);
                Varien_Profiler::stop('minify_file_' . $targetFile);
            }
            return true;
        } catch (Exception $e) {
            Mage::logException($e);
        }
        return false;
    }

    protected function shouldMinify($mustMerge, $targetFile, $srcFiles)
    {
        // check whether merger is required
        $shouldMerge = $mustMerge || !$targetFile;
        if (!$shouldMerge) {
            if (!is_file($targetFile)) {
                return true;
            }
            $targetMtime = filemtime($targetFile);
            foreach ($srcFiles as $file) {
                if (!is_file($file) || @filemtime($file) > $targetMtime) {
                    $shouldMerge = true;
                    break;
                }
            }
        }
        return $shouldMerge;
    }
}
