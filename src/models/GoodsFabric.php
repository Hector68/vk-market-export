<?php
/**
 * Date: 22.03.2017
 * Time: 20:51
 */

namespace Hector68\VkMarketExport\models;


use Hector68\VkMarketExport\config\VkConfig;
use Hector68\VkMarketExport\request\Market;

class GoodsFabric implements GoodsFabricInterface
{

    /**
     * @param $response
     * @return GoodsInterface
     */
    public static function setProductFromResponse($response)
    {
        $photos = [];
        
        foreach ($response->photos as $photo) {
            $photos[$photo->id] = $photo->id;
        }

        $mainPhoto = array_shift($photos);
        
        return new Goods(
            $response->id,
            $response->owner_id,
            $response->title,
            $response->description,
            $response->price->amount,
            $response->category->id,
            ($response->availability * -1),
            $mainPhoto,
            $photos
        );
    }
    
    
    public static function newGoods(VkConfig $config, $title, $description, $price, $filePath, $categoryId = 1, $deleted = 0)
    {
        $market = new Market($config);
        
        $photoId = $market->uploadPhotoGoods($filePath);

        return new Goods(
            null,
            $config->getGroupOwnerId(),
            $title,
            $description,
            $price,
            $categoryId,
            $deleted,
            $photoId,
            []
        );
    }


}