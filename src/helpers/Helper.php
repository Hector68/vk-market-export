<?php

namespace Hector68\VkMarketExport\helpers;


use getjump\Vk\Auth;
use Hector68\VkMarketExport\config\VkConfig;

class Helper
{

    public static function getTokenLink(VkConfig $config)
    {
        $auth = Auth::getInstance();
        $auth->setAppId($config->getAppId())
            ->setScope($config->getScope())
            ->setSecret($config->getSecret())
            ->setRedirectUri($config->getRedirectUrl()); // SETTING ENV

        return strtr("<a href='%s' target='_top'>LINK</a>", ['%s' => $auth->getUrl()]);
    }


    public static function getTokenString(VkConfig $config)
    {
        $auth = Auth::getInstance();
        $auth->setAppId($config->getAppId())
            ->setScope($config->getScope())
            ->setSecret($config->getSecret())
            ->setRedirectUri($config->getRedirectUrl()); // SETTING ENV

        $callback = $auth->startCallback();

        return empty($callback->token) == false ? $callback->token : false;
    }
}