<?php

/**
 *
 *
 * @category Mygento
 * @package Mygento_Minify
 * @copyright Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 * @license Apache-2.0
 */
class Mygento_Minify_Test_Config_Rewrite extends EcomDev_PHPUnit_Test_Case_Config
{
    /**
     * @test
     */
    public function testHelperAlias()
    {
        $this->assertHelperAlias('core/data', 'Mygento_Minify_Helper_Rewrite_Core_Data');
    }
}
