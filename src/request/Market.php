<?php
/**
 * Date: 21.03.2017
 * Time: 22:50
 */

namespace Hector68\VkMarketExport\request;


use getjump\Vk\Auth;
use getjump\Vk\Core;
use Hector68\VkMarketExport\config\VkConfig;

class Market
{

    protected static $instance;

    protected $config;

    private $auth;

    private $vkApi;


    /**
     * @return Auth
     */
    public function getAuth()
    {
        if($this->auth === null) {

            $this->auth = Auth::getInstance();
            $this->auth->setAppId($this->config->getAppId())
                ->setScope($this->config->getScope())
                ->setSecret($this->config->getSecret())
                ->setRedirectUri($this->config->getRedirectUrl()); // SETTING ENV

        }
        return  $this->auth;
    }

    /**
     * @return Core
     */
    public function getVkApi()
    {

        if(empty($this->vkApi) === true && empty($this->config->getToken()) === false) {
            $this->vkApi = Core::getInstance()->apiVersion('5.5')->setToken($this->config->getToken());
        }

        return $this->vkApi;
    }

    /**
     * Market constructor.
     * @param $config
     */
    public function __construct(VkConfig $config)
    {
        $this->config = $config;
    }


    public function getAllGoods()
    {
       $data = $this->getVkApi()
            ->request(
                'market.get',
                [
                    'owner_id' => $this->config->getGroupOwnerId(),
                    'extended' => 1
                ]
            )->fetchData();

        $data = 1;
    }


}