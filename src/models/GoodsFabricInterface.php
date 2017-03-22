<?php
/**
 * Date: 22.03.2017
 * Time: 20:51
 */

namespace Hector68\VkMarketExport\models;


interface GoodsFabricInterface
{
    /**
     * @param $response
     * @return GoodsInterface
     */
    public static function setProductFromResponse($response);
}