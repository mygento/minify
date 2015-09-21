<?php

/**
 *
 *
 * @category Mygento
 * @package Mygento_Minify
 * @copyright Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 * @license Apache-2.0
 */
class Mygento_Minify_Test_Config_Base extends EcomDev_PHPUnit_Test_Case_Config
{

    /**
     * @test
     */
    public function testValidCodepool()
    {
        $this->assertModuleCodePool('community');
    }

    /**
     * @test
     */
    public function testBlockAlias()
    {
        $this->assertBlockAlias('minify/version', 'Mygento_Minify_Block_Version');
    }

    /**
     * @test
     */
    public function testModelAlias()
    {
        
    }

    /**
     * @test
     */
    public function testConfig()
    {
        $this->assertConfigNodeHasChild('global/helpers', 'minify');
        $this->assertConfigNodeValue('global/helpers/minify/class', 'Mygento_Minify_Helper');
        $this->assertConfigNodeHasChild('global/models', 'minify');
        $this->assertConfigNodeValue('global/models/minify/class', 'Mygento_Minify_Model');
        $this->assertConfigNodeHasChild('global/blocks', 'minify');
        $this->assertConfigNodeValue('global/blocks/minify/class', 'Mygento_Minify_Block');
    }

    /**
     * @test
     */
    public function testDefaults()
    {
        // the module namespace
        $this->assertConfigNodeHasChild('default', 'minify');

        // general presets
        $this->assertConfigNodeHasChild('default/minify', 'general');
        $this->assertConfigNodeHasChild('default/minify/general', 'enabled');
        $this->assertConfigNodeHasChild('default/minify/general', 'debug');

        $this->assertConfigNodeHasChild('default/minify/general', 'css');
        $this->assertConfigNodeHasChild('default/minify/general', 'js');

        $this->assertEquals("0", Mage::getStoreConfig('minify/general/enabled'));
        $this->assertEquals("0", Mage::getStoreConfig('minify/general/debug'));
        $this->assertEquals("1", Mage::getStoreConfig('minify/general/css'));
        $this->assertEquals("1", Mage::getStoreConfig('minify/general/js'));
    }

    /**
     * @test
     */
    public function testModelResourceAlias()
    {
        
    }

    /**
     * @test
     */
    public function testHelperAlias()
    {
        $this->assertHelperAlias('minify', 'Mygento_Minify_Helper_Data');
    }

    /**
     * @test
     */
    public function testEvent()
    {
        
    }
}
