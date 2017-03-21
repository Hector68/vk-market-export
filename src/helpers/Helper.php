<?php

namespace Hector68\VkMarketExport\helpers;


use Hector68\VkMarketExport\config\VkConfig;
use Hector68\VkMarketExport\request\Market;

class Helper
{

    public static function getTokenLink(VkConfig $config)
    {
        $market = new Market($config);
        return strtr("<a href='%s' target='_top'>LINK</a>", ['%s' => $market->getAuth()->getUrl()]);
    }


    public static function getTokenString(VkConfig $config)
    {
        $market = new Market($config);
        $callback = $market->getAuth()->startCallback();
        return empty($callback->token) == false ? $callback->token : false;
    }
}