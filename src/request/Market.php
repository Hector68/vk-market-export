<?php
/**
 * Date: 21.03.2017
 * Time: 22:50
 */

namespace Hector68\VkMarketExport\request;


use getjump\Vk\Auth;
use getjump\Vk\Core;
use Hector68\VkMarketExport\config\VkConfig;
use Hector68\VkMarketExport\exceptions\VkValidateException;
use Hector68\VkMarketExport\models\GoodsFabric;
use Hector68\VkMarketExport\models\GoodsInterface;
use Sirius\Validation\Validator;

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
        if ($this->auth === null) {

            $this->auth = Auth::getInstance();
            $this->auth->setAppId($this->config->getAppId())
                ->setScope($this->config->getScope())
                ->setSecret($this->config->getSecret())
                ->setRedirectUri($this->config->getRedirectUrl()); // SETTING ENV

        }
        return $this->auth;
    }

    /**
     * @return Core
     */
    public function getVkApi()
    {

        if (empty($this->vkApi) === true && empty($this->config->getToken()) === false) {
            $this->vkApi = Core::getInstance()->apiVersion('5.5')->setToken($this->config->getToken());
        }

        return $this->vkApi;
    }

    /**
     * @param mixed $vkApi
     */
    public function setVkApi($vkApi)
    {
        $this->vkApi = $vkApi;
    }

    /**
     * @param mixed $auth
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
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
        $fetchData = $this->getVkApi()
            ->request(
                'market.get',
                [
                    'owner_id' => $this->config->getGroupOwnerId(),
                    'extended' => 1
                ]
            )
            ->fetchData();

            if($fetchData->error == false) {
                $result = [];
                foreach ($fetchData->getResponse() as $item) {
                    $result[$item->id] = GoodsFabric::setProductFromResponse($item);
                }
                return $result;
            }
        
        return false;
    }


    /**
     * Загружает изображение на сервер, возвратит его id
     * @param $filePath
     * @param bool $is_main
     * @return int|false
     */
    public function uploadPhotoGoods($filePath, $is_main = true)
    {
        /** @todo добавить проверки дополнительные, такие как размер изображения Итд */
        $server = $this
            ->getVkApi()
            ->request(
                'photos.getMarketUploadServer',
                [
                    'group_id' => $this->config->getGroupId(),
                    'main_photo' => $is_main
                ]
            )
            ->fetchData();

        if (empty($server->response->data->upload_url) === false) {
            $serverUrl = $server->response->data->upload_url;
            $client = new \GuzzleHttp\Client();

            $request = $client->request(
                'POST',
                $serverUrl,
                [
                    'multipart' => [

                        [
                            'name' => 'file',
                            'contents' => fopen($filePath, 'r')
                        ]
                    ]
                ]);
            $responseBody = $request->getBody()->getContents();
            $response = json_decode($responseBody);

            if (isset($response->hash)) {

                $result = $this
                    ->getVkApi()
                    ->request(
                        'photos.saveMarketPhoto',
                        [
                            'group_id' => $this->config->getGroupId(),
                            'main_photo' => $is_main,
                            'photo' => $response->photo,
                            'server' => $response->server,
                            'hash' => $response->hash,
                            'crop_data' => $response->crop_data,
                            'crop_hash' => $response->crop_hash
                        ]
                    )->fetchData();

                if (isset($result->response->items[0]->id)) {
                    return $result->response->items[0]->id;
                }
            }
        }
        return false;
    }

    /**
     * Сохраняет продукт
     * @param GoodsInterface $goods
     * @return int|false
     */
    public function saveProduct(GoodsInterface $goods)
    {
        $result = $this
            ->getVkApi()
            ->request(
                'market.add',
                [
                    'owner_id' => $this->config->getGroupOwnerId(),
                    'name' => $goods->getTitle(),
                    'description' => $goods->getDescription(),
                    'category_id' => $goods->getCategoryId(), /** @todo разбиение по категориям */
                    'price' => $goods->getPrice(),
                    'deleted' => $goods->getDeleted(),
                    'main_photo_id' => $goods->getMainPhotoId(),/** @todo дополнительные изображения */
                ]
            )->fetchData();

        if (isset($result->response->data->market_item_id)) {
            return $result->response->data->market_item_id;
        }

        return false;
    }


    public function updateProduct(GoodsInterface $goods)
    {
        $validation = new Validator();
        $validation->add([
            'owner_id' => 'required | integer',
            'item_id' => 'required | integer',
            'name' => 'required | minLength(4) | maxLength(100)',
            'description' => 'required | minLength(10)',
            'category_id' => 'required | integer',
            'price' => 'required | number',
            'deleted' => 'required | integer',
            'main_photo_id' => 'required | integer'
        ]);

        $data = [
            'owner_id' => $this->config->getGroupOwnerId(),
            'item_id' => $goods->getId(),
            'name' => $goods->getTitle(),
            'description' => $goods->getDescription(),
            'category_id' => $goods->getCategoryId(), /** @todo разбиение по категориям */
            'price' => $goods->getPrice(),
            'deleted' => $goods->getDeleted(),
            'main_photo_id' => $goods->getMainPhotoId(),/** @todo дополнительные изображения */
        ];

        if ($validation->validate($data)) {
            $result = $this->getVkApi()->request('market.edit', $data)->fetchData();
        } else {
            $error = $this->getValidateErrorMessage($validation->getMessages());
            throw new VkValidateException($error);
        }


        return $result;

    }


    protected function getValidateErrorMessage($errors)
    {
        $result = [];

        foreach ($errors as $name => $elementErrors) {
            $tmp = $name . ': ';
            $errorsElErrors = [];
            foreach ($elementErrors as $error) {
                $errorsElErrors[] = $error->__toString();
            }
            $result[] = $tmp. implode(', ', $errorsElErrors);
        }
        return implode('; ', $result);
    }


}