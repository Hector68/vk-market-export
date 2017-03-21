<?php
/**
 * Date: 21.03.2017
 * Time: 22:06
 */
require_once __DIR__.'/../vendor/autoload.php';


use Hector68\VkMarketExport\helpers\Helper;

if(is_file(__DIR__.'/_get_config.php')) {

    $config = require __DIR__.'/_get_config.php';

    echo Helper::getTokenLink($config);

}