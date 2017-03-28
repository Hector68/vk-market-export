<?php
namespace Hector68\VkMarketExport\Tests;

use getjump\Vk\Core;
use getjump\Vk\RequestTransaction;
use Hector68\VkMarketExport\config\VkConfig;
use Hector68\VkMarketExport\request\Market;


class ObjectTests extends \PHPUnit_Framework_TestCase
{

    /**
     * @var VkConfig
     */
    private $config;

    /***
     * @var Market
     */
    private $request;

    protected function setUp()
    {
        $this->config = include(dirname(__FILE__) . '/config.php');
        $this->request = new Market($this->config);

    }

    public function testApiVk()
    {
        $api = $this->request->getVkApi();
        $this->assertInstanceOf(Core::class, $api);

    }


}