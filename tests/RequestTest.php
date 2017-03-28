<?php
/**
 * Date: 21.03.2017
 * Time: 23:01
 */

namespace Hector68\VkMarketExport\Tests;


use getjump\Vk\Core;
use getjump\Vk\RequestTransaction;
use getjump\Vk\Response\Api;
use getjump\Vk\Response\Response;
use Hector68\VkMarketExport\config\VkConfig;
use Hector68\VkMarketExport\models\Album;
use Hector68\VkMarketExport\models\Goods;
use Hector68\VkMarketExport\models\GoodsInterface;
use Hector68\VkMarketExport\request\Market;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VkConfig
     */
    private $config;

    /***
     * @var Market
     */
    private $market;


    /**
     * @var Api
     */
    private $api;

    /**
     * @var RequestTransaction
     */
    private $transaction;

    /**
     * @var Core
     */
    private $core;
    
    private $serializeGoods = '[{"id":667266,"owner_id":-142990755,"title":"\u0418\u0437\u043c\u0435\u043d\u0435\u043d\u043e\u0435 \u043d\u0430\u0437\u0432\u0430\u043d\u0438\u0435","description":"\u041e\u043f\u0438\u0441\u0430\u043d\u0438\u0435 \u043f\u0440\u043e\u0434\u0443\u043a\u0442\u0430","price":{"amount":"66600","currency":{"id":643,"name":"RUB"},"text":"666 \u0440\u0443\u0431."},"category":{"id":1,"name":"\u0416\u0435\u043d\u0441\u043a\u0430\u044f \u043e\u0434\u0435\u0436\u0434\u0430","section":{"id":0,"name":"\u0413\u0430\u0440\u0434\u0435\u0440\u043e\u0431"}},"date":1490210040,"thumb_photo":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6b1ac\/A8Stzyv3ceM.jpg","availability":0,"albums_ids":[],"photos":[{"id":456239022,"album_id":-53,"owner_id":-142990755,"user_id":5713880,"photo_75":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6b1a4\/pH57hFzAgx0.jpg","photo_130":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6b1a5\/RbnnvQ5LTgo.jpg","photo_604":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6b1a6\/M-Zn8mcNwzw.jpg","width":480,"height":557,"text":"","date":1490210039}],"can_comment":1,"can_repost":1,"likes":{"user_likes":0,"count":0},"views_count":1},{"id":667259,"owner_id":-142990755,"title":"\u0412\u0442\u043e\u0440\u043e\u0439 \u0442\u0435\u0441\u0442\u043e\u0432\u044b\u0439 \u043f\u0440\u043e\u0434\u0443\u043a\u0442","description":"\u041e\u043f\u0438\u0441\u0430\u043d\u0438\u0435 \u043f\u0440\u043e\u0434\u0443\u043a\u0442\u0430","price":{"amount":"56400","currency":{"id":643,"name":"RUB"},"text":"564 \u0440\u0443\u0431."},"category":{"id":1,"name":"\u0416\u0435\u043d\u0441\u043a\u0430\u044f \u043e\u0434\u0435\u0436\u0434\u0430","section":{"id":0,"name":"\u0413\u0430\u0440\u0434\u0435\u0440\u043e\u0431"}},"date":1490209864,"thumb_photo":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6b13c\/Hu1vbA2nrts.jpg","availability":0,"albums_ids":[],"photos":[{"id":456239021,"album_id":-53,"owner_id":-142990755,"user_id":5713880,"photo_75":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6b130\/LiSwDM9j38U.jpg","photo_130":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6b131\/wsQ0f3dl_d4.jpg","photo_604":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6b132\/AScjZObviJo.jpg","photo_807":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6b133\/__kCUYeRMqM.jpg","photo_1280":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6b134\/oHKMtGj1SpA.jpg","photo_2560":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6b135\/4jWuzPJxeKM.jpg","width":2000,"height":945,"text":"","date":1490209864}],"can_comment":1,"can_repost":1,"likes":{"user_likes":0,"count":0},"views_count":1},{"id":661125,"owner_id":-142990755,"title":"\u041f\u0440\u043e\u0434\u0443\u043a\u0442-24","description":"\u041e\u043f\u0438\u0441\u0430\u043d\u0438\u0435 \u043f\u0440\u043e\u0434\u0443\u043a\u0442\u0430 1234\n*\n*\n*","price":{"amount":"99900","currency":{"id":643,"name":"RUB"},"text":"999 \u0440\u0443\u0431."},"category":{"id":606,"name":"\u0414\u0430\u0447\u0430, \u0441\u0430\u0434 \u0438 \u043e\u0433\u043e\u0440\u043e\u0434","section":{"id":6,"name":"\u0414\u043e\u043c \u0438 \u0434\u0430\u0447\u0430"}},"date":1489942722,"thumb_photo":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6ad56\/nV13UbX_Vvk.jpg","availability":0,"albums_ids":[],"photos":[{"id":456239019,"album_id":-53,"owner_id":-142990755,"user_id":5713880,"photo_75":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6ad4d\/wbq7ZNEPmqk.jpg","photo_130":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6ad4e\/rTYtacqqS0c.jpg","photo_604":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6ad4f\/3y3Oxwj5I8k.jpg","photo_807":"https:\/\/pp.userapi.com\/c626125\/v626125880\/6ad50\/LLc0tYYCPYA.jpg","width":773,"height":771,"text":"","date":1490119357}],"can_comment":1,"can_repost":1,"likes":{"user_likes":0,"count":0},"views_count":3}]';

    private $serializeAddAlbumResponse = '{"market_album_id":1}';

    protected function setUp()
    {
        $this->config = include(dirname(__FILE__) . '/config.php');
        $this->market = new Market($this->config);
        
    }

    protected function setMock()
    {
        $this->api = $this->getMockBuilder(Api::class)
            ->setMethods(['getResponse'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->transaction = $this->getMockBuilder(RequestTransaction::class)
            ->setMethods(['fetchData', 'getResponse'])
            ->disableAutoload()
            ->disableOriginalConstructor()
            ->getMock();

        $this->core = $this->getMockBuilder(Core::class)
            ->setMethods(['request', 'getInstance'])
            ->disableAutoload()
            ->disableOriginalConstructor()
            ->getMock();
    }
    

    public function testGetAllProduct()
    {
        $this->setMock();
        $this->api->error = false;
        $dataFromVk = json_decode($this->serializeGoods);
        
        $this->api->expects($this->any())->method('getResponse')->will($this->returnValue($dataFromVk));
        $this->transaction->error = false;
        $this->transaction->expects($this->any())->method('fetchData')->will($this->returnValue($this->api));
       
        $this->core->expects($this->any())->method('request')->will($this->returnValue($this->transaction));
        $this->market->setVkApi($this->core);

        
        $result = $this->market->getAllGoods();

        $this->assertCount(3, $result);

        $first = array_shift($result);

        $this->assertInstanceOf(GoodsInterface::class, $first);

    }

    public function testAddGoodsToAlbum()
    {
        \PHPUnit_Framework_Error_Warning::$enabled = FALSE;
        $goods = new Goods('671977', $this->config->getGroupOwnerId(), 'Title', 'Description', 999, 1, 0, 0 );
        $album = new Album($this->config->getGroupOwnerId(), 'Title', null, null, 2);
        $this->market->addToAlbum($goods, [$album]);
    }


    public function testAlbumAdd()
    {
        $this->setMock();
        $this->api->error = false;
        $dataFromVk = json_decode($this->serializeAddAlbumResponse);

        $this->api->expects($this->any())->method('getResponse')->will($this->returnValue($dataFromVk));
        $this->transaction->error = false;
        $this->transaction->expects($this->any())->method('fetchData')->will($this->returnValue($this->api));

        $this->core->expects($this->any())->method('request')->will($this->returnValue($this->transaction));
        $this->market->setVkApi($this->core);

        $album = new Album($this->config->getGroupOwnerId(), 'Тестовый альбом2');
       $result = $this->market->saveAlbum($album);

        $this->assertNotFalse($result);
        
    }

    
    public function testPhotoUpload()
    {
        
    }
    
    
}