<?php

namespace Hector68\VkMarketExport\Tests;

use GuzzleHttp\Exception\ClientException;
use Hector68\VkMarketExport\config\VkConfig;
use Hector68\VkMarketExport\helpers\Helper;

class HelpTest  extends \PHPUnit_Framework_TestCase
{

    /**
     * @var VkConfig
     */
    private $config;

    protected function setUp()
    {
        $this->config = include(dirname(__FILE__) . '/config.php');
    }

    public function testGetTokenLink()
    {
        $link = Helper::getTokenLink($this->config);
        $this->assertStringStartsWith('<a', $link);
    }

    public function testGetToken()
    {
        $result = Helper::getTokenString($this->config);
        $this->assertFalse($result);

        $_GET['code'] = '06b0fe6e788f9fcfa7';
        $this->setExpectedException(ClientException::class);
        $result = Helper::getTokenString($this->config);
        $this->assertFalse($result);
    }


}