<?php


use Hector68\VkMarketExport\config\VkConfig;

if(is_file(dirname(__FILE__) . '/_get_config.php')) {
    return include(dirname(__FILE__) . '/_get_config.php');
}
return new VkConfig(
    1111111,
    '111111111111',
    'http://vk-export.dev/tests/test_get_token.php',
    '11111',
    '11111111111111111111111111111111111111111111111111111111111111111'
);