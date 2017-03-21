# vk-market-export

[![Coverage Status](https://coveralls.io/repos/github/Hector68/vk-market-export/badge.svg?branch=master)](https://coveralls.io/github/Hector68/vk-market-export?branch=master)

Экспортирует продукты в vk

Для тестов создайте свое приложение и сделайте локальный конфиг
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