<?php

namespace Hector68\VkMarketExport\config;


/**
 * Class VkConfig
 * @package Hector68\VkMarketExport\config
 */
class VkConfig
{
    /**
     * @var
     */
    protected $appId;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $redirectUrl;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $scope;

    /**
     * @var string
     */
    protected $groupId;


    /**
     * VkConfig constructor.
     * @param $appId
     * @param string $secret
     * @param string $redirectUrl
     * @param string $groupId
     * @param string $token
     * @param string $scope
     */
    public function __construct($appId, $secret, $redirectUrl, $groupId, $token = '', $scope = 'offline,market,photos')
    {
        $this->appId = $appId;
        $this->secret = $secret;
        $this->redirectUrl = $redirectUrl;
        $this->groupId = $groupId;
        $this->token = $token;
        $this->scope = $scope;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @return string
     */
    public function getGroupId()
    {
        return $this->groupId;
    }
    
    /**
     * @return string
     */
    public function getGroupOwnerId()
    {
        return '-'.$this->groupId;
    }

   
    
}