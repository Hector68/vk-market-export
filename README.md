# vk-market-export



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