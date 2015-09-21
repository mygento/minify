<?php
/**
 *
 *
 * @category Mygento
 * @package Mygento_Minify
 * @copyright Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 * @license Apache-2.0
 */
class Mygento_Minify_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{

    /**
     * @test
     * @return Mygento_Cdn_Helper_Data
     */
    public function checkClass()
    {
        /* @var Mygento_Minify_Helper_Data $helper */
        $helper = Mage::helper('minify');

        $this->assertInstanceOf('Mygento_Minify_Helper_Data', $helper);
        return $helper;
    }
}
