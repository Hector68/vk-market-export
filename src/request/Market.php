<?php

namespace Hector68\VkMarketExport\request;


use getjump\Vk\Auth;
use getjump\Vk\Core;
use Hector68\VkMarketExport\config\VkConfig;
use Hector68\VkMarketExport\exceptions\VkValidateException;
use Hector68\VkMarketExport\models\AlbumInterface;
use Hector68\VkMarketExport\models\Goods;
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
            $this->vkApi = Core::getInstance()->apiVersion('5.63')->setToken($this->config->getToken());
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

        if ($fetchData->error == false) {
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
     * @return bool
     * @throws VkValidateException
     */
    public function uploadPhotoGoods($filePath, $is_main = true)
    {
        $validation = new Validator();

        $validation->add([
            'group_id' => 'required | integer',
            'main_photo' => 'required | integer',
            'filePath' => 'required | File\Image | File\ImageHeight({"min":400,"max":14000}) | File\ImageWidth({"min":400,"max":14000})'
        ]);

        $serverData = [
            'group_id' => $this->config->getGroupId(),
            'main_photo' => $is_main
        ];

        if ($validation->validate(array_merge($serverData, ['filePath' => $filePath]))) {
            $server = $this
                ->getVkApi()
                ->request(
                    'photos.getMarketUploadServer',
                    $serverData
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
        } else {
            $error = $this->getValidateErrorMessage($validation->getMessages());
            throw new VkValidateException($error);
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
        $validation = new Validator();
        $validation->add([
            'owner_id' => 'required | integer',
            'name' => 'required | minLength(4) | maxLength(100)',
            'description' => 'required | minLength(10)',
            'category_id' => 'required | integer',
            'price' => 'required | number',
            'deleted' => 'required | integer',
            'main_photo_id' => 'required | integer'
        ]);

        $fetchData = $this
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

        if ($fetchData->error == false) {
            $result = $fetchData->getResponse();
            return $result->market_item_id;
        }
        return false;
    }

     /**
     * Удаляет продукт
     * @param Goods $goods
     *
     * @return bool
     */
    public function deleteOneGoods(Goods $goods)
    {
        $fetchData = $this->getVkApi()
                          ->request(
                              'market.delete',
                              [
                                  'owner_id' => $goods->getOwnerId(),
                                  'item_id' => $goods->getId()
                              ]
                          )
                          ->fetchData();
        if ($fetchData->error == false) {
            return true;
        }

        return false;
    }

    /***
     * Обновляет продукт
     *
     * @param GoodsInterface $goods
     * @return bool
     * @throws VkValidateException
     */
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
            $fetchData = $this->getVkApi()->request('market.edit', $data)->fetchData();

            if ($fetchData->error == false) {
                $result = $fetchData->getResponse();
                return (bool) $result;
            }
        } else {
            $error = $this->getValidateErrorMessage($validation->getMessages());
            throw new VkValidateException($error);
        }

        return false;
    }

    /**
     * Сохраняет альбом
     * @param AlbumInterface $album
     * @return mixed
     * @throws VkValidateException
     */
    public function saveAlbum(AlbumInterface $album)
    {
        $validation = new Validator();
        $validation->add([
            'owner_id' => 'required | integer',
            'title' => 'required | minLength(1) | maxLength(128)',
            'photo_id' => 'integer',
            'main_album' => 'integer'
        ]);

        $data = [
            'owner_id' => $album->getOwnerId(),
            'title' => $album->getTitle(),
            'photo_id' => $album->getPhotoId(),
            'main_album' => $album->isMainAlbum()
        ];

        if ($validation->validate($data)) {
            $fetchData = $this->getVkApi()->request('market.addAlbum', $data)->fetchData();
            if ($fetchData->error == false) {
                $result = $fetchData->getResponse();
                return $result->market_album_id;
            }
        } else {
            $error = $this->getValidateErrorMessage($validation->getMessages());
            throw new VkValidateException($error);
        }
    }

    /**
     * Добавляет товар в альбом
     * @param GoodsInterface $goods
     * @param AlbumInterface[] $albums
     * @return bool
     * @throws VkValidateException
     */
    public function addToAlbum(GoodsInterface $goods, array $albums)
    {
        $validation = new Validator();
        $validation->add([
            'owner_id' => 'required | integer',
            'item_id' => 'required | integer',
            'album_ids' => 'required',
        ]);

        $albumsIdsArray = [];
        foreach ($albums as $album) {
            $albumsIdsArray[] = $album->getId();
        }

        $data = [
            'owner_id' => $goods->getOwnerId(),
            'item_id' => $goods->getId(),
            'album_ids' => implode(',', $albumsIdsArray),
        ];

        if ($validation->validate($data)) {
            $fetchData = $this->getVkApi()->request('market.addToAlbum', $data)->fetchData();
            if ($fetchData->error == false) {
                $result = $fetchData->getResponse();
                return (bool) $result;
            }
        } else {
            $error = $this->getValidateErrorMessage($validation->getMessages());
            throw new VkValidateException($error);
        }
        
        return false;
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
            $result[] = $tmp . implode(', ', $errorsElErrors);
        }
        return implode('; ', $result);
    }


}