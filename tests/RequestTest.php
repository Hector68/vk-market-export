<?php
/**
 * Date: 21.03.2017
 * Time: 23:01
 */

namespace Hector68\VkMarketExport\Tests;


use Hector68\VkMarketExport\config\VkConfig;
use Hector68\VkMarketExport\request\Market;

class RequestTest
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
        $this->config = include(dirname(__FILE__) . '/_get_config.php');
        $this->request = Market::getInstance($this->config);
    }
    
    public function testGetAllProduct()
    {
        $dd = $this->request->getAllGoods();
    }
}