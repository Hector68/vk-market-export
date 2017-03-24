# !!! Библиотека только пишется, не используйте в продакшене. Для ускорения купите пиво, или хотя бы сделайте пулл реквесты.

# vk-market-export
[![Build Status](https://travis-ci.org/Hector68/vk-market-export.svg?branch=master)](https://travis-ci.org/Hector68/vk-market-export) [![Coverage Status](https://coveralls.io/repos/github/Hector68/vk-market-export/badge.svg?branch=master)](https://coveralls.io/github/Hector68/vk-market-export?branch=master)

Экспортирует продукты в vk

Для тестов создайте свое приложение и сделайте локальный конфиг `tests/_get_config.php`
```
use Hector68\VkMarketExport\config\VkConfig;

return new VkConfig(
    >>>AppId<<<,
    >>>AppSecret<<<,
    'http://localserver.dev/tests/test_get_token.php',
    '>>>GroupId<<<',
    >>>token<<< // Можно получить пройдя по ссылке 'http://localserver.dev/tests/test_get_link.php'
);
```


### сохрание продукта
```
$config =  require __DIR__.'/tests/_get_config.php';

$market = new Market($config);

$goods = GoodsFabric::newGoods(
    $config,
    'Второй тестовый продукт',
    'Описание продукта',
    256,
    __DIR__.'/G1J0oFX6OJQ.jpg'
);

```


### Изменение продукта

```
/**
 * @var $firstGoods Goods
 */
$firstGoods = array_shift($allGoods);
$firstGoods->setTitle('Измененое название');
$firstGoods->setPrice(666);

$market->updateProduct($firstGoods);
```